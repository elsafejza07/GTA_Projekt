<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "GTA";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
}
?>
