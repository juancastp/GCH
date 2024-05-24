<?php
session_start();
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

$action = $_GET['action'];
$user_id = $_GET['id'] ?? null;

if ($action == 'edit' && $user_id) {
    // Obtener detalles del usuario
    $sql = "SELECT username, email, role_id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email, $role_id);
    $stmt->fetch();
    $stmt->close();
} else {
    $username = $email = $role_id = '';
}

// Obtener lista de roles
$sql = "SELECT id, role_name FROM roles";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];
    $password = $_POST['password'];

    if ($action == 'add') {
        // Agregar nuevo usuario
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $password_hashed, $role_id);
    } else {
        // Editar usuario existente
        if (!empty($password)) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = ?, email = ?, password = ?, role_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssii", $username, $email, $password_hashed, $role_id, $user_id);
        } else {
            $sql = "UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $username, $email, $role_id, $user_id);
        }
    }

    if ($stmt->execute()) {
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $action == 'add' ? 'Agregar' : 'Editar'; ?> Usuario - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="container text-center py-4">
    <h1><?php echo $action == 'add' ? 'Agregar' : 'Editar'; ?> Usuario</h1>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="post" class="bg-light p-4 rounded">
                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" <?php echo $action == 'add' ? 'required' : ''; ?>>
                    <?php if ($action == 'edit'): ?>
                    <small class="form-text text-muted">Deje en blanco si no desea cambiar la contraseña.</small>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="role_id">Rol:</label>
                    <select id="role_id" name="role_id" class="form-control" required>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $role_id ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['role_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><?php echo $action == 'add' ? 'Agregar' : 'Guardar'; ?> Usuario</button>
            </form>
            <div class="mt-3 text-center">
                <a href="manage_users.php">Volver a la gestión de usuarios</a>
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
