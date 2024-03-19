<?php
class DBConnection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "Conexion";
    private $dbname = "tutienda";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("La conexión falló: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>

