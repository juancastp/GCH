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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
function loadRegisterHours() {
    // Realizar una solicitud AJAX para cargar register_hours.php
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Actualizar el contenido del área de contenido con el contenido de register_hours.php
            document.getElementById("contentArea").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "register_hours.php", true);
    xhttp.send();
}
</script>

</body>
</html>
