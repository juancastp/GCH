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
