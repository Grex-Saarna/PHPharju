<?php
session_start();
// Alustame muutujate defineerimisega
$vnimi = "";
$vemail = "";
$vsonum = "";
$error = "";

// Kui vorm on esitatud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Saame vormist sisestatud andmed
    $nimi = trim($_POST['nimi']);
    $email = trim($_POST['email']);
    $sonum = trim($_POST['sonum']);

    // Salvestame sisestatud andmed, et need vajadusel uuesti kuvada
    $vnimi = $nimi;
    $vemail = $email;
    $vsonum = $sonum;

    // Kontrollime, kas väljad on täidetud
    if (!empty($nimi) && !empty($email) && !empty($sonum)) {
        // Kontrollime, kas nimi ja sõnum ei ole liiga pikad
        if (strlen($nimi) <= 25 && strlen($sonum) <= 500) {
            // Kontrollime, kas e-posti aadress on valideeritud
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Siin võiks olla ka CAPTCHA kontroll, kuid antud koodis seda pole

                // Emaili andmed
                $to = 'metshein@gmail.com';
                $subject = 'Tagasiside kodulehelt';
                $message = $sonum;
                $from = 'From: ' . $nimi . '<' . $email . '>';

                // Saadame emaili
                if (mail($to, $subject, $message, $from)) {
                    echo "Email saadetud!<br>Täname tagasiside eest!";
                    echo "<meta http-equiv=\"refresh\" content=\"2;URL='10_email.php'\">";
                    exit();
                } else {
                    $error = "Teie emaili ei saadetud ära!";
                }
            } else {
                $error = "Emaili aadress ei ole õige!";
            }
        } else {
            $error = "Tekstid on liiga pikad!";
        }
    } else {
        $error = "Palun täida kõik väljad!";
    }
}
?>

<h2>Tagasiside</h2>
<form action="" method="post">
    Teie nimi:<br>
    <input name="nimi" type="text" value="<?php echo htmlspecialchars($vnimi); ?>"><br>
    Teie email:<br>
    <input name="email" type="text" value="<?php echo htmlspecialchars($vemail); ?>"><br>
    Sõnum:<br>
    <textarea cols="30" rows="10" name="sonum"><?php echo htmlspecialchars($vsonum); ?></textarea><br>
    <!-- Siin võiks olla ka CAPTCHA pilt, kuid antud koodis seda pole -->
    <!-- Sisesta kood pildilt:<br>
    <input name="kood" type="text"><br> -->
    <input value="Saada sõnum" type="submit">
</form>

<?php
// Kui on tekkinud viga, siis kuvame selle
if (!empty($error)) {
    echo '<p style="color: red;">' . $error . '</p>';
}
?>