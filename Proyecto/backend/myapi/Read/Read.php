<?php

namespace TECWEB\MYAPI\Read;

use TECWEB\MYAPI\DataBase;

require_once __DIR__ . '/../DataBase.php';

class Read extends DataBase
{
    public function __construct($db, $user = 'root', $pass = '')
    {
        parent::__construct($db, $user, $pass);
    }

    public function list()
    {
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ($result = $this->conexion->query("SELECT * FROM digital_resources WHERE eliminado = 0")) {
            // SE OBTIENEN LOS RESULTADOS
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            if (!is_null($rows)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function search($search)
    {
        // SE VERIFICA HABER RECIBIDO EL ID
        if (isset($search)) {
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql = "SELECT * FROM digital_resources WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR autor LIKE '%{$search}%' OR departamento LIKE '%{$search}%') AND eliminado = 0";
            if ($result = $this->conexion->query($sql)) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if (!is_null($rows)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = $value;
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function single($id)
    {
        if (isset($id)) {
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            if ($result = $this->conexion->query("SELECT * FROM digital_resources WHERE id = {$id}")) {
                // SE OBTIENEN LOS RESULTADOS
                $row = $result->fetch_assoc();

                if (!is_null($row)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach ($row as $key => $value) {
                        $this->data[$key] = $value;
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function login_user($jsonOBJ)
    {
        $this->data = [
            'status' => 'error',
            'message' => 'Credenciales incorrectas'
        ];

        if (isset($jsonOBJ->username) && isset($jsonOBJ->password)) {

            $username = $this->conexion->real_escape_string($jsonOBJ->username);
            $password = $jsonOBJ->password;

            // Buscar usuario activo
            $sql = "SELECT * FROM users WHERE username = '$username' AND active = 1 LIMIT 1";
            $result = $this->conexion->query($sql);

            if ($result->num_rows == 1) {

                $user = $result->fetch_assoc();

                // Verificar contraseña (hash O texto plano)
                $passwordValida = false;
                
                // Primero intentar con password_verify (hash)
                if (password_verify($password, $user['password'])) {
                    $passwordValida = true;
                } 
                // Si falla, comparar en texto plano
                elseif ($password === $user['password']) {
                    $passwordValida = true;
                }

                if ($passwordValida) {
                    $this->data = [
                        'status' => 'success',
                        'message' => 'Login exitoso',
                        'user' => [
                            'id'       => $user['id'],
                            'username' => $user['username'],
                            'email'    => $user['email']
                        ]
                    ];
                }
            }

            $result->free();
            $this->conexion->close();
        }

        return $this->data;
    }
}
?>
