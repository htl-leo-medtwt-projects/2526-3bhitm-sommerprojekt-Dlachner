<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['inWunschliste' => false]);
    exit();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['product_id']);

$res = $conn->query("SELECT wunschliste_id FROM wunschliste WHERE user_id = $user_id AND product_id = $product_id");
echo json_encode(['inWunschliste' => $res->num_rows > 0]);
?>