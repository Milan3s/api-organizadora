<?php
class Database {
    // Definir constantes para la conexión
    private const HOST = 'localhost';
    private const DB_NAME = 'sistema_de_tareas';
    private const USERNAME = 'root';
    private const PASSWORD = '';

    protected $conn;

    // Método para obtener la conexión
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME,
                self::USERNAME,
                self::PASSWORD
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
