<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['inWunschliste' => false]);
    exit();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

$res = $conn->query("SELECT wunschliste_id FROM wunschliste WHERE user_id = $user_id AND product_id = $product_id");

if ($res->num_rows > 0) {
    $conn->query("DELETE FROM wunschliste WHERE user_id = $user_id AND product_id = $product_id");
    echo json_encode(['inWunschliste' => false]);
} else {
    $conn->query("INSERT INTO wunschliste (user_id, product_id) VALUES ($user_id, $product_id)");
    echo json_encode(['inWunschliste' => true]);
}
?>