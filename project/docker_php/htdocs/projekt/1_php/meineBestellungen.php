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

// Alle Bestellungen des Users laden
$bestellungen_res = $conn->query("
    SELECT b.bestellung_id, b.datum, b.gesamtpreis, b.status
    FROM bestellung b
    WHERE b.user_id = $user_id
    ORDER BY b.datum DESC
");

$bestellungen = $bestellungen_res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Bestellungen</title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/meineBestellungen.css">
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
                    <a href="einstellungen.php">Einstellungen</a>
                    <a href="meineBestellungen.php">Meine Bestellungen</a>
                    <a href="wunschliste.php">Wunschliste</a>
                    <a href="logout.php" class="logout">Abmelden</a>
                </div>
            </div>
        </div>
    </div>';
    ?>

    <section class="bestellungen-page">
        <h1>Meine Bestellungen</h1>

        <div class="bestellungen-box">
            <?php if (count($bestellungen) === 0): ?>
                <p class="empty-msg">Du hast noch keine Bestellungen.</p>
            <?php else: ?>
                <div class="bestellungen-list">
                    <?php foreach ($bestellungen as $b): ?>
                    <div class="bestellung-card">
                        <div class="bestellung-header">
                            <div class="bestellung-info">
                                <h3>Bestellung #<?= $b['bestellung_id'] ?></h3>
                                <p><?= date('d.m.Y H:i', strtotime($b['datum'])) ?></p>
                            </div>
                            <div class="bestellung-status">
                                <span class="status <?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span>
                            </div>
                        </div>

                        <div class="bestellung-details">
                            <?php
                            $positions_res = $conn->query("
                                SELECT bp.product_id, bp.menge, bp.preis_damals, p.beschreibung, p.brand
                                FROM bestellung_position bp
                                JOIN product p ON p.product_id = bp.product_id
                                WHERE bp.bestellung_id = {$b['bestellung_id']}
                            ");
                            $positions = $positions_res->fetch_all(MYSQLI_ASSOC);
                            ?>

                            <div class="positions-list">
                                <?php foreach ($positions as $pos): ?>
                                <div class="position-item">
                                    <div class="position-info">
                                        <p class="position-brand"><?= htmlspecialchars(str_replace('_', ' ', $pos['brand'])) ?></p>
                                        <p class="position-desc"><?= htmlspecialchars($pos['beschreibung']) ?></p>
                                    </div>
                                    <div class="position-menge">
                                        x<?= $pos['menge'] ?>
                                    </div>
                                    <div class="position-preis">
                                        € <?= number_format($pos['preis_damals'] * $pos['menge'], 2, ',', '.') ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="bestellung-footer">
                            <div class="bestellung-total">
                                Gesamt: <strong>€ <?= number_format($b['gesamtpreis'], 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
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