<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT role_id, username, email, role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role_id, $username, $email, $role_name);
$stmt->fetch();
$stmt->close();

if ($role_id === null || $username === null || $email === null || $role_name === null) {
    // Manejo del error: el usuario no se encontró en la base de datos
    echo "Error: usuario no encontrado.";
    exit();
}

// A partir de aquí, puedes usar $role_id, $username, $email y $role_name con la certeza de que están definidos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Control Horario</title>
    <!-- Usando la URL correcta para Bootstrap 5.1.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .full-width-container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        main {
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid full-width-container">
        <header class="container-fluid text-center py-4">
            <h1>Bienvenido, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role_name); ?>)</h1>
        </header>

        <main class="container-fluid">
            <div class="row no-gutters">
                <div class="col-md-3">
                    <nav class="nav flex-column bg-light p-3 rounded">
                        <a class="nav-link" href="profile.php">Perfil</a>
                        <a class="nav-link" href="#" onclick="loadRegisterHours()">Registrar Horas</a>
                        <?php if ($role_id == 1 || $role_id == 2): ?>
                            <a class="nav-link" href="dashboard.php?page=manage_users">Gestionar Usuarios</a>
                        <?php endif; ?>
                        <a class="nav-link" href="reports.php">Informes</a>
                        <a class="nav-link" href="settings.php">Configuraciones</a>
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </nav>
                </div>
                <div class="col-md-9">
                    <div class="content" id="contentArea">
                        <?php
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                            if ($page == 'manage_users' && ($role_id == 1 || $role_id == 2)) {
                                include('manage_users.php');
                            }
                        } else {
                            echo "<h2>Dashboard</h2><p>Bienvenido al sistema de control horario.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>

        <footer class="container-fluid text-center py-4 mt-5">
            <p>© 2024 Nombre de la Empresa</p>
            <nav>
                <a href="privacy_policy.php">Política de Privacidad</a>
                <a href="terms_of_use.php">Términos de Uso</a>
            </nav>
        </footer>
    </div>

    <!-- Modal para motivo de pausa -->
    <div class="modal fade" id="pauseModal" tabindex="-1" aria-labelledby="pauseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pauseModalLabel">Motivo de la Pausa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" id="pauseReason" placeholder="Escriba el motivo de la pausa"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmPause()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/register.js"></script>
    <script>
        console.log("dashboard.php loaded");
        function loadRegisterHours() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("contentArea").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "register_hours.php", true);
            xhttp.send();
        }
    </script>
</body>
</html>
