<?php
include('db_config.php');

// Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role'];

    // Validación básica
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Validación de la contraseña
        $password_pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!"·$%&\/()=?¿¡!,;.\-:_+*^{}\[\]<>]).{8,}$/';
        if (!preg_match($password_pattern, $password)) {
            $error = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo especial.";
        } else {
            // Verificar si el nombre de usuario o el correo ya existen
            $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "El nombre de usuario o el correo ya están registrados.";
            } else {
                // Hash de la contraseña
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el usuario en la base de datos
                $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $username, $email, $hashed_password, $role_id);

                if ($stmt->execute()) {
                    // Redirigir al usuario a la página de inicio de sesión con un mensaje de éxito
                    header("Location: login.php?success=1");
                    exit();
                } else {
                    // Mostrar un mensaje de error si la inserción falla
                    $error = "Error al registrar el usuario. Por favor, inténtalo de nuevo.";
                }
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="container text-center py-4">
    <h1>Nombre de la Empresa</h1>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php
            if (isset($error)) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            ?>
            <form action="register_user.php" method="post" class="bg-light p-4 rounded">
                <h2 class="mb-4">Registrarse</h2>
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role">Rol:</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="1">Webmaster</option>
                        <option value="2">Encargado</option>
                        <option value="3">Empleado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
            </form>
            <div class="mt-3 text-center">
                <a href="login.php">¿Ya tienes una cuenta? Inicia sesión aquí</a>
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
