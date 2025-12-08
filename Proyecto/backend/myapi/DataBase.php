<?php
namespace TECWEB\MYAPI;

abstract class DataBase {
    protected $conexion;
    protected array $data = [];

    public function __construct($db, $user = 'root', $pass = '') {
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );
    
        /**
         * NOTA: si la conexión falló $conexion contendrá false
         **/
        if(!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }
        
        // Establecer charset UTF-8
        $this->conexion->set_charset("utf8mb4");
    }
    
    public function getData() {
        // SE HACE LA CONVERSIÓN DE ARRAY A JSON
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>