// Código JavaScript para manejar los botones y el temporizador
document.addEventListener("DOMContentLoaded", function() {
    // Variables para el temporizador y estado
    let timerInterval;
    let startTime;
    let elapsedTime = 0;
    let timerRunning = false;
    let pauseReason;

    // Obtener referencias a los elementos del DOM
    const startButton = document.getElementById("startButton");
    const pauseButton = document.getElementById("pauseButton");
    const stopButton = document.getElementById("stopButton");
    const timeRegistrationForm = document.getElementById("timeRegistrationForm");

    // Evento click para el botón de inicio
    startButton.addEventListener("click", function() {
        if (!timerRunning) {
            startTime = Date.now() - elapsedTime;
            timerInterval = setInterval(updateTime, 1000);
            timerRunning = true;
            pauseButton.disabled = false;
            stopButton.disabled = false;
            // Aquí enviar solicitud de inicio al servidor
            // Agregar lógica para inyectar datos en la base de datos con el comentario "inicio de jornada"
        }
    });

    // Evento click para el botón de pausa
    pauseButton.addEventListener("click", function() {
        clearInterval(timerInterval);
        timerRunning = false;
        // Mostrar modal para solicitar motivo de pausa
        $('#pauseModal').modal('show');
    });

    // Evento click para el botón de detener
    stopButton.addEventListener("click", function() {
        clearInterval(timerInterval);
        timerRunning = false;
        elapsedTime = 0;
        // Aquí enviar solicitud de parada al servidor
        // Agregar lógica para inyectar datos en la base de datos con el comentario "fin de jornada"
        timeRegistrationForm.submit(); // Esto enviará el formulario
    });

    // Función para actualizar el temporizador
    function updateTime() {
        let currentTime = Date.now();
        elapsedTime = currentTime - startTime;
        // Aquí podrías actualizar la interfaz de usuario para mostrar el tiempo transcurrido
    }

    // Evento click para el botón de confirmar pausa en el modal
    document.getElementById('confirmPauseButton').addEventListener('click', function() {
        pauseReason = document.getElementById('pauseReason').value;
        $('#pauseModal').modal('hide');
        // Aquí enviar solicitud de pausa al servidor
        // Agregar lógica para inyectar datos en la base de datos con el comentario de la pausa
    });
});
