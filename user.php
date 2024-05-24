<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="container text-center py-4">
    <h1>Gestión de Usuarios</h1>
    <nav>
        <a href="dashboard.php" class="btn btn-primary">Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </nav>
</header>

<main class="container">
    <h3 class="mt-4">Usuarios</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('db_config.php');
            $sql = "SELECT id, username, email FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>
                                <a href='edit_user.php?id={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='delete_user.php?id={$row['id']}' class='btn btn-danger btn-sm'>Eliminar</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="add_user.php" class="btn btn-success">Añadir Usuario</a>
</main>

<footer class="container text-center py-4 mt-5">
    <p>© 2024 Nombre de la Empresa</p>
</footer>

</body>
</html>
