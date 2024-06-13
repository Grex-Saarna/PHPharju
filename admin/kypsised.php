<?php
session_start();

// Loome juhusliku numbri
$random_number = rand(1000, 9999);

// Salvestame juhusliku numbri sessiooni
$_SESSION['captchatext'] = $random_number;

// Loome pildi
$im = imagecreatetruecolor(100, 50);

// Värvide määratlemine
$bg_color = imagecolorallocate($im, 255, 255, 255); // Valge taust
$text_color = imagecolorallocate($im, 0, 0, 0); // Must tekst

// Täidame tausta värviga
imagefilledrectangle($im, 0, 0, 100, 50, $bg_color);

// Lisa juhuslik number pildile
imagestring($im, 10, 20, 15,  $random_number, $text_color);

// Määrame päise, et öelda brauserile, et see on pilt
header('Content-type: image/png');

// Näita pilti
imagepng($im);

// Puhasta mälu
imagedestroy($im);
?>