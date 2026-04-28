<?php
// ------ Dieser Code wurde mit Unterstützung von ClaudeAI umgesetzt ------

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");
$id = intval($_GET['id']);

// Produkt Basisdaten
$res = $conn->query("SELECT * FROM product WHERE product_id = $id");
$produkt = $res->fetch_assoc();

// Alle Bilder
$bilder = [];
$res2 = $conn->query("SELECT bildpfad, ismain FROM picture WHERE product_product_id = $id ORDER BY ismain DESC");
while ($row = $res2->fetch_assoc()) {
    $bilder[] = $row;
}

// Eigenschaften je nach Kategorie
$eigenschaften = [];
$kat = $produkt['kategorie'];

if ($kat === 'deck') {
    $r = $conn->query("SELECT width, length FROM deck WHERE product_id = $id");
    $d = $r->fetch_assoc();
    $eigenschaften['Breite'] = $d['width'] . '"';
    $eigenschaften['Länge'] = $d['length'] . '"';

} elseif ($kat === 'trucks') {
    $r = $conn->query("SELECT width, height FROM trucks WHERE product_id = $id");
    $d = $r->fetch_assoc();
    $eigenschaften['Breite'] = $d['width'] . '"';
    $eigenschaften['Höhe'] = $d['height'] . '"';

} elseif ($kat === 'wheels') {
    $r = $conn->query("SELECT width, durchmesser, typ FROM wheels WHERE product_id = $id");
    $d = $r->fetch_assoc();
    $eigenschaften['Lauffläche'] = $d['width'] . ' mm';
    $eigenschaften['Durchmesser'] = $d['durchmesser'] . ' mm';
    $eigenschaften['Typ'] = $d['typ'];

} elseif ($kat === 'bearings') {
    $r = $conn->query("SELECT material FROM bearings WHERE product_id = $id");
    $d = $r->fetch_assoc();
    $eigenschaften['Material'] = $d['material'];

} elseif ($kat === 'griptape') {
    $r = $conn->query("SELECT size FROM griptape WHERE product_id = $id");
    $d = $r->fetch_assoc();
    $eigenschaften['Größe'] = $d['size'] . '"';
}

echo json_encode([
    'brand' => str_replace('_', ' ', $produkt['brand']),
    'beschreibung' => $produkt['beschreibung'],
    'preis' => number_format($produkt['preis'], 2, ',', '.'),
    'bilder' => $bilder,
    'eigenschaften' => $eigenschaften
]);