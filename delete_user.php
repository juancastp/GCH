<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario tiene permisos para gestionar usuarios
$user_id = $_SESSION['user_id'];
$sql = "SELECT role_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role_id);
$stmt->fetch();
$stmt->close();

if ($role_id != 1 && $role_id != 2) { // Solo Webmaster y Encargado pueden gestionar usuarios
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    $user_id_to_delete = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id_to_delete);
    $stmt->execute();
    $stmt->close();
    
    // Redirigir con un mensaje de éxito
    $_SESSION['message'] = "Usuario eliminado exitosamente.";
    $_SESSION['message_type'] = "success";
    header("Location: dashboard.php?page=manage_users");
    exit();
}
?>
