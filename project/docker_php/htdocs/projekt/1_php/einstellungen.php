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
$message = '';
$error = '';

// Daten laden
$res = $conn->query("SELECT * FROM user WHERE user_id = $user_id");
$user = $res->fetch_assoc();

// Email ändern
if (isset($_POST['change_email'])) {
    $new_email = $conn->real_escape_string($_POST['email']);
    $passwort = $_POST['passwort'];
    
    if (!password_verify($passwort, $user['passwort'])) {
        $error = 'Passwort ist falsch.';
    } else {
        $check = $conn->query("SELECT user_id FROM user WHERE email = '$new_email' AND user_id != $user_id");
        if ($check->num_rows > 0) {
            $error = 'Diese E-Mail wird bereits verwendet.';
        } else {
            $conn->query("UPDATE user SET email = '$new_email' WHERE user_id = $user_id");
            $user['email'] = $new_email;
            $message = 'E-Mail erfolgreich geändert!';
        }
    }
}

// Passwort ändern
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password2 = $_POST['new_password2'];
    
    if (!password_verify($old_password, $user['passwort'])) {
        $error = 'Altes Passwort ist falsch.';
    } elseif ($new_password !== $new_password2) {
        $error = 'Neue Passwörter stimmen nicht überein.';
    } else {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $conn->query("UPDATE user SET passwort = '$hash' WHERE user_id = $user_id");
        $message = 'Passwort erfolgreich geändert!';
    }
}

// Profilbild hochladen
if (isset($_FILES['profilbild']) && $_FILES['profilbild']['size'] > 0) {
    $file = $_FILES['profilbild'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $file['name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if (!in_array($ext, $allowed)) {
        $error = 'Nur Bilder (jpg, png, gif) sind erlaubt.';
    } elseif ($file['size'] > 5000000) { // 5MB max
        $error = 'Datei ist zu groß (max 5MB).';
    } else {
        $new_filename = 'profil_' . $user_id . '.' . $ext;
        $upload_path = '../images/profile/' . $new_filename;
        
        // Verzeichnis erstellen falls nicht vorhanden
        if (!is_dir('../images/profile')) {
            mkdir('../images/profile', 0777, true);
        }
        
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $db_path = 'images/profile/' . $new_filename;
            $conn->query("UPDATE user SET profilbild = '$db_path' WHERE user_id = $user_id");
            $user['profilbild'] = $db_path;
            $message = 'Profilbild erfolgreich hochgeladen!';
        } else {
            $error = 'Fehler beim Hochladen.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einstellungen</title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/einstellungen.css">
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
                    <a href="#">Meine Bestellungen</a>
                    <a href="wunschliste.php">Wunschliste</a>
                    <a href="logout.php" class="logout">Abmelden</a>
                </div>
            </div>
        </div>
    </div>';
    ?>

    <section class="einstellungen-page">
        <h1>Meine Einstellungen</h1>

        <div class="einstellungen-box">

            <?php if ($message): ?>
                <div class="einstellungen-success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="einstellungen-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- PROFILBILD -->
            <div class="einstellung-card">
                <h2>Profilbild</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="profile-preview">
                        <?php if ($user['profilbild']): ?>
                            <img src="../<?= htmlspecialchars($user['profilbild']) ?>" alt="Profilbild">
                        <?php else: ?>
                            <img src="../images/profilpic.png" alt="Kein Bild">
                        <?php endif; ?>
                    </div>
                    <input type="file" name="profilbild" accept="image/*">
                    <button type="submit" class="btn-save">Hochladen</button>
                </form>
            </div>

            <!-- EMAIL ÄNDERN -->
            <div class="einstellung-card">
                <h2>E-Mail ändern</h2>
                <form method="POST">
                    <label>Neue E-Mail</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

                    <label>Passwort (zur Bestätigung)</label>
                    <input type="password" name="passwort" required>

                    <button type="submit" name="change_email" class="btn-save">E-Mail ändern</button>
                </form>
            </div>

            <!-- PASSWORT ÄNDERN -->
            <div class="einstellung-card">
                <h2>Passwort ändern</h2>
                <form method="POST">
                    <label>Altes Passwort</label>
                    <input type="password" name="old_password" required>

                    <label>Neues Passwort</label>
                    <input type="password" name="new_password" required>

                    <label>Passwort wiederholen</label>
                    <input type="password" name="new_password2" required>

                    <button type="submit" name="change_password" class="btn-save">Passwort ändern</button>
                </form>
            </div>

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