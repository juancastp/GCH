let startTime;
let timerInterval;
let pausedTime; // Variable para almacenar el tiempo de pausa

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
        const elapsedTime = now - startTime;
        const hours = Math.floor(elapsedTime / 3600000);
        const minutes = Math.floor((elapsedTime % 3600000) / 60000);
        const seconds = Math.floor((elapsedTime % 60000) / 1000);
        document.getElementById("time-counter").textContent = 
            ("0" + hours).slice(-2) + ":" + ("0" + minutes).slice(-2) + ":" + ("0" + seconds).slice(-2);
    }, 1000);
}

function pauseWork() {
    console.log("pauseWork() called");
    const pauseReason = prompt("Escriba el motivo de la pausa:");
    if (pauseReason !== null && pauseReason !== "") {
        clearInterval(timerInterval);
        pausedTime = new Date(); // Guardar el tiempo actual al pausar
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "register_hours.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            console.log("Response from server: " + xhr.responseText);
                            document.getElementById("startButton").disabled = false;
                            document.getElementById("continueButton").disabled = false;
                            document.getElementById("pauseButton").disabled = true;
                            document.getElementById("stopButton").disabled = false;
                        } else {
                            console.error("AJAX request failed with status: " + xhr.status);
                        }
                    }
                };
                xhr.send("action=pausa&latitude=" + latitude + "&longitude=" + longitude + "&pauseReason=" + encodeURIComponent(pauseReason));
            }, function(error) {
                console.error("Geolocation error: " + error.message);
            });
        } else {
            console.error("Geolocation not supported by this browser.");
        }
    }
}

function stopWork() {
    console.log("stopWork() called");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "register_hours.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log("Response from server: " + xhr.responseText);
                        clearInterval(timerInterval);
                        document.getElementById("startButton").disabled = false;
                        document.getElementById("pauseButton").disabled = true;
                        document.getElementById("stopButton").disabled = true;
                        document.getElementById("time-counter").textContent = "00:00:00";
                    } else {
                        console.error("AJAX request failed with status: " + xhr.status);
                    }
                }
            };
            console.log("Sending AJAX request with data: " + "action=parada&latitude=" + latitude + "&longitude=" + longitude);
            xhr.send("action=parada&latitude=" + latitude + "&longitude=" + longitude);
        }, function(error) {
            console.error("Geolocation error: " + error.message);
        });
    } else {
        console.error("Geolocation not supported by this browser.");
    }
}

function continueWork() {
    console.log("continueWork() called");
    clearInterval(timerInterval);
    startTime = new Date(); // Establecer el tiempo actual como inicio
    const elapsedTime = startTime - pausedTime; // Calcular el tiempo transcurrido durante la pausa
    startTime.setTime(startTime.getTime() - elapsedTime); // Restaurar el tiempo inicial restando el tiempo de pausa
    startTimer();
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
};
