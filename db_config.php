<?php
$servername = "localhost";
$username = "sagch"; // Cambia esto si tienes otro usuario
$password = "cMBbRYP4C][IrhCQ"; // Cambia esto si tienes una contraseña
$dbname = "gchapp"; // Asegúrate de que este sea el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
