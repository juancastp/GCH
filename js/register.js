document.addEventListener('DOMContentLoaded', function () {
    var startWorkBtn = document.getElementById('startWorkBtn');
    var pauseWorkBtn = document.getElementById('pauseWorkBtn');
    var resumeWorkBtn = document.getElementById('resumeWorkBtn');
    var stopWorkBtn = document.getElementById('stopWorkBtn');
    var pauseReasonDiv = document.getElementById('pauseReasonDiv');
    var timer = document.getElementById('timer');
    var startTime;
    var timerInterval;

    startWorkBtn.addEventListener('click', function () {
        console.log("Start Work button clicked");
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log("Geolocation obtained: ", latitude, longitude);
                handleRegister('inicio', latitude, longitude);
                startTime = new Date();
                startTimer();
                startWorkBtn.disabled = true;
                pauseWorkBtn.disabled = false;
                stopWorkBtn.disabled = false;
            }, function(error) {
                console.error("Error obtaining geolocation: ", error);
                document.getElementById('response').innerHTML = "Error obteniendo geolocalización: " + error.message;
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
            document.getElementById('response').innerHTML = "La geolocalización no es soportada por este navegador.";
        }
    });

    pauseWorkBtn.addEventListener('click', function () {
        console.log("Pause Work button clicked");
        pauseReasonDiv.classList.remove('d-none');
        handleRegister('pausa', null, null, document.getElementById('pauseReason').value);
        pauseWorkBtn.classList.add('d-none');
        resumeWorkBtn.classList.remove('d-none');
        stopTimer();
    });

    resumeWorkBtn.addEventListener('click', function () {
        console.log("Resume Work button clicked");
        handleRegister('reinicio');
        pauseReasonDiv.classList.add('d-none');
        resumeWorkBtn.classList.add('d-none');
        pauseWorkBtn.classList.remove('d-none');
        startTime = new Date() - (new Date() - startTime);
        startTimer();
    });

    stopWorkBtn.addEventListener('click', function () {
        console.log("Stop Work button clicked");
        handleRegister('parada');
        startWorkBtn.disabled = false;
        pauseWorkBtn.disabled = true;
        stopWorkBtn.disabled = true;
        resumeWorkBtn.disabled = true;
        stopTimer();
    });

    function handleRegister(action, latitude = null, longitude = null, pauseReason = '') {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'register_hours.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Response received: ", xhr.responseText);
                document.getElementById('response').innerHTML = xhr.responseText;
            } else if (xhr.readyState === 4) {
                console.error("Error in AJAX request: ", xhr.statusText);
                document.getElementById('response').innerHTML = "Error en la solicitud AJAX: " + xhr.statusText;
            }
        };
        var params = 'action=' + action + '&latitude=' + encodeURIComponent(latitude) + '&longitude=' + encodeURIComponent(longitude) + '&pauseReason=' + encodeURIComponent(pauseReason);
        console.log("Sending request: ", params);
        xhr.send(params);
    }

    function startTimer() {
        timerInterval = setInterval(function () {
            var currentTime = new Date();
            var timeElapsed = new Date(currentTime - startTime);
            var hours = timeElapsed.getUTCHours().toString().padStart(2, '0');
            var minutes = timeElapsed.getUTCMinutes().toString().padStart(2, '0');
            var seconds = timeElapsed.getUTCSeconds().toString().padStart(2, '0');
            timer.textContent = `${hours}:${minutes}:${seconds}`;
        }, 1000);
    }

    function stopTimer() {
        clearInterval(timerInterval);
        timer.textContent = '';
    }
});
