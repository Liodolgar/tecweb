<?php
require_once "Database.php";

class Producto {
    private $conexion;

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->conexion;
    }

    // 🔹 Obtener todos los productos
    public function obtenerTodos() {
        $sql = "SELECT * FROM productos WHERE Eliminado = 0";
        $result = $this->conexion->query($sql);

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        return $productos;
    }

    // 🔹 Buscar por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = $id AND Eliminado = 0";
        $result = $this->conexion->query($sql);
        return $result->fetch_assoc();
    }

    // 🔹 Agregar un nuevo producto
    public function agregar($data) {
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, Eliminado)
                VALUES ('{$data['nombre']}', '{$data['marca']}', '{$data['modelo']}', {$data['precio']},
                        '{$data['detalles']}', {$data['unidades']}, '{$data['imagen']}', 0)";
        return $this->conexion->query($sql);
    }

    // 🔹 Actualizar producto
    public function actualizar($id, $data) {
        $sql = "UPDATE productos SET 
                nombre = '{$data['nombre']}',
                marca = '{$data['marca']}',
                modelo = '{$data['modelo']}',
                precio = {$data['precio']},
                detalles = '{$data['detalles']}',
                unidades = {$data['unidades']},
                imagen = '{$data['imagen']}'
                WHERE id = $id";
        return $this->conexion->query($sql);
    }

    // 🔹 Borrado lógico
    public function eliminar($id) {
        $sql = "UPDATE productos SET Eliminado = 1 WHERE id = $id";
        return $this->conexion->query($sql);
    }
}
?>