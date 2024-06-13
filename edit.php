<?php include("config.php"); ?>

<!doctype html>
<html lang="et">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muusikapood OÜ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="container">
<h2>Albumi muutmine</h2>

<form action="#" method="get">
<?php
if (!empty($_GET['id']) && !empty($_GET['muuda'])) {
    $id = $_GET["id"];
    $artist = $_GET["artist"];
    $album = $_GET["album"];
    $aasta = $_GET["aasta"];
    $hind = $_GET["hind"];

    //print_r($album);
    $paring= "UPDATE albumid 
    SET artist = '$artist', album = '$album', aasta = '$aasta'
    WHERE id = $id";
    //print_r($paring);
    $valjund = mysqli_query($yhendus, $paring);
    //print_r($valjund);
    header("Location: index.php?msg=true");

}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $paring = "SELECT * FROM albumid WHERE id=$id";
    //print_r($paring);
    $valjund = mysqli_query($yhendus, $paring);
    $rida = mysqli_fetch_assoc($valjund);
    //print_r($rida);
    echo '
    id <input type="number" name="id" hidden value="'.$rida['id'].'"><br>
    artist <input type="text" name="artist" value="'.$rida['artist'].'"><br>
    album <input type="text" name="album" value="'.$rida['album'].'"><br>
    aasta <input type="number" name="aasta" min="1900" value="'.$rida['aasta'].'"><br>
    hind <input type="number" name="hind" step="0.01" value="'.$rida['hind'].'"><br>
    <input type="submit" value="Muuda" name="muuda">
    ';
}
?>
</form>


</div>
   </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>