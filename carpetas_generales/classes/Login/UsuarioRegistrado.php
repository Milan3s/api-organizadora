<?php
require_once __DIR__ . '/../../config/Database.php'; // Ajuste de ruta usando __DIR__

class UsuarioRegistrado extends Database {
    private $nombre_usuario;
    private $password;
    private $correo;

    public function __construct($nombre_usuario, $password, $correo) {
        $this->nombre_usuario = $nombre_usuario;
        $this->password = md5($password);
        $this->correo = $correo;
    }

    public function registrar() {
        $this->getConnection();
        $query = "INSERT INTO usuarios (nombre_usuario, password, correo_electronico) VALUES (:nombre_usuario, :password, :correo_electronico)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_usuario', $this->nombre_usuario);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':correo_electronico', $this->correo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>