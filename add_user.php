<?php
session_start();
include('db_config.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Verificar si el usuario ya existe en la base de datos
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El usuario ya existe, redirigir con mensaje de error
        header("Location: manage_users.php?error=userexists");
        exit();
    }

    // Verificar si el email ya está registrado en la base de datos
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // El email ya está registrado, redirigir con mensaje de error
        header("Location: manage_users.php?error=emailexists");
        exit();
    }

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $password, $role);
    $stmt->execute();

    // Mostrar modal de éxito
    echo "<script>
            $(document).ready(function(){
                $('#successModal').modal('show');
                setTimeout(function(){
                    $('#successModal').modal('hide');
                }, 2000); // Cierra el modal después de 2 segundos
            });
          </script>";
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
