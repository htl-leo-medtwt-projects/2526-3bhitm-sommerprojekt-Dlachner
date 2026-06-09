<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$step = isset($_GET['step']) ? intval($_GET['step']) : 1;
if ($step < 1 || $step > 5) $step = 1;

// Session für Konfiguration
if (!isset($_SESSION['config'])) {
    $_SESSION['config'] = ['deck' => null, 'griptape' => null, 'trucks' => null, 'wheels' => null, 'accessories' => []];
}

// Produkte je nach Schritt laden
$produkte = [];
if ($step === 1) {
    $res = $conn->query("SELECT p.product_id, p.beschreibung, p.preis, p.brand, pic.bildpfad FROM product p LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1' WHERE p.kategorie = 'deck'");
} elseif ($step === 2) {
    $res = $conn->query("SELECT p.product_id, p.beschreibung, p.preis, p.brand, pic.bildpfad FROM product p LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1' WHERE p.kategorie = 'griptape'");
} elseif ($step === 3) {
    $res = $conn->query("SELECT p.product_id, p.beschreibung, p.preis, p.brand, pic.bildpfad FROM product p LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1' WHERE p.kategorie = 'trucks'");
} elseif ($step === 4) {
    $res = $conn->query("SELECT p.product_id, p.beschreibung, p.preis, p.brand, pic.bildpfad FROM product p LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1' WHERE p.kategorie = 'wheels'");
} elseif ($step === 5) {
    $res = $conn->query("SELECT p.product_id, p.beschreibung, p.preis, p.brand, pic.bildpfad FROM product p LEFT JOIN picture pic ON pic.product_product_id = p.product_id AND pic.ismain = '1' WHERE p.kategorie = 'accessories'");
}

if ($res) {
    $produkte = $res->fetch_all(MYSQLI_ASSOC);
}

// Produkt auswählen
if (isset($_POST['select'])) {
    $product_id = intval($_POST['product_id']);
    if ($step === 1) $_SESSION['config']['deck'] = $product_id;
    elseif ($step === 2) $_SESSION['config']['griptape'] = $product_id;
    elseif ($step === 3) $_SESSION['config']['trucks'] = $product_id;
    elseif ($step === 4) $_SESSION['config']['wheels'] = $product_id;
    elseif ($step === 5) $_SESSION['config']['accessories'][] = $product_id;
}

// Gesamtpreis berechnen
$gesamt = 0;
$selected_produkte = [];
foreach ($_SESSION['config'] as $key => $val) {
    if ($key === 'accessories' && is_array($val)) {
        foreach ($val as $id) {
            $r = $conn->query("SELECT preis FROM product WHERE product_id = $id");
            if ($p = $r->fetch_assoc()) {
                $gesamt += $p['preis'];
                $selected_produkte[] = $id;
            }
        }
    } elseif ($val !== null && is_numeric($val)) {
        $r = $conn->query("SELECT preis FROM product WHERE product_id = $val");
        if ($p = $r->fetch_assoc()) {
            $gesamt += $p['preis'];
            $selected_produkte[] = $val;
        }
    }
}

// Prüfe ob etwas für diesen Schritt ausgewählt wurde
$isSelected = false;
if ($step === 1 && $_SESSION['config']['deck']) $isSelected = true;
elseif ($step === 2 && $_SESSION['config']['griptape']) $isSelected = true;
elseif ($step === 3 && $_SESSION['config']['trucks']) $isSelected = true;
elseif ($step === 4 && $_SESSION['config']['wheels']) $isSelected = true;
elseif ($step === 5) $isSelected = true; // Accessoires optional
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skateboard Konfigurator</title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/konfigurator.css">
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
                <a href="konfigurator_reset.php?redirect=shop.php">Zum Shop</a>
                <a href="konfigurator_reset.php?redirect=konfigurator.php">Zum Konfigurator</a>
            </div>
        </div>
        <div class="right">
            <a href="konfigurator_reset.php?redirect=wunschliste.php" class="navlink">
                <div class="icon">
                    <img src="../images/wishlist.png" alt="Herz">
                    <span>Wunschliste</span>
                </div>
            </a>
            <a href="konfigurator_reset.php?redirect=warenkorb.php" class="navlink">
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
                    <a href="meineBestellungen.php">Meine Bestellungen</a>
                    <a href="wunschliste.php">Wunschliste</a>
                    <a href="logout.php" class="logout">Abmelden</a>
                </div>
            </div>
        </div>
    </div>';
    ?>

    <section class="konfigurator-page">
        <div class="konfigurator-container">

            <div class="konfigurator-header">
                <div class="konfigurator-titel">
                    <h1>Schritt <?= $step ?></h1>
                    <p id="stepName"></p>
                </div>

                <div class="konfigurator-progress">
                    <img src="../images/conf/skateboardconf_<?= $step ?>.png" alt="Progress">
                    <img src="../images/conf/skateboardUntenConf_<?= $step ?>.png" alt="Config">
                </div>
            </div>

            <!-- Hauptinhalt: Produkte -->
            <div class="konfigurator-main">
                <div class="produkte-grid">
                    <?php foreach ($produkte as $p): ?>
                    <form method="POST" class="produkt-form">
                        <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                        <button type="submit" name="select" class="produkt-card">
                            <img src="../<?= htmlspecialchars($p['bildpfad']) ?>" 
                                 alt="<?= htmlspecialchars($p['beschreibung']) ?>">
                            <div class="produkt-info">
                                <h3><?= htmlspecialchars(str_replace('_', ' ', $p['brand'])) ?></h3>
                                <p><?= htmlspecialchars($p['beschreibung']) ?></p>
                                <span>€ <?= number_format($p['preis'], 2, ',', '.') ?></span>
                            </div>
                        </button>
                    </form>
                    <?php endforeach; ?>
                </div>

                <!-- Unten: Fortschritt Bild + Navigation + Preis -->
                <div class="konfigurator-footer">

                    <div class="konfigurator-footer-middle">
                        <div class="konfigurator-navigation">
                            <?php if ($step > 1): ?>
                                <a href="konfigurator.php?step=<?= $step - 1 ?>" class="btn-nav btn-zurück">← Zurück</a>
                            <?php endif; ?>

                            <?php if ($step < 5): ?>
                                <a href="konfigurator.php?step=<?= $step + 1 ?>" class="btn-nav btn-weiter" <?php if (!$isSelected) echo 'style="opacity: 0.5; pointer-events: none; cursor: not-allowed;"'; ?>>Weiter →</a>
                            <?php elseif ($step === 5): ?>
                                <form method="POST" action="konfigurator_fertig.php">
                                    <button type="submit" class="btn-nav btn-abschließen">Zum Warenkorb</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <?php if ($step === 5): ?>
                            <a href="konfigurator.php?step=1" class="btn-skip">Oder neustarten</a>
                        <?php endif; ?>
                    </div>

                    <div class="konfigurator-footer-right">
                        <div class="konfigurator-preis">
                            Total: € <?= number_format($gesamt, 2, ',', '.') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const steps = {
            1: 'Decks',
            2: 'Griptape',
            3: 'Achsen',
            4: 'Reifen',
            5: 'Deine Konfiguration'
        };
        document.getElementById('stepName').textContent = steps[<?= $step ?>];

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