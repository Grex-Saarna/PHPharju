<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    die("Vale koht");
}

?>
<h1>ERITI SALAJANE</h1>
<a href="logout.php">Logi välja</a>