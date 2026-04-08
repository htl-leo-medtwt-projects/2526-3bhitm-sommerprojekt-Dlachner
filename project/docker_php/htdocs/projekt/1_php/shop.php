<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
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
                    <a href="#"><img src="../images/logo.png" alt="Logo"></a>
                </div>

                <div class="nav-links">
                    <a href="1_php/shop.php">Zum Shop</a>
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
                    
                    <!-- Dropdown Menü (Von Grok AI) -->
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
                    <!-- AI Code Ende -->
                </div>
            </div>
        </div>'
        ?>
        <!-- -->

    <!-- SHOP mithilfe von Ki erstellt, beginnend hier -->
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

            <!-- Produkt -->
            <div class="product-card">
                <img src="../images/parts/deck1.png" alt="">
                <div class="product-info">
                    <h3>Zero</h3>
                    <p>Single Skull 8.0" Skateboard Deck</p>
                    <span>€ 74.95</span>
                </div>
            </div>

            <!-- Wiederholen -->
            <div class="product-card">
                <img src="../images/parts/rollen1.png" alt="">
                <div class="product-info">
                    <h3>//PLACEHOLDER</h3>
                    <p>//---PLACEHOLDER---</p>
                    <span>€ 79.95</span>
                </div>
            </div>

            <!-- Kopier einfach mehrere -->
            <!-- ... -->

        </div>
    </section>
    <!-- ---------- Ki Code endet hier ---------- -->

    <!-- JavaScript für das Dropdown (Code von Grok AI -->
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