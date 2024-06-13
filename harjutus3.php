<?php include("config.php"); ?> 
<!doctype html>
<html lang="en">
    <head>
        <title>Muusikapood OÜ</title>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <div class="container">
            <h1>Maailma imelikumad palad</h1>
            <h2>Uue albumi lisamine</h2>
            <form action="" method="get">
                artist <input type="text" name="artist"><br>
                album <input type="text" name="album"><br>
                aasta <input type="number" name="aasta" min="1900" max="2024"><br>
                hind <input type="number" name="hind" step="0.01"><br>
                <input type="submit" value="+ Lisa uus" name="lisa">
            </form>

            <form action="" method="get">
                Otsi:<input type="text" name="s">
                <input type="Submit" value="Otsi">
            </form>
<div class="row row-cols-1 row-cols-md-3 g-4 pt-4">
            <?php


// Ühendus andmebaasiga (asenda andmebaasi ühenduse info vastavalt oma andmebaasile)
$db_server = 'localhost';
$db_andmebaas = 'muusikpod';
$db_kasutaja = 'Gregori';
$db_salasona = '123';

try {
    $pdo = new PDO("mysql:host=$db_server;dbname=$db_andmebaas", $db_kasutaja, $db_salasona);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Viga andmebaasiga ühenduse loomisel: " . $e->getMessage());
}

// Andmete kuvamine
$stmt = $pdo->query("SELECT * FROM muusikapod");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'>
<tr>
<th>Artist</th>
<th>Album</th>
<th>Aasta</th>
<th>Kustuta</th>
<th>Muuda</th>
</tr>";

foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . $row['artist'] . "</td>";
    echo "<td>" . $row['album'] . "</td>";
    echo "<td>" . $row['aasta'] . "</td>";
    echo "<td><a href='?action=delete&id=" . $row['id'] . "'>Kustuta</a></td>";
    echo "<td><a href='?action=edit&id=" . $row['id'] . "'>Muuda</a></td>";
    echo "</tr>";
}
echo "</table>";

// Andmete lisamine vormi kaudu
echo "<form action='' method='post'>";
echo "Artist: <input type='text' name='artist'><br>";
echo "Album: <input type='text' name='album'><br>";
echo "Aasta: <input type='text' name='aasta'><br>";
echo "<input type='submit' name='submit' value='Lisa'>";
echo "</form>";

// Andmete lisamine
if (isset($_POST['submit'])) {
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $aasta = $_POST['aasta'];
    
    // Lisame andmeid andmebaasi
    $stmt = $pdo->prepare("INSERT INTO albumid (artist, album, aasta) VALUES (?, ?, ?)");
    $stmt->execute([$artist, $album, $aasta]);
    
    // Suuname tagasi esilehele pärast lisamist
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Andmete kustutamine
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Kustutame kirje andmebaasist
    $stmt = $pdo->prepare("DELETE FROM muusikapod WHERE id = ?");
    $stmt->execute([$id]);
    
    // Suuname tagasi esilehele pärast kustutamist
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Andmete muutmine
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Kui vorm on esitatud
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $artist = $_POST['artist'];
        $album = $_POST['album'];
        $aasta = $_POST['aasta'];
        
        // Muudame kirjet andmebaasis
        $stmt = $pdo->prepare("UPDATE muusikapod SET artist=?, album=?, aasta=? WHERE id=?");
        $stmt->execute([$artist, $album, $aasta, $id]);
        
        // Suuname tagasi esilehele pärast muutmist
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        // Kui vormi ei ole esitatud, kuvame muutmise vormi
        $stmt = $pdo->prepare("SELECT * FROM muusikapod WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<form action='' method='post'>";
        echo "Artist: <input type='text' name='artist' value='" . $row['artist'] . "'><br>";
        echo "Album: <input type='text' name='album' value='" . $row['album'] . "'><br>";
        echo "Aasta: <input type='text' name='aasta' value='" . $row['aasta'] . "'><br>";
        echo "<input type='submit' value='Salvesta'>";
        echo "</form>";
    }
}
// Andmebaasi ühenduse loomine
$yhendus = mysqli_connect('localhost', 'Gregori', '123', 'muusikpod');

// Veenduge, et ühendus õnnestus
if (!$yhendus) {
    die("Ühenduse loomine ebaõnnestus: " . mysqli_connect_error());
}

// Päringu määratlemine
$paring = "SELECT * FROM albumid";

// Päringu saatmine andmebaasile ja tulemuste saamine
$valjund = mysqli_query($yhendus, $paring);

// Veenduge, et päring õnnestus
if (!$valjund) {
    die("Päringu tegemine ebaõnnestus: " . mysqli_error($yhendus));
}

// Tulemuste töötlemine
while ($rida = mysqli_fetch_assoc($valjund)) {
    // Siin saate teha midagi tulemustega, nt need väljastada või muul moel töödelda
}

// Ühenduse sulgemine
mysqli_close($yhendus);

//saadan soovitud ühendusele minu päringu
        //sikutame andmebaasist kõik vastused
        while($rida = mysqli_fetch_assoc($valjund)){
            //print_r($rida);
            //echo $rida['artist']." - ".$rida["album"]."<br>";
            echo '
            <div class="col">
            <div class="card">
            <img src="https://picsum.photos/400/400" alt="pilt">
              <div class="card-body">
                <h5 class="card-title">'.$rida['album'].'</h5>
                <p class="card-text">'.$rida['hind'].'€.</p>
                <a href="#" class="btn btn-danger">Osta</a>
                <a href="index.php?del=kustuta&id='.$rida['id'].'" class="btn btn-warning">Kustuta</a>
              </div>
            </div>
          </div>
          ';
        }
            ?>
            </div>
        </div>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
