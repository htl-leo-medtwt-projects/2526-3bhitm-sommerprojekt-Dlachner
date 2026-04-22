<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

// DB-Verbindung
$conn = new mysqli("db_server", "skate", "1234", "produkt_db");

// Alle Produkte mit ihrem Hauptbild laden
$result = $conn->query("
    SELECT p.product_id, p.beschreibung, p.preis, p.brand, p.kategorie,
           pic.bildpfad
    FROM product p
    LEFT JOIN picture pic 
        ON pic.product_product_id = p.product_id 
        AND pic.ismain = '1'
    ORDER BY p.product_id DESC
");
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
        <div class="category-btn">
            <button>Kategorie ▼</button>
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
        });
    </script>
</body>
</html>