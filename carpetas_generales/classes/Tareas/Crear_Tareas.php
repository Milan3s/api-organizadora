<?php
require_once '../../config/Database.php';

class Crear_Tareas extends Database {
    public function crear_Tareas($nombre, $descripcion, $userId, $imagenPath) {
        $this->getConnection();
        $query = "INSERT INTO tareas (nombre, descripcion, user_id, imagen) VALUES (:nombre, :descripcion, :user_id, :imagen)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':imagen', $imagenPath);
        
        if($stmt->execute()) {            
            return true;
        } else {
            return false;
        }
    }
}
?>