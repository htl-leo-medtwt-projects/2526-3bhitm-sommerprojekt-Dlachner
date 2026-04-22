<?php
// Dieser Code wurde mit Hilfe von KI erstellt

$conn = new mysqli("db_server", "skate", "1234", "produkt_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = (int) $_POST["product_id"];
    $ismain     = $_POST["ismain"] === "1" ? "1" : "0";
    
    // Kategorie nur erlaubte Werte akzeptieren (keine freie Eingabe!)
    $erlaubte_kategorien = ["decks", "wheels", "trucks", "bearings", "griptape", "accessories"];
    $kategorie = in_array($_POST["kategorie"], $erlaubte_kategorien) ? $_POST["kategorie"] : null;

    if (!$kategorie) {
        die("❌ Ungültige Kategorie.");
    }

    $zielordner = "images/" . $kategorie . "/";
    if (!file_exists($zielordner)) {
        mkdir($zielordner, 0755, true);  // 0755 statt 0777
    }

    // Sicherer Dateiname mit uniqid() → kein Überschreiben
    $ext       = strtolower(pathinfo($_FILES["bild"]["name"], PATHINFO_EXTENSION));
    $dateiname = "product_" . $product_id . "_" . uniqid() . "." . $ext;
    $zielpfad  = $zielordner . $dateiname;

    // Validierung mit getimagesize() statt $_FILES["type"]
    $erlaubte_typen = ["image/jpeg", "image/png", "image/webp"];
    $image_info = getimagesize($_FILES["bild"]["tmp_name"]);

    if ($image_info && in_array($image_info["mime"], $erlaubte_typen)) {
        if (move_uploaded_file($_FILES["bild"]["tmp_name"], $zielpfad)) {

            $stmt = $conn->prepare("INSERT INTO picture (bildpfad, product_product_id, ismain) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $zielpfad, $product_id, $ismain);

            if ($stmt->execute()) {
                header("Location: imgupload.php?erfolg=1");
                exit();
            } else {
                // DB-Fehler → Datei wieder löschen
                unlink($zielpfad);
                echo "❌ Datenbankfehler: " . $stmt->error;
            }
        } else {
            echo "❌ Datei konnte nicht gespeichert werden.";
        }
    } else {
        echo "❌ Nur JPG, PNG und WEBP erlaubt!";
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Bild Upload</h2>
    <form action="" method="post" enctype="multipart/form-data">
        
        <label>Produkt ID:</label>
        <input type="number" name="product_id" required><br><br>

        <label>Kategorie:</label>
        <select name="kategorie">
            <option value="decks">Deck</option>
            <option value="wheels">Wheels</option>
            <option value="trucks">Trucks</option>
            <option value="bearings">Bearings</option>
            <option value="griptape">Griptape</option>
            <option value="accessories">Accessories</option>
        </select><br><br>

        <label>Hauptbild?</label>
        <select name="ismain">
            <option value="1">Ja (Hauptbild)</option>
            <option value="0">Nein (Zusatzbild)</option>
        </select><br><br>

        <label>Bild auswählen:</label>
        <input type="file" name="bild" accept="image/*" required><br><br>

        <input type="submit" value="Hochladen">
    </form>
</body>
</html>