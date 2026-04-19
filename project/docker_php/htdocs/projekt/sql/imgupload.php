<!-- Dieser Code wurde mit Hilfe von Ki erstellt -->

<?php
$conn = new mysqli("localhost", "skate", "1234", "produkt_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $ismain = $_POST["ismain"];
    $kategorie = $_POST["kategorie"]; // für den richtigen Ordner

    $zielordner = "images/" . $kategorie . "/";
    
    // Ordner erstellen falls nicht vorhanden
    if (!file_exists($zielordner)) {
        mkdir($zielordner, 0777, true);
    }

    $dateiname = basename($_FILES["bild"]["name"]);
    $zielpfad = $zielordner . $dateiname;

    // Validierung
    $erlaubte_typen = ["image/jpeg", "image/png", "image/webp"];
    
    if (in_array($_FILES["bild"]["type"], $erlaubte_typen)) {
        if (move_uploaded_file($_FILES["bild"]["tmp_name"], $zielpfad)) {
            
            // Pfad in DB speichern
            $stmt = $conn->prepare("INSERT INTO picture (bildpfad, product_product_id, ismain) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $zielpfad, $product_id, $ismain);
            $stmt->execute();
            
            echo "✅ Bild erfolgreich hochgeladen: " . $zielpfad;
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

        <label>Kategorie (Ordnername):</label>
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