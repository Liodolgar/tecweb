<?php

namespace TECWEB\MYAPI\Create;

use TECWEB\MYAPI\DataBase;

require_once __DIR__ . '/../DataBase.php';

class Create extends DataBase
{

    public function __construct($db, $user = 'root', $pass = '')
    {
        parent::__construct($db, $user, $pass);
    }

    public function add($jsonOBJ)
    {
        // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );
        if (isset($jsonOBJ->nombre)) {
            // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
            $sql = "SELECT * FROM digital_resources WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);

            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO digital_resources VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->autor}', '{$jsonOBJ->departamento}', {$jsonOBJ->empresa_institucion}, '{$jsonOBJ->fecha_creacion}', {$jsonOBJ->descripcion}, '{$jsonOBJ->archivo}', 0)";
                if ($this->conexion->query($sql)) {
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Recurso agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
            }

            $result->free();
            // Cierra la conexion
            $this->conexion->close();
        }
    }

    public function register_user($jsonOBJ)
    {
        $this->data = array(
            'status'  => 'error',
            'message' => 'El usuario o correo ya está registrado'
        );

        if (isset($jsonOBJ->username) && isset($jsonOBJ->email) && isset($jsonOBJ->password)) {

            $username = $this->conexion->real_escape_string($jsonOBJ->username);
            $email    = $this->conexion->real_escape_string($jsonOBJ->email);
            $password_hash = password_hash($jsonOBJ->password, PASSWORD_DEFAULT);

            // Validar si existe username o email
            $sql = "SELECT * FROM users 
                WHERE username = '$username' OR email = '$email'";

            $result = $this->conexion->query($sql);

            if ($result->num_rows == 0) {

                $sql = "INSERT INTO users (username, email, password, active) 
                    VALUES ('$username', '$email', '$password_hash', 1)";

                if ($this->conexion->query($sql)) {
                    $this->data['status'] = "success";
                    $this->data['message'] = "Usuario registrado correctamente";
                } else {
                    $this->data['message'] = "ERROR SQL: " . $this->conexion->error;
                }
            }

            $result->free();
            $this->conexion->close();
        }
    }

}
