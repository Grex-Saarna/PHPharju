<?php
session_start();

// Funktsioon parooli krüpteerimiseks
function krüpteeriParool($parool) {
    // Krüpteeri parooli kasutades bcrypti algoritmi
    return password_hash($parool, PASSWORD_BCRYPT);
}

// Registreerimise tegevus
if (isset($_POST['registreeri'])) {
    if (!empty($_POST['kasutaja']) && !empty($_POST['parool'])) {
        $kasutaja = $_POST['kasutaja'];
        $parool = $_POST['parool'];

        // Kontrollime, et kasutajanimi ei ole "admin"
        if ($kasutaja !== "admin") {
            // Kontrollime kasutajanime kordumatust
            if (!isset($_SESSION['kasutajad'][$kasutaja])) {
                // Kontrollime parooli pikkust
                if (strlen($parool) >= 8) {
                    // Krüpteeri parool
                    $krüpteeritudParool = krüpteeriParool($parool);
                    // Salvesta kasutaja ja krüpteeritud parool sessiooni
                    $_SESSION['kasutajad'][$kasutaja] = $krüpteeritudParool;
                    echo "Kasutaja registreeritud edukalt!";
                } else {
                    echo "Parool peab olema vähemalt 8 tähemärki pikk!";
                }
            } else {
                echo "Kasutajanimi on juba võetud. Palun vali teine.";
            }
        } else {
            echo "Kasutajanimi 'admin' ei ole lubatud!";
        }
    } else {
        echo "Kasutajanimi ja parool peavad olema täidetud!";
    }
}

// Sisselogimise tegevus
if (isset($_POST['login'])) {
    if (!empty($_POST['kasutaja']) && !empty($_POST['parool'])) {
        $kasutaja = $_POST['kasutaja'];
        $parool = $_POST['parool'];
        // Kontrollime, kas kasutaja eksisteerib ja parool klapib
        if (isset($_SESSION['kasutajad'][$kasutaja]) && password_verify($parool, $_SESSION['kasutajad'][$kasutaja])) {
            $_SESSION['login'] = true;
            $_SESSION['kasutaja'] = $kasutaja;
            header("Location: index.php");
            exit;
        } else {
            echo "Vale kasutajanimi või parool. Proovi uuesti.";
        }
    } else {
        echo "Kasutajanimi ja parool peavad olema täidetud!";
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreerimine ja sisselogimine</title>
</head>
<body>
    <h2>Registreerimine</h2>
    <form action="#" method="post">
        <input type="hidden" name="registreeri" value="1">
        <label for="kasutaja_reg">Kasutajanimi:</label>
        <input type="text" id="kasutaja_reg" name="kasutaja" required><br>
        <label for="parool_reg">Parool:</label>
        <input type="password" id="parool_reg" name="parool" required><br>
        <input type="submit" value="Registreeri">
    </form>

    <h2>Sisselogimine</h2>
    <form action="#" method="post">
        <input type="hidden" name="login" value="1">
        <label for="kasutaja">Kasutajanimi:</label>
        <input type="text" id="kasutaja" name="kasutaja" required><br>
        <label for="parool">Parool:</label>
        <input type="password" id="parool" name="parool" required><br>
        <input type="submit" value="Logi sisse">
    </form>
</body>
</html>
