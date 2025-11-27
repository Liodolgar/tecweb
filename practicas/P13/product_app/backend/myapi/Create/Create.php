<?php
namespace TECWEB\MYAPI\Create;

use TECWEB\MYAPI\DataBase;

class Create extends DataBase {
    
    public function __construct($db, $user='root', $pass='') {
        parent::__construct($db, $user, $pass);
    }

    public function add($jsonOBJ) {
        $data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );
        
        if(isset($jsonOBJ->nombre)) {
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND Eliminado = 0";
            $result = $this->conexion->query($sql);
            
            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                // Solo especificamos las columnas que vamos a llenar (sin id ni created_at)
                $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, Eliminado) 
                        VALUES ('{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, 
                                '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if($this->conexion->query($sql)){
                    $data['status'] =  "success";
                    $data['message'] =  "Producto agregado";
                } else {
                    $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
                }
            }

            $result->free();
            $this->conexion->close();
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>