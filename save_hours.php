<?php
include('auth.php');
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $entrada = $_POST['entrada'];
    $salida = $_POST['salida'];
    $user_id = $_SESSION['id'];
    
    $sql = "INSERT INTO registros_horas (user_id, fecha, entrada, salida) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $fecha, $entrada, $salida);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        header("Location: dashboard.php");
    } else {
        echo "Error al guardar el registro.";
    }

    $stmt->close();
    $conn->close();
}
?>
