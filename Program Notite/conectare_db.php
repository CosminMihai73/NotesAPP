<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "notite";

$conexiune = new mysqli($hostname, $username, $password, $database);

// Verificăm dacă există erori la conectare
if ($conexiune->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conexiune->connect_error);
}
?>

