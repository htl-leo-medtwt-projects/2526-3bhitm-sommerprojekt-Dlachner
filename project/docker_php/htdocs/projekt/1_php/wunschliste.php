<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$user_id = $_SESSION['user_id'];

// Produkt aus Wunschliste entfernen
if (isset($_POST['remove'])) {
    $product_id = intval($_POST['product_id']);
    $conn->query("DELETE FROM wunschliste WHERE user_id = $user_id AND product_id = $product_id");
}

// Wunschliste laden
$result = $conn->query("
    SELECT p.product_id, p.beschreibung, p.preis, p.brand, p.kategorie,
           pic.bildpfad
    FROM wunschliste w
    JOIN product p ON p.product_id = w.product_id
    LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1'
    WHERE w.user_id = $user_id
    ORDER BY w.wunschliste_id DESC
");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wunschliste</title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/wunschliste.css">
</head>
<body>

    <!-- Navbar -->
    <?php
    $isLoggedIn = true;
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
                    <a href="#">Meine Bestellungen</a>
                    <a href="#">Einstellungen</a>
                    <a href="wunschliste.php">Wunschliste</a>
                    <a href="logout.php" class="logout">Abmelden</a>
                </div>
            </div>
        </div>
    </div>';
    ?>

    <section class="wishlist-page">
        <h1>Meine Wunschliste</h1>

        <div class="wishlist-grid">
            <?php
            $produkte = $result->fetch_all(MYSQLI_ASSOC);
            if (count($produkte) === 0): ?>
                <p class="empty-msg">Deine Wunschliste ist noch leer.</p>
            <?php else: ?>
                <?php foreach ($produkte as $p): ?>
                <div class="wishlist-card">
                    <img src="../<?= htmlspecialchars($p['bildpfad']) ?>"
                         alt="<?= htmlspecialchars($p['beschreibung']) ?>">
                    <div class="wishlist-info">
                        <h3><?= htmlspecialchars(str_replace('_', ' ', $p['brand'])) ?></h3>
                        <p><?= htmlspecialchars($p['beschreibung']) ?></p>
                        <span>€ <?= number_format($p['preis'], 2, ',', '.') ?></span>
                    </div>
                    <div class="wishlist-actions">
                        <form method="POST" action="warenkorb_add.php">
                            <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                            <button type="submit" class="btn-cart">In den Warenkorb</button>
                        </form>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                            <button type="submit" name="remove" class="btn-remove">✕ Entfernen</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
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