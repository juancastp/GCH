<?php
// Inicializar la sesión
session_start();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $action = $_POST['action']; // Acción: inicio, pausa, reinicio o parada
    $currentTime = date('Y-m-d H:i:s'); // Hora actual del servidor

    // Verificar si el usuario está autenticado
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']; // ID de usuario
        $role_id = $_GET['role_id']; // Obtener el valor de role_id
        $user_id = $_GET['user_id']; // Obtener el valor de user_id

        echo "Rol: " . $role_id . "<br>";
        echo "ID de usuario: " . $user_id . "<br>";
        
        // Manejar la acción enviada desde el cliente
        switch ($action) {
            // Tu código aquí
        }

        // Cerrar la conexión y liberar recursos
        $stmt->close();
    } else {
        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
        header("Location: login.php");
        exit();
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
