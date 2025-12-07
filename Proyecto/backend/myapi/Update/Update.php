<?php

namespace TECWEB\MYAPI\Update;

use TECWEB\MYAPI\DataBase;

require_once __DIR__ . '/../DataBase.php';

class Update extends DataBase
{

    public function __construct($db, $user = 'root', $pass = '')
    {
        parent::__construct($db, $user, $pass);
    }

    public function edit($jsonOBJ)
    {
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        // SE VERIFICA HABER RECIBIDO EL ID
        if (isset($jsonOBJ->id)) {
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql =  "UPDATE digital_resources SET nombre='{$jsonOBJ->nombre}', autor='{$jsonOBJ->autor}',";
            $sql .= "departamento='{$jsonOBJ->departamento}', empresa_institucion={$jsonOBJ->empresa_institucion}, fecha_creacion='{$jsonOBJ->fecha_creacion}',";
            $sql .= "descripcion='{$jsonOBJ->descripcion}', archivo='{$jsonOBJ->archivo}', eliminado='{$jsonOBJ->eliminado}' WHERE id={$jsonOBJ->id}";
            $this->conexion->set_charset("utf8");
            if ($this->conexion->query($sql)) {
                $this->data['status'] =  "success";
                $this->data['message'] =  "Recurso actualizado";
            } else {
                $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
    }
}
?>
