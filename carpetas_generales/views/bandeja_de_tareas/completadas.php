<?php
session_start();

require_once '../../config/Database.php';

require_once '../../classes/Login/UsuarioLogueado.php';

$nombreUsuario = UsuarioLogueado::obtenerNombreUsuario();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../framework/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="../../../framework/custom/tareas-completadas.css">
    <title>Tareas Completadas</title>
</head>
<body>
<header>
    <?php 
        require_once('../partials/menu.php');
    ?>
</header>
    <!-- Resto de Contenido -->
    <div class="container">
        <div class="col-lg-12">
            <div class="row">
                <div class="titulo-bienvenida">
                    <?php echo "<span class='texto-bienvenida'> Bienvenido a Tareas Completadas, </span> "
                                ."<span class='color-usuario'>". ($nombreUsuario ?? 'Invitado') ."</span>";?>
                </div>
            </div>

            
        </div>
    </div>
    
    <?php
        require_once('../partials/footer.php')
    ?>
</body>
</html>