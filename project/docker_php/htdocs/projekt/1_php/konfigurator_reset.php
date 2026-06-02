<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Config zurücksetzen
unset($_SESSION['config']);

// Wohin sollen wir gehen?
$redirect = $_GET['redirect'] ?? 'shop.php';
header('Location: ' . $redirect);
exit();
?>