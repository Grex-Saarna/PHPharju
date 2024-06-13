<?php
include("config.php");

try {
    // Päring klientide ja arvete andmete saamiseks
    $sql = "SELECT kliendid.eesnimi, kliendid.perenimi, arved.kogus, tooted.album 
            FROM kliendid 
            INNER JOIN arved ON arved.kliendid_id = kliendid.id 
            INNER JOIN tooted ON arved.tooted_id = tooted.id";
    $result = $pdo->query($sql);

    echo "<!DOCTYPE html>
<html lang='et'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Kliendid ja arved</title>
    <!-- Bootstrap CDN -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container'>
        <h2>Kliendid ja arved</h2>";

    if ($result->rowCount() > 0) {
        echo "<div class='row'>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='col'>";
            echo "<p>Klient: " . $row["eesnimi"] . " " . $row["perenimi"] . "</p>";
            echo "<p>Album: " . $row["album"] . "</p>";
            echo "<p>Kogus: " . $row["kogus"] . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "Andmeid ei leitud.";
    }

    echo "</div>

    <!-- Bootstrap JavaScript CDN -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>";

} catch (PDOException $e) {
    echo "Viga: " . $e->getMessage();
}
?>
