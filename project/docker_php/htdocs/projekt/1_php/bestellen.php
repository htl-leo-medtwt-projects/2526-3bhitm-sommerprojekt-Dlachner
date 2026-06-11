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

// Warenkorb laden
$result = $conn->query("
    SELECT p.product_id, p.preis,
           w.menge
    FROM warenkorb w
    JOIN product p ON p.product_id = w.product_id
    WHERE w.user_id = $user_id
");

$produkte = $result->fetch_all(MYSQLI_ASSOC);

if (count($produkte) === 0) {
    header('Location: warenkorb.php');
    exit();
}

// Gesamtpreis berechnen
$gesamtpreis = 0;
foreach ($produkte as $p) {
    $gesamtpreis += $p['preis'] * $p['menge'];
}

// Bestellung erstellen
$gesamtpreis_db = number_format($gesamtpreis, 2, '.', '');
$conn->query("INSERT INTO bestellung (user_id, gesamtpreis, status) VALUES ($user_id, $gesamtpreis_db, 'offen')");
$bestellung_id = $conn->insert_id;

// Bestellungs-Positionen einfügen
foreach ($produkte as $p) {
    $product_id = $p['product_id'];
    $menge = $p['menge'];
    $preis_damals = $p['preis'];
    
    $conn->query("INSERT INTO bestellung_position (bestellung_id, product_id, menge, preis_damals) 
                  VALUES ($bestellung_id, $product_id, $menge, $preis_damals)");
}

// Warenkorb leeren
$conn->query("DELETE FROM warenkorb WHERE user_id = $user_id");

// Zurück zum Warenkorb
header('Location: warenkorb.php');
exit();
?>