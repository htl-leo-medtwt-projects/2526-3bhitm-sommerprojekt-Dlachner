<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite</title>
    <link rel="stylesheet" href="2_css/mainStyle.css">
    <link rel="stylesheet" href="2_css/mainpageStyle.css">
</head>
<body>
    <?php
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
                <a href="#" class="navlink"><div class="icon">
                    <img src="images/wishlist.png" alt="Herz">
                    <span>Wunschliste</span>
                </div></a>

                <a href="#" class="navlink"><div class="icon">
                    <img src="images/warenkorb.png" alt="Warenkorb">
                    <span>Warenkorb</span>
                </div></a>

                <div class="profile">
                    <a href="#"><img src="images/profilpic.png" alt="Profil"></a>
                </div>
            </div>
        </div>
        <!-- -->
        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-content">
                <h1>Konfiguriere dein<br>Skateboard!</h1>
                <button>Zum Konfigurator</button>
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
</body>
</html>