<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite</title>
    <link rel="stylesheet" href="2_css/mainStyle.css">
    <link rel="stylesheet" href="2_css/mainpageStyle.css">
</head>
<body>
    <?php
    $isLoggedIn = isset($_SESSION['user_id']);

    echo '
        <!-- Navbar -->
        <div class="navbar">
            <div class="left">
                <div class="logo">
                    <a href="#"><img src="images/logo.png" alt="Logo"></a>
                </div>

                <div class="nav-links">
                    <a href="1_php/shop.php">Zum Shop</a>
                    <a href="#">Zum Konfigurator</a>
                </div>
            </div>
            
            <div class="right">
                <a href="#" class="navlink">
                    <div class="icon">
                        <img src="images/wishlist.png" alt="Herz">
                        <span>Wunschliste</span>
                    </div>
                </a>
                <a href="#" class="navlink">
                    <div class="icon">
                        <img src="images/warenkorb.png" alt="Warenkorb">
                        <span>Warenkorb</span>
                    </div>
                </a>

                <div class="profile">
                    <a href="#" class="profile-trigger" id="profileTrigger">
                        <img src="images/profilpic.png" alt="Profil">
                    </a>
                    
                    <!-- Dropdown Menü (Von Grok AI) -->
                    <div class="profile-dropdown" id="profileDropdown">
                        ' . ($isLoggedIn ? '
                        <a href="#">Meine Bestellungen</a>
                        <a href="#">Einstellungen</a>
                        <a href="#">Wunschliste</a>
                        <a href="#" class="logout">Abmelden</a>
                        ' : '
                        <a href="1_php/login.php?login">Anmelden</a>
                        <a href="1_php/login.php?register">Registrieren</a>
                        ') . '
                    </div>
                    <!-- AI Code Ende -->
                </div>
            </div>
        </div>

        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-content">
                <h1>Konfiguriere dein<br>Skateboard!</h1>
                <a href="#" class="hero-button">Zum Konfigurator</a>
            </div>
        </section>

        <!-- KATEGORIEN -->
        <section class="categories">
            <h2>Kategorien</h2>

            <div class="category-grid">
                <div class="card large">
                    <h3>Decks</h3>
                    <img src="images/categoryParts/deck.png" alt="Deck">
                </div>

                <div class="card">
                    <h3>Rollen</h3>
                    <img src="images/categoryParts/rollen.png" alt="Rollen">
                </div>

                <div class="card">
                    <h3>Achsen</h3>
                    <img src="images/categoryParts/achsen.png" alt="Achsen">
                </div>

                <div class="card">
                    <h3>Kugellager</h3>
                    <img src="images/categoryParts/kugellager.png" alt="Lager">
                </div>

                <div class="card">
                    <h3>Zubehör</h3>
                    <img src="images/categoryParts/tools.png" alt="Zubehör">
                </div>
            </div>
        </section>
    ';
    ?>

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