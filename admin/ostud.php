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
    <h1>Ostud</h1>
      <?php
      $paring = "SELECT ostud.id, kliendid.eesnimi, kliendid.perenimi, albumid.album 
      FROM ostud 
      INNER JOIN kliendid ON ostud.kliendid_id=kliendid.id 
      INNER JOIN albumid ON ostud.albumid_id=albumid.id";
    //saadan soovitud ühendusele minu päringu
        $valjund = mysqli_query($yhendus, $paring);
    //sikutame andmebaasist kõik vastuse
        while($rida = mysqli_fetch_assoc($valjund)){
            print_r($rida);
            //echo $rida['artist']." - ".$rida["album"]."<br>";
        }
    ?>
</div>
   </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>