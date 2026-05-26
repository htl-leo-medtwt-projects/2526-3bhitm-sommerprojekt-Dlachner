<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

$check = $conn->query("SELECT warenkorb_id, menge FROM warenkorb WHERE user_id = $user_id AND product_id = $product_id");
if ($check->num_rows > 0) {
    $conn->query("UPDATE warenkorb SET menge = menge + 1 WHERE user_id = $user_id AND product_id = $product_id");
} else {
    $conn->query("INSERT INTO warenkorb (user_id, product_id, menge) VALUES ($user_id, $product_id, 1)");
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>