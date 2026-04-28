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

$sql = "
    SELECT p.product_id, p.beschreibung, p.preis, p.brand, p.kategorie,
           pic.bildpfad
    FROM product p
    LEFT JOIN picture pic 
        ON pic.product_product_id = p.product_id 
        AND pic.ismain = '1'
";

if ($category === 'accessoire') {
    $sql .= " WHERE p.kategorie IN ('accessoire', 'griptape')";
} elseif ($category) {
    $category = $conn->real_escape_string($category);
    $sql .= " WHERE p.kategorie = '$category'";
}

$sql .= " ORDER BY p.product_id ASC";
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
                <a href="#">Zum Konfigurator</a>
            </div>
        </div>
        <div class="right">
            <a href="#" class="navlink">
                <div class="icon">
                    <img src="../images/wishlist.png" alt="Herz">
                    <span>Wunschliste</span>
                </div>
            </a>
            <a href="#" class="navlink">
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
                    <a href="#">Meine Bestellungen</a>
                    <a href="#">Einstellungen</a>
                    <a href="#">Wunschliste</a>
                    <a href="#" class="logout">Abmelden</a>
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
            <div class="search">
                <input type="text" placeholder="Suche">
                <img src="../images/search.png" alt="Suche">
            </div>
            <button class="filter-btn">Filter ▼</button>
            <button class="filter-btn">Marke ▼</button>
        </div>

        <!-- Kategorie Dropdown -->
        <div class="category-btn">
            <div class="filter-wrapper">
                <button class="filter-btn" id="categoryBtn">Kategorie ▼</button>
                <div class="filter-dropdown" id="categoryDropdown">
                    <a href="shop.php">Alle</a>
                    <a href="shop.php?category=deck">Deck</a>
                    <a href="shop.php?category=trucks">Trucks</a>
                    <a href="shop.php?category=wheels">Wheels</a>
                    <a href="shop.php?category=bearings">Bearings</a>
                    <a href="shop.php?category=accessoire">Accessoire</a>
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
                <h2 id="modalBrand"></h2>
                <p id="modalBeschreibung"></p>
                <div class="modal-preis" id="modalPreis"></div>

                <div class="modal-info" id="modalInfo"></div>

                <button class="modal-cart-btn">In den Warenkorb</button>
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
        });

        function openModal(productId) {
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
                });
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('show');
        }

        // ESC zum Schließen
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>