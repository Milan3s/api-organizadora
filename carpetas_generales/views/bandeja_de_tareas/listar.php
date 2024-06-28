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
    <link rel="stylesheet" href="../../../framework/custom/listar-tareas.css">
    <title>Tareas Pendientes</title>
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
                <div class="centrar-titulo-listar">
                    <h2>Listas de todas las Tareas</h2>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Descripción</th>
                            <th>User ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Proyecto 1</td>
                            <td><img src="imagen1.png" alt="Imagen Proyecto 1"></td>
                            <td>Descripción del Proyecto 1</td>
                            <td>101</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Proyecto 2</td>
                            <td><img src="imagen2.png" alt="Imagen Proyecto 2"></td>
                            <td>Descripción del Proyecto 2</td>
                            <td>102</td>
                        </tr>
                        <!-- Agrega más filas según sea necesario -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
        require_once('../partials/footer.php')
    ?>
</body>
</html>