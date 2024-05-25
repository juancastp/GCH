<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $currentTime = date('Y-m-d H:i:s');
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;
    $pauseReason = $_POST['pauseReason'] ?? '';

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        switch ($action) {
            case 'inicio':
                $comment = "Inicio de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario, latitud, longitud) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issss", $userId, $currentTime, $comment, $latitude, $longitude);
                $stmt->execute();
                echo "Inicio de jornada registrado.";
                break;

            case 'pausa':
                $comment = "Pausa: " . $pauseReason;
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                echo "Pausa registrada.";
                break;

            case 'reinicio':
                $comment = "Reinicio de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                echo "Reinicio de jornada registrado.";
                break;

            case 'parada':
                $comment = "Fin de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $userId, $currentTime, $comment);
                $stmt->execute();
                echo "Fin de jornada registrado.";
                break;

            default:
                echo "Acción no válida.";
                break;
        }
        $stmt->close();
    } else {
        echo "Error: usuario no autenticado.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Horas - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <script src="js/register.js"></script>
    <style>
        .btn-group-center {
            display: flex;
            justify-content: center;
        }
        .btn-group-center .btn {
            margin: 0 10px;
        }
        #timer {
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Registrar Horas</h2>
        <div id="timer" class="text-center"></div>
        <div class="btn-group-center">
            <button id="startWorkBtn" class="btn btn-primary">
                <i class="bi bi-play-fill"></i> Inicio de Jornada
            </button>
            <button id="pauseWorkBtn" class="btn btn-warning" disabled>
                <i class="bi bi-pause-fill"></i> Pausa
            </button>
            <button id="resumeWorkBtn" class="btn btn-success d-none">
                <i class="bi bi-play-fill"></i> Reinicio de Jornada
            </button>
            <button id="stopWorkBtn" class="btn btn-danger" disabled>
                <i class="bi bi-stop-fill"></i> Fin de Jornada
            </button>
        </div>
        <div class="form-group mt-3 d-none" id="pauseReasonDiv">
            <label for="pauseReason">Motivo de la pausa:</label>
            <input type="text" id="pauseReason" class="form-control" placeholder="Motivo de la pausa">
        </div>
        <div id="response" class="mt-3"></div>
    </div>
</body>
</html>
