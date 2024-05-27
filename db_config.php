<?php
$servername = "localhost";
$username = "sagch";
$password = "cMBbRYP4C][IrhCQ";
$dbname = "gchapp";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>


<