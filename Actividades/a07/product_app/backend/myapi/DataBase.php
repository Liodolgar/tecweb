<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "marketzone";
    public $conexion;

    public function __construct() {
        $this->conectar();
    }

    private function conectar() {
        $this->conexion = new mysqli($this->host, $this->user, $this->password, $this->db);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");
    }

    public function cerrar() {
        $this->conexion->close();
    }
}
?>
