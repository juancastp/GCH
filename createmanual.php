<?php
include('db_config.php');

$username = 'juanca';
$email = 'juanca@gchapp.es';
$password = password_hash('Romero20;23', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Usuario de prueba creado exitosamente.";
} else {
    echo "Error al crear el usuario de prueba.";
}

$stmt->close();
$conn->close();
?>