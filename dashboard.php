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
    
    <h3 class="mt-4">Registros de Horas</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Entrada</th>
                <th>Salida</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Ejemplo de datos ficticios
            $registros = [
                ['id' => 1, 'empleado' => 'Juan Pérez', 'fecha' => '2024-05-20', 'entrada' => '08:00', 'salida' => '17:00'],
                ['id' => 2, 'empleado' => 'Ana Gómez', 'fecha' => '2024-05-20', 'entrada' => '09:00', 'salida' => '18:00'],
            ];

            foreach ($registros as $registro) {
                echo "<tr>
                        <td>{$registro['id']}</td>
                        <td>{$registro['empleado']}</td>
                        <td>{$registro['fecha']}</td>
                        <td>{$registro['entrada']}</td>
                        <td>{$registro['salida']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<footer class="container text-center py-4 mt-5">
    <p>© 2024 Nombre de la Empresa</p>
</footer>

</body>
</html>
