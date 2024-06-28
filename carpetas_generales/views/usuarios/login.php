<a href="../../classes/Login/UsuarioLogueado.php"></a>
<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/dashboard.php"); // Redirigir a la página principal o dashboard
    exit();
}

require_once '../../config/Database.php';
require_once '../../classes/Login/UsuarioLogueado.php';

$mensaje = '';
$clase_alerta = '';
$mostrar_loader = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    // Agregar mensajes de depuración
    error_log("POST data received: nombre_usuario = $nombre_usuario, password = $password");

    $usuario = new UsuarioLogueado($nombre_usuario, $password);
    $user = $usuario->login();
    if ($user) {
        $_SESSION['user_id'] = $user['id_usuario']; // Corregido para usar el ID del usuario
        error_log("Inicie sesión exitosamente para user_id: " . $_SESSION['user_id']);
        $mensaje = "Usuario ha iniciado sesión exitosamente. Redirigiendo al dashboard en <span id='contador'>3</span>...";
        $clase_alerta = 'alert-success';
        $mostrar_loader = true;
    } else {
        error_log("Error de inicio de sesión para la usuario: $nombre_usuario");
        $mensaje = "Nombre de usuario o contraseña incorrectos.";
        $clase_alerta = 'alert-danger';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../framework/custom/estilos_personalizados.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Acceso</title>
    <style>
        /* Puedes agregar estilos personalizados aquí */
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <?php if (!empty($mensaje)): ?>
                <div class="col-12">
                    <div class="alert <?php echo $clase_alerta; ?>" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div id="clock-container" class="col-12">
                <div id="clock">19:24:56</div>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php if ($mostrar_loader): ?>
                <div class="col-12 text-center">
                    <p id="redireccion"></p>
                </div>
                <script>
                    let contador = 3;
                    let interval = setInterval(function() {
                        document.getElementById('contador').innerText = contador;
                        if (contador === 0) {
                            clearInterval(interval);
                            window.location.href = '../dashboard/dashboard.php';
                        } else {
                            contador--;
                        }
                    }, 1000);
                </script>
            <?php endif; ?>
            <div class="contenedor-formulario col-12">
                <div class="card card-login">
                    <div class="card-body">
                        <h5 class="card-title texto-login-alineado fuente-login">Login</h5>
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons">account_circle</i></span>
                                    <input id="nombre_usuario" type="text" name="nombre_usuario" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons">lock</i></span>
                                    <input id="password" type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="texto-login-alineado">
                                <button class="btn btn-success" type="submit">Acceder</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer texto-login-alineado">
                        <span>¿No tienes cuenta? Dale clic en <br><a href="registro.php" class="texto-registrarse">registrarse</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../framework/js/jquery-3.7.1.js"></script>
    <script src="../../../framework/js/bootstrap.min.js"></script>
    <script src="../../../framework/js/bootstrap.bundle.js"></script>
    <script src="../../../framework/js/scripts.js"></script>
</body>
</html>
