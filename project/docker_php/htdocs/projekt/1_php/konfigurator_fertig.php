<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['config'])) {
    header('Location: konfigurator.php');
    exit();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$user_id = $_SESSION['user_id'];
$config = $_SESSION['config'];

// Alle ausgewählten Produkte in den Warenkorb
$products_to_add = [];
if ($config['deck']) $products_to_add[] = $config['deck'];
if ($config['griptape']) $products_to_add[] = $config['griptape'];
if ($config['trucks']) $products_to_add[] = $config['trucks'];
if ($config['wheels']) $products_to_add[] = $config['wheels'];
if (!empty($config['accessories'])) {
    foreach ($config['accessories'] as $acc) {
        $products_to_add[] = $acc;
    }
}

// In Warenkorb einfügen
foreach ($products_to_add as $product_id) {
    $check = $conn->query("SELECT warenkorb_id, menge FROM warenkorb WHERE user_id = $user_id AND product_id = $product_id");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE warenkorb SET menge = menge + 1 WHERE user_id = $user_id AND product_id = $product_id");
    } else {
        $conn->query("INSERT INTO warenkorb (user_id, product_id, menge) VALUES ($user_id, $product_id, 1)");
    }
}

// Config löschen und zum Warenkorb leiten
unset($_SESSION['config']);
header('Location: warenkorb.php');
exit();
?>