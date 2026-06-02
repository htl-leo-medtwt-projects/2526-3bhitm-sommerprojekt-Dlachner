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

// Warenkorb leeren
$conn->query("DELETE FROM warenkorb WHERE user_id = $user_id");

// Zurück zum Warenkorb
header('Location: warenkorb.php');
exit();
?>