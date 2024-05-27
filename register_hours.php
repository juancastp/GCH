<?php
session_start();
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $currentTime = date('Y-m-d H:i:s');

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        switch ($action) {
            case 'inicio':
                $comment = "Inicio de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario, latitude, longitude) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issdd", $userId, $currentTime, $comment, $latitude, $longitude);
                $stmt->execute();
                echo "Inicio de jornada registrado.";
                break;
                
            case 'pausa':
                $pauseReason = $_POST['pauseReason'];
                $comment = "Pausa iniciada - Motivo: " . $pauseReason;
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario, latitude, longitude) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issdd", $userId, $currentTime, $comment, $latitude, $longitude);
                $stmt->execute();
                echo "Pausa iniciada.";
                break;

                case 'reinicio':
                    $continueReason = "Fin de la pausa";
                    $comment = "Fin de pausa - Motivo: " . $continueReason;
                    $sql = "INSERT INTO registros_horas (user_id, hora, comentario, latitude, longitude) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("issdd", $userId, $currentTime, $comment, $latitude, $longitude);
                    $stmt->execute();
                    echo "Fin de pausa registrado.";
                    break;

            case 'parada':
                $comment = "Fin de jornada";
                $sql = "INSERT INTO registros_horas (user_id, hora, comentario, latitude, longitude) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issdd", $userId, $currentTime, $comment, $latitude, $longitude);
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


<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Horas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
<div class="container text-center">
    <h1>Registrar Horas</h1>
    <div id="time-counter" class="mb-3"></div>
    <div>
        <button id="startButton" class="btn btn-primary" onclick="startWork()">Iniciar Jornada</button>
        <button id="continueButton" class="btn btn-success" onclick="continueWork()" disabled>Continuar Jornada</button>
        <button id="pauseButton" class="btn btn-warning" onclick="pauseWork()" disabled>Pausa</button>
        <button id="stopButton" class="btn btn-danger" onclick="stopWork()" disabled>Parada</button>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
let startTime;
let timerInterval;
let pausedTime = 0;

function startWork() {
    console.log("startWork() called");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log("Geolocation success");
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "register_hours.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    console.log("AJAX request state: " + xhr.readyState);
                    if (xhr.status == 200) {
                        console.log("Response from server: " + xhr.responseText);
                        document.getElementById("startButton").disabled = true;
                        document.getElementById("pauseButton").disabled = false;
                        document.getElementById("stopButton").disabled = false;
                        startTime = new Date();
                        startTimer();
                    } else {
                        console.error("AJAX request failed with status: " + xhr.status);
                    }
                }
            };
            console.log("Sending AJAX request with data: " + "action=inicio&latitude=" + latitude + "&longitude=" + longitude);
            xhr.send("action=inicio&latitude=" + latitude + "&longitude=" + longitude);
        }, function(error) {
            console.error("Geolocation error: " + error.message);
        });
    } else {
        console.error("Geolocation not supported by this browser.");
    }
}

function startTimer() {
    console.log("startTimer() called");
    timerInterval = setInterval(function() {
        const now = new Date();
        const elapsedTime = now - startTime + pausedTime;
        const hours = Math.floor(elapsedTime / 3600000);
        const minutes = Math.floor((elapsedTime % 3600000) / 60000);
        const seconds = Math.floor((elapsedTime % 60000) / 1000);
        document.getElementById("time-counter").textContent = 
            ("0" + hours).slice(-2) + ":" + ("0" + minutes).slice(-2) + ":" + ("0" + seconds).slice(-2);
    }, 1000);
}

function pauseWork() {
    console.log("pauseWork() called");
    // Implementar funcionalidad de pausa
    console.log("pauseWork() called");
    const pauseReason = prompt("Escriba el motivo de la pausa:");
    if (pauseReason !== null && pauseReason !== "") {
        clearInterval(timerInterval);
        pausedTime += new Date() - startTime;
        document.getElementById("startButton").style.display = "none";
        document.getElementById("continueButton").disabled = false;
        document.getElementById("pauseButton").disabled = true;
        document.getElementById("stopButton").disabled = false;
    }
}

function stopWork() {
    console.log("stopWork() called");
    clearInterval(timerInterval);
    document.getElementById("startButton").disabled = false;
    document.getElementById("pauseButton").disabled = true;
    document.getElementById("stopButton").disabled = true;
    document.getElementById("continueButton").disabled = true;
    document.getElementById("time-counter").textContent = "00:00:00";
    startTime = null;
    pausedTime = 0;
}

function continueWork() {
    console.log("continueWork() called");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log("Geolocation success");
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "register_hours.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    console.log("AJAX request state: " + xhr.readyState);
                    if (xhr.status == 200) {
                        console.log("Response from server: " + xhr.responseText);
                        document.getElementById("pauseButton").disabled = false;
                        document.getElementById("stopButton").disabled = false;
                        document.getElementById("continueButton").disabled = true;
                        startTime = new Date();
                        startTimer();
                    } else {
                        console.error("AJAX request failed with status: " + xhr.status);
                    }
                }
            };
            console.log("Sending AJAX request with data: " + "action=continuar&latitude=" + latitude + "&longitude=" + longitude);
            xhr.send("action=continuar&latitude=" + latitude + "&longitude=" + longitude);
        }, function(error) {
            console.error("Geolocation error: " + error.message);
        });
    } else {
        console.error("Geolocation not supported by this browser.");
    }
}

</script>
</body>
</html>