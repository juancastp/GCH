<?php
// Inicializar la sesión
session_start();

// Incluir el archivo de configuración de la base de datos
include('db_config.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $action = $_POST['action']; // Acción: inicio, pausa, reinicio o parada
    $currentTime = date('Y-m-d H:i:s'); // Hora actual del servidor

    // Verificar si el usuario está autenticado
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']; // ID de usuario

        // Manejar la acción enviada desde el cliente
        switch ($action) {
            case 'inicio':
                // Insertar registro de inicio de jornada en la base de datos
                $comment = "Inicio de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                break;

            case 'pausa':
                // Recuperar el motivo de la pausa enviado desde el cliente
                $pauseReason = $_POST['pauseReason'];
                // Insertar registro de pausa en la base de datos
                $comment = "Pausa: " . $pauseReason;
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                break;

            case 'reinicio':
                // Insertar registro de reinicio de jornada en la base de datos
                $comment = "Reinicio de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                break;

            case 'parada':
                // Insertar registro de fin de jornada en la base de datos
                $comment = "Fin de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                break;

            default:
                // Acción no válida
                echo "Acción no válida.";
                break;
        }
        echo "Rol: " . $role_id . "<br>";
        echo "ID de usuario: " . $user_id . "<br>";
        
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
