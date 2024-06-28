<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/dashboard.php"); // Redirigir a la página principal o dashboard
    exit();
}

require_once '../../config/Database.php';
require_once '../../classes/Login/UsuarioRegistrado.php';

$mensaje = '';
$clase_alerta = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];
    $correo = $_POST['correo'];

    $database = new Database();
    $db = $database->getConnection();
    
    // Verificar si el usuario ya existe
    $query = "SELECT id_usuario FROM usuarios WHERE nombre_usuario = :nombre_usuario OR correo_electronico = :correo";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nombre_usuario', $nombre_usuario);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $mensaje = "El usuario o correo ya existe. Intente con otro nombre de usuario o correo.";
        $clase_alerta = 'alert-danger';
    } else {
        $usuarioRegistrado = new UsuarioRegistrado($nombre_usuario, $password, $correo);

        if ($usuarioRegistrado->registrar()) {
            $mensaje = "Usuario registrado exitosamente. Esperando aprobación del administrador.";
            $clase_alerta = 'alert-success';
        } else {
            $mensaje = "Error al registrar el usuario.";
            $clase_alerta = 'alert-danger';
        }
    }
}
?>
<!-- Formulario HTML para registro de usuario -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../framework/custom/estilos_personalizados.css">
    <link rel="stylesheet" href="../../../framework/custom/registro.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Registro de Usuario</title>
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
            <div class="contenedor-formulario col-12">
                <div class="card card-registro">
                    <div class="card-body">
                        <h5 class="card-title texto-login-alineado fuente-login">Registro</h5>
                        <form action="registro.php" method="POST">
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
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons">email</i></span>
                                    <input id="correo" type="email" name="correo" class="form-control" required>
                                </div>
                            </div>
                            <div class="texto-login-alineado">
                                <button class="btn btn-success" type="submit">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer texto-login-alineado">
                        <span>¿Ya tienes cuenta? <a href="login.php" class="texto-registrarse">Iniciar sesión</a></span>
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
