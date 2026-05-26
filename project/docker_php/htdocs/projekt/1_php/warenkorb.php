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

// Produkt entfernen
if (isset($_POST['remove'])) {
    $product_id = intval($_POST['product_id']);
    $conn->query("DELETE FROM warenkorb WHERE user_id = $user_id AND product_id = $product_id");
}

// Menge ändern
if (isset($_POST['menge'])) {
    $product_id = intval($_POST['product_id']);
    $menge = intval($_POST['menge']);
    if ($menge <= 0) {
        $conn->query("DELETE FROM warenkorb WHERE user_id = $user_id AND product_id = $product_id");
    } else {
        $conn->query("UPDATE warenkorb SET menge = $menge WHERE user_id = $user_id AND product_id = $product_id");
    }
}

// Warenkorb laden
$result = $conn->query("
    SELECT p.product_id, p.beschreibung, p.preis, p.brand,
           pic.bildpfad, w.menge, w.warenkorb_id
    FROM warenkorb w
    JOIN product p ON p.product_id = w.product_id
    LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1'
    WHERE w.user_id = $user_id
    ORDER BY w.warenkorb_id ASC
");

$produkte = $result->fetch_all(MYSQLI_ASSOC);

// Gesamtpreis berechnen
$gesamt = 0;
foreach ($produkte as $p) {
    $gesamt += $p['preis'] * $p['menge'];
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/warenkorb.css">
</head>
<body>

    <!-- Navbar -->
    <?php echo '
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

    <section class="cart-page">
        <h1>Mein Warenkorb</h1>

        <div class="cart-box">
            <?php if (count($produkte) === 0): ?>
                <p class="empty-msg">Dein Warenkorb ist noch leer.</p>
            <?php else: ?>

                <div class="cart-grid">
                    <?php foreach ($produkte as $p): ?>
                    <div class="cart-card">
                        <img src="../<?= htmlspecialchars($p['bildpfad']) ?>"
                             alt="<?= htmlspecialchars($p['beschreibung']) ?>">

                        <div class="cart-info">
                            <h3><?= htmlspecialchars(str_replace('_', ' ', $p['brand'])) ?></h3>
                            <p><?= htmlspecialchars($p['beschreibung']) ?></p>
                            <span>€ <?= number_format($p['preis'], 2, ',', '.') ?></span>
                        </div>

                        <div class="cart-menge">
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                                <button type="submit" name="menge" value="<?= $p['menge'] - 1 ?>" class="menge-btn">−</button>
                                <span><?= $p['menge'] ?></span>
                                <button type="submit" name="menge" value="<?= $p['menge'] + 1 ?>" class="menge-btn">+</button>
                            </form>
                        </div>

                        <div class="cart-subtotal">
                            € <?= number_format($p['preis'] * $p['menge'], 2, ',', '.') ?>
                        </div>

                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                            <button type="submit" name="remove" class="btn-remove">✕</button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-footer">
                    <div class="cart-gesamt">
                        Gesamt: <strong>€ <?= number_format($gesamt, 2, ',', '.') ?></strong>
                    </div>
                    <button class="btn-bestellen">Jetzt bestellen</button>
                </div>

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