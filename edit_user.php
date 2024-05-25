<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $role_id = $_POST['edit_role'];

    $sql = "UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $username, $email, $role_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Usuario editado exitosamente';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error al editar el usuario';
        $_SESSION['message_type'] = 'danger';
    }

    $stmt->close();
    header("Location: dashboard.php?page=manage_users");
    exit();
}
?>
