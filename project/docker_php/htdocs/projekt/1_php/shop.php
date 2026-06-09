<?php
// ------ Dieser Code wurde mit Unterstützung von ClaudeAI umgesetzt ------

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);

// DB-Verbindung
$conn = new mysqli("db_server", "skate", "1234", "produkt_db");

// Kategorie Filter
$category = $_GET['category'] ?? null;
if ($category) {
    $category = trim($category);
}

// Suche Parameter
$search = $_GET['search'] ?? null;
if ($search) {
    $search = trim($search);
}

// Sort Parameter
$sort = $_GET['sort'] ?? 'default';

$sql = "
    SELECT p.product_id, p.beschreibung, p.preis, p.brand, p.kategorie,
           pic.bildpfad
    FROM product p
    LEFT JOIN picture pic 
        ON pic.product_product_id = p.product_id 
        AND pic.ismain = '1'
";

$whereAdded = false;

// Kategorie Filter
if ($category === 'accessoire') {
    $sql .= " WHERE p.kategorie IN ('accessories', 'griptape')";
    $whereAdded = true;
} elseif ($category) {
    $category = $conn->real_escape_string($category);
    $sql .= " WHERE p.kategorie = '$category'";
    $whereAdded = true;
}

// Marke bekommen
$brandFilter = $_GET['brand'] ?? null;
if ($brandFilter) {
    $brandFilter = trim($brandFilter);
}

// Marken Query
$brandSql = "SELECT DISTINCT TRIM(brand) as brand FROM product";

if ($category === 'accessoire') {
    $brandSql .= " WHERE kategorie IN ('accessories', 'griptape')";
} elseif ($category) {
    $categoryEscaped = $conn->real_escape_string($category);
    $brandSql .= " WHERE kategorie = '$categoryEscaped'";
}

// Suche zur Marken Query hinzufügen
if ($search) {
    $searchEscaped = $conn->real_escape_string($search);
    if (strpos($brandSql, 'WHERE') !== false) {
        $brandSql .= " AND (brand LIKE '%$searchEscaped%' OR product_id IN (SELECT product_id FROM product WHERE beschreibung LIKE '%$searchEscaped%'))";
    } else {
        $brandSql .= " WHERE (brand LIKE '%$searchEscaped%' OR product_id IN (SELECT product_id FROM product WHERE beschreibung LIKE '%$searchEscaped%'))";
    }
}

// Brand Filter zur Hauptquery
if ($brandFilter) {
    $brandEscaped = $conn->real_escape_string($brandFilter);

    if ($whereAdded) {
        $sql .= " AND TRIM(p.brand) = '$brandEscaped'";
    } else {
        $sql .= " WHERE TRIM(p.brand) = '$brandEscaped'";
        $whereAdded = true;
    }
}

// Suche zur Hauptquery
if ($search) {
    $searchEscaped = $conn->real_escape_string($search);
    
    if ($whereAdded) {
        $sql .= " AND (p.beschreibung LIKE '%$searchEscaped%' OR p.brand LIKE '%$searchEscaped%')";
    } else {
        $sql .= " WHERE (p.beschreibung LIKE '%$searchEscaped%' OR p.brand LIKE '%$searchEscaped%')";
    }
}

$brandResult = $conn->query($brandSql);

// Sortierung
if ($sort === 'preis_asc') {
    $sql .= " ORDER BY p.preis ASC";
} elseif ($sort === 'preis_desc') {
    $sql .= " ORDER BY p.preis DESC";
} else {
    $sql .= " ORDER BY p.product_id ASC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/shop.css">
</head>
<body>
    <!-- Navbar -->
    <?php
    echo '
    <div class="navbar">
        <div class="left">
            <div class="logo">
                <a href="../mainpage.php"><img src="../images/logo.png" alt="Logo"></a>
            </div>
            <div class="nav-links">
                <a href="shop.php">Zum Shop</a>
                <a href="konfigurator.php">Zum Konfigurator</a>
            </div>
        </div>
        <div class="right">
            <a href="wunschliste.php" class="navlink">
                <div class="icon">
                    <img src="../images/wishlist.png" alt="Herz">
                    <span>Wunschliste</span>
                </div>
            </a>
            <a href="warenkorb.php" class="navlink">
                <div class="icon">
                    <img src="../images/warenkorb.png" alt="Warenkorb">
                    <span>Warenkorb</span>
                </div>
            </a>
            <div class="profile">
                <a href="#" class="profile-trigger" id="profileTrigger">
                    <img src="../images/profilpic.png" alt="Profil">
                </a>
                <div class="profile-dropdown" id="profileDropdown">
                    ' . ($isLoggedIn ? '
                    <a href="meineBestellungen.php">Meine Bestellungen</a>
                    <a href="wunschliste.php">Wunschliste</a>
                    <a href="logout.php" class="logout">Abmelden</a>
                    ' : '
                    <a href="login.php?login">Anmelden</a>
                    <a href="login.php?register">Registrieren</a>
                    ') . '
                </div>
            </div>
        </div>
    </div>';
    ?>

    <!-- SHOP HEADER -->
    <section class="shop-header">
        <h1>Shop</h1>
        <div class="shop-controls">
            <form id="searchForm" method="GET" action="shop.php" style="display: flex; align-items: center; gap: 10px;">
                <div class="search">
                    <input type="text" id="searchInput" name="search" placeholder="Suche" value="<?= htmlspecialchars($search ?? '') ?>">
                    <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                        <img src="../images/search.png" alt="Suche">
                    </button>
                </div>
                <!-- Hidden Inputs für andere Filter -->
                <?php if ($category): ?>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                <?php endif; ?>
                <?php if ($brandFilter): ?>
                    <input type="hidden" name="brand" value="<?= htmlspecialchars($brandFilter) ?>">
                <?php endif; ?>
                <?php if ($sort !== 'default'): ?>
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                <?php endif; ?>
            </form>
        </div>

        <div class="filter-wrapper">
            <button class="filter-btn" id="brandBtn">Marke ▼</button>
            <div class="filter-dropdown" id="brandDropdown">

                <!-- Alle -->
                <a href="shop.php<?php 
                    $params = [];
                    if ($category) $params[] = 'category=' . $category;
                    if ($search) $params[] = 'search=' . urlencode($search);
                    if (!empty($params)) echo '?' . implode('&', $params);
                ?>">Alle</a>

                <?php while ($row = $brandResult->fetch_assoc()): ?>
                    <a href="shop.php?brand=<?= urlencode(trim($row['brand'])) ?>
                        <?php 
                        if ($category) echo '&category=' . urlencode($category); 
                        if ($search) echo '&search=' . urlencode($search);
                        ?>">
                        <?= htmlspecialchars(trim($row['brand'])) ?>
                    </a>
                <?php endwhile; ?>

            </div>
        </div>
        <!-- Kategorie Dropdown -->
        <div class="category-btn">
            <div class="filter-wrapper">
                <button class="filter-btn" id="categoryBtn">Kategorie ▼</button>
                <div class="filter-dropdown" id="categoryDropdown">
                    <a href="shop.php<?php if ($search) echo '?search=' . urlencode($search); ?>">Alle</a>
                    <a href="shop.php?category=deck<?php if ($search) echo '&search=' . urlencode($search); ?>">Deck</a>
                    <a href="shop.php?category=trucks<?php if ($search) echo '&search=' . urlencode($search); ?>">Trucks</a>
                    <a href="shop.php?category=wheels<?php if ($search) echo '&search=' . urlencode($search); ?>">Wheels</a>
                    <a href="shop.php?category=bearings<?php if ($search) echo '&search=' . urlencode($search); ?>">Bearings</a>
                    <a href="shop.php?category=accessoire<?php if ($search) echo '&search=' . urlencode($search); ?>">Accessoire</a>
                </div>
            </div>
        </div>

        <!-- Sort Dropdown -->
        <div class="category-btn">
            <div class="filter-wrapper">
                <button class="filter-btn" id="sortBtn">Sortieren ▼</button>
                <div class="filter-dropdown" id="sortDropdown">
                    <a href="shop.php<?php 
                        $params = [];
                        if ($category) $params[] = 'category=' . urlencode($category);
                        if ($search) $params[] = 'search=' . urlencode($search);
                        if (!empty($params)) echo '?' . implode('&', $params);
                    ?>">Standard</a>
                    <a href="shop.php?sort=preis_asc<?php 
                        if ($category) echo '&category=' . urlencode($category);
                        if ($search) echo '&search=' . urlencode($search);
                    ?>">Preis ↑</a>
                    <a href="shop.php?sort=preis_desc<?php 
                        if ($category) echo '&category=' . urlencode($category);
                        if ($search) echo '&search=' . urlencode($search);
                    ?>">Preis ↓</a>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUKTE -->
    <section class="shop">
        <div class="product-grid">
            <?php while ($produkt = $result->fetch_assoc()): ?>
            <div class="product-card" onclick="openModal(<?= $produkt['product_id'] ?>)">
                <img src="../<?= htmlspecialchars($produkt['bildpfad']) ?>" 
                     alt="<?= htmlspecialchars($produkt['beschreibung']) ?>">
                <div class="product-info">
                    <h3><?= htmlspecialchars(str_replace('_', ' ', $produkt['brand'])) ?></h3>
                    <p><?= htmlspecialchars($produkt['beschreibung']) ?></p>
                    <span>€ <?= number_format($produkt['preis'], 2, ',', '.') ?></span>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- MODAL -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal()">✕</button>

            <div class="modal-left">
                <div class="modal-img-wrapper">
                    <img id="modalMainImg" src="" alt="">
                </div>
                <div class="modal-thumbnails" id="modalThumbnails"></div>
            </div>

            <div class="modal-right">
                <div class="modal-brand-row">
                    <h2 id="modalBrand"></h2>
                    <button class="modal-wish-btn" id="modalWishBtn" onclick="toggleWunschliste()">♡</button>
                </div>
                <p id="modalBeschreibung"></p>
                <div class="modal-preis" id="modalPreis"></div>

                <div class="modal-info" id="modalInfo"></div>

                <button class="modal-cart-btn" onclick="addToWarenkorb()">In den Warenkorb</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Profil Dropdown
            const trigger = document.getElementById("profileTrigger");
            const dropdown = document.getElementById("profileDropdown");
            trigger.addEventListener("click", function(e) {
                e.preventDefault();
                dropdown.classList.toggle("show");
            });
            document.addEventListener("click", function(e) {
                if (!trigger.contains(e.target)) {
                    dropdown.classList.remove("show");
                }
            });

            // Kategorie Dropdown
            const categoryBtn = document.getElementById("categoryBtn");
            const categoryDropdown = document.getElementById("categoryDropdown");
            categoryBtn.addEventListener("click", function(e) {
                e.preventDefault();
                categoryDropdown.classList.toggle("show");
            });
            document.addEventListener("click", function(e) {
                if (!categoryBtn.contains(e.target)) {
                    categoryDropdown.classList.remove("show");
                }
            });

            // Sort Dropdown
            const sortBtn = document.getElementById("sortBtn");
            const sortDropdown = document.getElementById("sortDropdown");
            sortBtn.addEventListener("click", function(e) {
                e.preventDefault();
                sortDropdown.classList.toggle("show");
            });
            document.addEventListener("click", function(e) {
                if (!sortBtn.contains(e.target)) {
                    sortDropdown.classList.remove("show");
                }
            });
        });

        let currentProductId = null;

        function openModal(productId) {
            currentProductId = productId;
            fetch('get_product.php?id=' + productId)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modalBrand').textContent = data.brand;
                    document.getElementById('modalBeschreibung').textContent = data.beschreibung;
                    document.getElementById('modalPreis').textContent = '€ ' + data.preis;

                    // Bilder
                    const mainImg = document.getElementById('modalMainImg');
                    const thumbs = document.getElementById('modalThumbnails');
                    mainImg.src = '../' + data.bilder[0].bildpfad;
                    thumbs.innerHTML = '';

                    if (data.bilder.length > 1) {
                        data.bilder.forEach((bild, i) => {
                            const img = document.createElement('img');
                            img.src = '../' + bild.bildpfad;
                            img.classList.toggle('active', i === 0);
                            img.onclick = () => {
                                mainImg.src = '../' + bild.bildpfad;
                                thumbs.querySelectorAll('img').forEach(t => t.classList.remove('active'));
                                img.classList.add('active');
                            };
                            thumbs.appendChild(img);
                        });
                    }

                    // Eigenschaften
                    const infoDiv = document.getElementById('modalInfo');
                    infoDiv.innerHTML = '<h4>Info</h4>';
                    for (const [key, val] of Object.entries(data.eigenschaften)) {
                        infoDiv.innerHTML += `
                            <div class="modal-info-row">
                                <span class="modal-info-label">${key}</span>
                                <span class="modal-info-value">${val}</span>
                            </div>`;
                    }

                    document.getElementById('modalOverlay').classList.add('show');

                    // Wunschliste Status setzen
                    fetch('wunschliste_check.php?product_id=' + productId)
                        .then(r => r.json())
                        .then(d => {
                            document.getElementById('modalWishBtn').textContent = d.inWunschliste ? '♥' : '♡';
                        });
       
                });
        }
        function toggleWunschliste() {
            if (!currentProductId) return;
            fetch('wunschliste_toggle.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + currentProductId
            })
            .then(r => r.json())
            .then(d => {
                document.getElementById('modalWishBtn').textContent = d.inWunschliste ? '♥' : '♡';
            });
        }

        const brandBtn = document.getElementById("brandBtn");
        const brandDropdown = document.getElementById("brandDropdown");

        brandBtn.addEventListener("click", function(e) {
            e.preventDefault();
            brandDropdown.classList.toggle("show");
        });

        document.addEventListener("click", function(e) {
            if (!brandBtn.contains(e.target)) {
                brandDropdown.classList.remove("show");
            }
        });

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('show');
        }

        // ESC zum Schließen
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });

        function addToWarenkorb() {
            if (!currentProductId) return;
            fetch('warenkorb_add.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + currentProductId
            })
            .then(() => {
                const btn = document.querySelector('.modal-cart-btn');
                btn.textContent = '✓ Hinzugefügt';
                btn.style.background = '#4CAF50';
                setTimeout(() => {
                    btn.textContent = 'In den Warenkorb';
                    btn.style.background = '';
                }, 1500);
            });
        }
    </script>
</body>
</html>