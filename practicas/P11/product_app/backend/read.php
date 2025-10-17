<?php
include_once __DIR__.'/database.php';

$data = array();

if (isset($_GET['criterio'])) {
    $criterio = $conexion->real_escape_string($_GET['criterio']);

    if (is_numeric($criterio)) {
        $sql = "SELECT * FROM productos WHERE Eliminado=0 AND id=$criterio";
    } else {
        $sql = "SELECT * FROM productos
                WHERE Eliminado=0
                AND (nombre LIKE '%$criterio%' OR marca LIKE '%$criterio%' OR detalles LIKE '%$criterio%')";
    }

    if ($result = $conexion->query($sql)) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $producto = array();
            foreach ($row as $key => $value) {
                $producto[$key] = utf8_encode($value);
            }
            $data[] = $producto;
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }

    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>


