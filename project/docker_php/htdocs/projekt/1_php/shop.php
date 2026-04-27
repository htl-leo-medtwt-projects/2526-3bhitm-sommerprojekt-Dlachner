<?php
// Dieser Code wurde mit Unterstützung von ClaudeAI umgesetzt
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
            <div class="product-card">
                <img src="../<?= htmlspecialchars($produkt['bildpfad']) ?>" 
                     alt="<?= htmlspecialchars($produkt['beschreibung']) ?>">
                <div class="product-info">
                    <h3><?= htmlspecialchars($produkt['brand']) ?></h3>
                    <p><?= htmlspecialchars($produkt['beschreibung']) ?></p>
                    <span>€ <?= number_format($produkt['preis'], 2, ',', '.') ?></span>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </section>

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
    </script>
</body>
</html>