<?php
session_start();

require_once '../../config/Database.php';
require_once '../../classes/Tareas/Crear_Tareas.php';
require_once '../../classes/Login/UsuarioLogueado.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['nombreCarpeta'])) {
    $nombreTarea = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $nombreCarpeta = $_POST['nombreCarpeta'];
    $rutaCarpeta = '../bandeja_de_recursos/' . $nombreCarpeta;
    
    if (!file_exists($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);
        $message = "Carpeta creada exitosamente.";
    } else {
        $message = "La carpeta ya existe.";
    }

    // Asegúrate de manejar la subida de archivos
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        $imagenPath = $rutaCarpeta . '/' . basename($imagen['name']);
        move_uploaded_file($imagen['tmp_name'], $imagenPath);
        
        // Guarda los datos en la sesión para usarlos después
        $_SESSION['nombreTarea'] = $nombreTarea;
        $_SESSION['descripcion'] = $descripcion;
        $_SESSION['imagenPath'] = $imagenPath;
        
        $message .= "<br> Imagen subida correctamente.";

        // Insertar los datos en la base de datos
        $userId = UsuarioLogueado::obtenerIdUsuario();

        $tarea = new Crear_Tareas();
        if ($tarea->crear_Tareas($nombreTarea, $descripcion, $userId, $imagenPath)) {
            $message .= "<br> Tarea creada exitosamente.";
        } else {
            $message .= "<br> Error al crear la tarea en la base de datos.";
        }

    } else {
        $message .= " Error al subir la imagen.";
    }
}

$nombreUsuario = UsuarioLogueado::obtenerNombreUsuario();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../framework/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../framework/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="../../../framework/custom/crear_tareas.css">
    <title>Crear Tareas</title>
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
                    <?php echo "<span class='texto-bienvenida'> Bienvenido a Crear Tareas, </span> "
                                ."<span class='color-usuario'>". ($nombreUsuario ?? 'Invitado') ."</span>";?>
                </div>
            </div>

            <div class="row">
                <div class="form-container">
                    <form id="tareaForm" action="" method="POST" enctype="multipart/form-data">                    
                        <div class="form-group1">
                            <input type="text" id="nombre" name="nombre" placeholder="Nombre de la Tarea..." required>
                            <textarea name="descripcion" placeholder="Descripción de la tarea..." required></textarea>
                            <input type="text" id="nombreCarpeta" name="nombreCarpeta" placeholder="Nombre de la carpeta..." required>
                        </div>                        
                            
                        <div class="form-group2">
                            <label for="imagen" class="subir-imagen">Subir imagen</label>
                            <input type="file" id="imagen" name="imagen" accept="image/*" required><br>
                        </div>

                        <button type="submit" class="btn btn-primary">Crear Tarea</button>
                    </form>
                    <?php
                        if ($message) {
                            echo "<p class='message'>$message</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        require_once('../partials/footer.php')
    ?>
</body>
</html>