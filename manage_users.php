<?php
include('db_config.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario tiene permisos para gestionar usuarios
$user_id = $_SESSION['user_id'];
$sql = "SELECT role_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role_id);
$stmt->fetch();
$stmt->close();

if ($role_id != 1 && $role_id != 2) { // Solo Webmaster y Encargado pueden gestionar usuarios
    header("Location: dashboard.php");
    exit();
}

// Obtener lista de usuarios
$sql = "SELECT u.id, u.username, u.email, r.role_name FROM users u JOIN roles r ON u.role_id = r.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Control Horario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 5px; /* Reducir margen superior */
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-footer .btn-primary {
            background-color: #007bff;
        }
        header.container {
            padding-top: 5px; /* Reducir padding superior */
        }
    </style>
</head>
<body>

<header class="container text-center py-2">
    <h3>Gestionar Usuarios</h3>
</header>

<main class="container">
    <!-- Mostrar mensajes -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Botón para agregar usuario -->
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addUserModal"><i class="bi bi-person-add"></i></a>
        </div>
    </div>
    
    <!-- Tabla de usuarios -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_array()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role_name']); ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal<?php echo $row['id']; ?>"><i class="bi bi-pencil-square"></i></a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal<?php echo $row['id']; ?>"><i class="bi bi-trash3"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal para agregar usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add_user.php" method="post">
                    <div class="form-group">
                        <label for="username">Nombre de Usuario:</label>
                        <input type="text" class="form-control" id="username" name="username" required <?php if(isset($_SESSION['error_username'])) echo 'value="' . htmlspecialchars($_SESSION['error_username']) . '"'; ?>>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required <?php if(isset($_SESSION['error_email'])) echo 'value="' . htmlspecialchars($_SESSION['error_email']) . '"'; ?>>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Rol:</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="1">Webmaster</option>
                            <option value="2">Encargado</option>
                            <option value="3">Empleado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<?php
$result = $conn->query($sql); // Ejecutar la consulta nuevamente para asegurar que tenemos todos los datos
while ($row = $result->fetch_array()):
?>
<div class="modal fade" id="editUserModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel<?php echo $row['id']; ?>">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="edit_user.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="edit_username<?php echo $row['id']; ?>">Nombre de Usuario:</label>
                        <input type="text" class="form-control" id="edit_username<?php echo $row['id']; ?>" name="edit_username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email<?php echo $row['id']; ?>">Email:</label>
                        <input type="email" class="form-control" id="edit_email<?php echo $row['id']; ?>" name="edit_email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_role<?php echo $row['id']; ?>">Rol:</label>
                        <select class="form-control" id="edit_role<?php echo $row['id']; ?>" name="edit_role" required>
                            <option value="1" <?php if ($row['role_name'] == 1) echo 'selected'; ?>>Webmaster</option>
                            <option value="2" <?php if ($row['role_name'] == 2) echo 'selected'; ?>>Encargado</option>
                            <option value="3" <?php if ($row['role_name'] == 3) echo 'selected'; ?>>Empleado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

<!-- Modal de confirmación de eliminación -->
<?php
$result = $conn->query($sql); // Ejecutar la consulta nuevamente para asegurar que tenemos todos los datos
while ($row = $result->fetch_array()):
?>
<div class="modal fade" id="confirmDeleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel<?php echo $row['id']; ?>">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar al usuario <strong><?php echo htmlspecialchars($row['username']); ?></strong>?</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="delete_user.php">
                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

<!-- Modal para mostrar mensaje de error -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="modal show" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-danger text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <a href="manage_users.php" class="close text-white" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <p><?php echo $_SESSION['error_message']; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="manage_users.php" class="btn btn-secondary">Cerrar</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3500);
});
</script>
</body>
</html>
