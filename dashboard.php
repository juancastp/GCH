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
</head>
<body>
    <div class="container">
        <header class="container text-center py-4">
            <h1>Bienvenido, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role_name); ?>)</h1>
        </header>

        <main class="container">
            <div class="row">
                <div class="col-md-3">
                    <nav class="nav flex-column bg-light p-3 rounded">
                        <a class="nav-link" href="dashboard.php?page=profile">Perfil</a>
                        <a class="nav-link" href="dashboard.php?page=timesheet">Control Horario</a>
                        <?php if ($role_id == 1 || $role_id == 2): ?>
                            <a class="nav-link" href="dashboard.php?page=manage_users">Gestionar Usuarios</a>
                        <?php endif; ?>
                        <a class="nav-link" href="dashboard.php?page=reports">Informes</a>
                        <a class="nav-link" href="dashboard.php?page=settings">Configuraciones</a>
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </nav>
                </div>
                <div class="col-md-9">
                    <div class="content">
                        <?php
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                            $allowed_pages = array('profile', 'timesheet', 'manage_users', 'reports', 'settings');
                            if (in_array($page, $allowed_pages)) {
                                include($page . '.php');
                            } else {
                                echo "Página no encontrada.";
                            }
                        } else {
                            echo "Bienvenido al dashboard.";
                        }
                        ?>
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
    </div>
</body>
</html>
