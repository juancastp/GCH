<?php include('auth.php'); ?>
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
    <h1>Dashboard</h1>
    <nav>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </nav>
</header>

<main class="container">
    <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
</main>

<footer class="container text-center py-4 mt-5">
    <p>© 2024 Nombre de la Empresa</p>
</footer>

</body>
</html>
