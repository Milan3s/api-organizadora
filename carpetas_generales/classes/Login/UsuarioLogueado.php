<?php
require_once __DIR__ . '/../../config/Database.php'; // Ajuste de ruta usando __DIR__

class UsuarioLogueado extends Database {
    private $nombre_usuario;
    private $password;

    public function __construct($nombre_usuario, $password) {
        $this->nombre_usuario = $nombre_usuario;
        $this->password = md5($password);
    }

    public function login() {
        $this->getConnection();
        $query = "SELECT id_usuario, nombre_usuario FROM usuarios WHERE nombre_usuario = :nombre_usuario AND password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_usuario', $this->nombre_usuario);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];

            // Actualizar el estado a online
            $updateQuery = "UPDATE usuarios SET status = 'online' WHERE id_usuario = :id_usuario";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':id_usuario', $user['id_usuario']);
            $updateStmt->execute();

            return $user;
        } else {
            return false;
        }
    }

    public static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userId = self::obtenerIdUsuario();
        if ($userId) {
            // Crear instancia para obtener la conexión a la base de datos
            $instance = new self(null, null);
            $instance->getConnection();

            // Actualizar el estado a offline
            $updateQuery = "UPDATE usuarios SET status = 'offline' WHERE id_usuario = :id_usuario";
            $updateStmt = $instance->conn->prepare($updateQuery);
            $updateStmt->bindParam(':id_usuario', $userId);
            $updateStmt->execute();

            // Limpiar la sesión
            session_unset();
            session_destroy();

            return true;
        } else {
            return false;
        }
    }

    public static function obtenerUsuarioId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }

    public static function obtenerNombreUsuario() {
        return isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : null;
    }

    // Método añadido para obtener el ID del usuario logueado
    public static function obtenerIdUsuario() {
        return self::obtenerUsuarioId();
    }
}
?>
