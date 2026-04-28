<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$error = '';
$success = '';

// LOGIN
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $passwort = $_POST['passwort'];

    $res = $conn->query("SELECT * FROM user WHERE email = '$email'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($passwort, $user['passwort'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['vorname'] = $user['vorname'];
        header('Location: ../mainpage.php');
        exit();
    } else {
        $error = 'E-Mail oder Passwort falsch.';
    }
}

// REGISTRIEREN
if (isset($_POST['register'])) {
    $vorname = $conn->real_escape_string($_POST['vorname']);
    $nachname = $conn->real_escape_string($_POST['nachname']);
    $email = $conn->real_escape_string($_POST['email']);
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if ($passwort !== $passwort2) {
        $error = 'Passwörter stimmen nicht überein.';
    } else {
        $hash = password_hash($passwort, PASSWORD_DEFAULT);
        $check = $conn->query("SELECT user_id FROM user WHERE email = '$email'");
        if ($check->num_rows > 0) {
            $error = 'Diese E-Mail ist bereits registriert.';
        } else {
            $conn->query("INSERT INTO user (vorname, nachname, email, passwort) VALUES ('$vorname', '$nachname', '$email', '$hash')");
            $success = 'Registrierung erfolgreich! Du kannst dich jetzt anmelden.';
            $show = 'login';
        }
    }
}

$show = $_GET['register'] ?? ($show ?? 'login');
$isRegister = ($show === 'register' || isset($_GET['register']));
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isRegister ? 'Registrieren' : 'Login' ?></title>
    <link rel="stylesheet" href="../2_css/mainStyle.css">
    <link rel="stylesheet" href="../2_css/login.css">
</head>
<body>

    <div class="login-page">

        <div class="login-logo">
            <a href="../mainpage.php">
                <img src="../images/logo.png" alt="SkateForge">
            </a>
        </div>

        <h1><?= $isRegister ? 'Registrieren' : 'Login' ?></h1>

        <?php if ($error): ?>
            <div class="login-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="login-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!$isRegister): ?>
        <!-- LOGIN FORMULAR -->
        <div class="login-box">
            <form method="POST">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@gmail.com" required>

                <label>Passwort</label>
                <input type="password" name="passwort" placeholder="*****" required>

                <button type="submit" name="login">Anmelden</button>
                <a href="login.php?register" class="switch-link">Noch kein Konto?</a>
            </form>
        </div>

        <?php else: ?>
        <!-- REGISTER FORMULAR -->
        <div class="login-box">
            <form method="POST">
                <label>Vorname</label>
                <input type="text" name="vorname" placeholder="Max" required>

                <label>Nachname</label>
                <input type="text" name="nachname" placeholder="Mustermann" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="email@gmail.com" required>

                <label>Passwort</label>
                <input type="password" name="passwort" placeholder="*****" required>

                <label>Passwort wiederholen</label>
                <input type="password" name="passwort2" placeholder="*****" required>

                <button type="submit" name="register">Registrieren</button>
                <a href="login.php" class="switch-link">Bereits ein Konto?</a>
            </form>
        </div>
        <?php endif; ?>

    </div>

</body>
</html>