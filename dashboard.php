<?php
session_start();
include('db_config.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener los detalles del usuario
$user_id = $_SESSION['user_id'];
$sql = "SELECT u.username, u.role_id, r.role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'];
$role_id = $user['role_id'];
$role_name = $user['role_name'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="container text-center py-4">
    <h1>Bienvenido, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role_name); ?>)</h1>
</header>

<main class="container">
    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column bg-light p-3 rounded">
                <a class="nav-link" href="profile.php">Perfil</a>
                <a class="nav-link" href="timesheet.php">Control Horario</a>
                <a class="nav-link" href="manage_users.php">Gestionar Usuarios</a>
                <a class="nav-link" href="reports.php">Informes</a>
                <a class="nav-link" href="settings.php">Configuraciones</a>
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </nav>
        </div>
        <div class="col-md-9">
            <div class="content">
                <h2>Dashboard</h2>
                <p>Bienvenido al sistema de control horario.</p>
                <!-- Aquí irán los contenidos específicos según el rol -->
            </div>
        </div>
    </div>
</main>

<footer class="container text-center py-4 mt-5">
    <p>© 2024 Nombre de la Empresa</p>
    <nav>
        <a href="privacy_policy.php">Política de Privacidad</a>
        <a href="terms_of_use.php">Términos de Uso</a>
    </nav>
</footer>

</body>
</html>
