<?php
namespace TECWEB\MYAPI\Delete;

use TECWEB\MYAPI\DataBase;

class Delete extends DataBase {
    
    public function __construct($db, $user='root', $pass='') {
        parent::__construct($db, $user, $pass);
    }

    public function delete($id) {
        $data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        
        if( isset($id) ) {
            $sql = "UPDATE productos SET Eliminado=1 WHERE id = {$id}";
            if ( $this->conexion->query($sql) ) {
                $data['status'] =  "success";
                $data['message'] =  "Producto eliminado";
            } else {
                $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>