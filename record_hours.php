<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Horas - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="container text-center py-4">
    <h1>Registrar Horas</h1>
    <nav>
        <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </nav>
</header>

<main class="container">
    <form action="save_hours.php" method="post" class="bg-light p-4 rounded">
        <h2 class="mb-4">Registrar Horas</h2>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="entrada">Hora de Entrada:</label>
            <input type="time" id="entrada" name="entrada" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="salida">Hora de Salida:</label>
            <input type="time" id="salida" name="salida" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
    </form>
</main>

<footer class="container text-center py-4 mt-5">
    <p>© 2024 Nombre de la Empresa</p>
</footer>

</body>
</html>
