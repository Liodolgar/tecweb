<?php
namespace TECWEB\MYAPI\Read;

use TECWEB\MYAPI\DataBase;

class Read extends DataBase {
    
    public function __construct($db, $user='root', $pass='') {
        parent::__construct($db, $user, $pass);
    }

    public function list() {
        $data = array();
        
        if ( $result = $this->conexion->query("SELECT * FROM productos WHERE Eliminado = 0") ) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function search($search) {
        $data = array();
        
        if( isset($search) ) {
            $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND Eliminado = 0";
            if ( $result = $this->conexion->query($sql) ) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if(!is_null($rows)) {
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $data[$num][$key] = $value;
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function single($id) {
        $data = array();
        
        if( isset($id) ) {
            if ( $result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}") ) {
                $row = $result->fetch_assoc();
    
                if(!is_null($row)) {
                    foreach($row as $key => $value) {
                        $data[$key] = $value;
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>