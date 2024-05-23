<?php
// Incluir el archivo de configuración de la base de datos
include('db_config.php');

// Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Consulta para verificar el usuario
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    // Comprobar si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();
        
        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Contraseña correcta, iniciar sesión
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            
            // Redirigir al usuario a la página de inicio
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Control Horario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<header class="container text-center py-4">
    <h1>Nombre de la Empresa</h1>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="login.php" method="post" class="bg-light p-4 rounded">
                <h2 class="mb-4">Iniciar Sesión</h2>
                <?php
                if (isset($error)) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                ?>
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
            <div class="mt-3 text-center">
                <a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
                <br>
                <a href="signup.php">¿Necesitas una cuenta?</a>
                <br>
                <a href="contact.php">¿Necesitas ayuda?</a>
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
