<?php 
session_start();

$mensaje = "";

if ($_POST) {
    // Validación de usuario y contraseña
    if ($_POST['usuario'] === 'prueba' && $_POST['contrasenia'] === 'admin') {
        $_SESSION['usuario'] = $_POST['usuario'];
        header('Location: secciones/index.php');
        exit(); // Asegúrate de detener la ejecución después de redirigir
    } else {
        $mensaje = "Usuario o contraseña incorrecto";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Inicio de sesión</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <form action="" method="post">
                    <div class="card">
                        <div class="card-header">
                            Inicio de sesión
                        </div>
                        <div class="card-body">
                            <!-- Mensaje de error -->
                            <?php if ($mensaje) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $mensaje; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" />
                            </div>

                            <div class="mb-3">
                                <label for="contrasenia" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="contrasenia" id="contrasenia" placeholder="Contraseña" />
                            </div>

                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQ+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
