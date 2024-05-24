<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Verificar si el nombre de usuario ya existe
    $sql_check_username = "SELECT id FROM users WHERE username = ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $stmt_check_username->store_result();

    // Verificar si el correo electrónico ya existe
    $sql_check_email = "SELECT id FROM users WHERE email = ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_username->num_rows > 0) {
        // El nombre de usuario ya existe, establecer el mensaje de error
        $_SESSION['error_message'] = "El nombre de usuario ya está en uso.";
        header("Location: manage_users.php");
        exit();
    } elseif ($stmt_check_email->num_rows > 0) {
        // El correo electrónico ya existe, establecer el mensaje de error
        $_SESSION['error_message'] = "La dirección de correo electrónico ya está en uso.";
        header("Location: manage_users.php");
        exit();
    }

    // Insertar el nuevo usuario
    $sql_insert_user = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt_insert_user = $conn->prepare($sql_insert_user);
    $stmt_insert_user->bind_param("sssi", $username, $email, $password, $role);
    if ($stmt_insert_user->execute()) {
        // Usuario insertado exitosamente, redirigir o mostrar un mensaje de éxito
        $_SESSION['message'] = "Usuario creado exitosamente.";
        $_SESSION['message_type'] = "success";
        header("Location: manage_users.php");
        exit();
    } else {
        // Error al insertar el usuario
        $_SESSION['error_message'] = "Error al insertar el usuario.";
        header("Location: manage_users.php");
        exit();
    }

    // Cerrar las consultas preparadas y la conexión
    $stmt_check_username->close();
    $stmt_check_email->close();
    $stmt_insert_user->close();
    $conn->close();
}
?>
