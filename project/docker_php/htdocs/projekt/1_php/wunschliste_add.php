<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

// Nur hinzufügen wenn noch nicht drin
$check = $conn->query("SELECT wunschliste_id FROM wunschliste WHERE user_id = $user_id AND product_id = $product_id");
if ($check->num_rows === 0) {
    $conn->query("INSERT INTO wunschliste (user_id, product_id) VALUES ($user_id, $product_id)");
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>