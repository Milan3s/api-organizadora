<?php
    session_start();
    require_once 'UsuarioLogueado.php';

    UsuarioLogueado::logout();
    
    header('Location: ../../views/usuarios/login.php');
    exit();
?>

