<?php
namespace TECWEB\MYAPI\Update;

use TECWEB\MYAPI\DataBase;

class Update extends DataBase {
    
    public function __construct($db, $user='root', $pass='') {
        parent::__construct($db, $user, $pass);
    }

    public function edit($jsonOBJ) {
        $data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        
        if( isset($jsonOBJ->id) ) {
            $sql =  "UPDATE productos SET nombre='{$jsonOBJ->nombre}', marca='{$jsonOBJ->marca}',";
            $sql .= "modelo='{$jsonOBJ->modelo}', precio={$jsonOBJ->precio}, detalles='{$jsonOBJ->detalles}',"; 
            $sql .= "unidades={$jsonOBJ->unidades}, imagen='{$jsonOBJ->imagen}' WHERE id={$jsonOBJ->id}";
            $this->conexion->set_charset("utf8");
            if ( $this->conexion->query($sql) ) {
                $data['status'] =  "success";
                $data['message'] =  "Producto actualizado";
            } else {
                $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>