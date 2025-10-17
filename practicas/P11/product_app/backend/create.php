<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    $jsonOBJ = json_decode($producto);

    if (!$jsonOBJ) {
        echo json_encode(['status' => 'error', 'message' => 'JSON inválido']);
        exit;
    }

    // Extraer y sanitizar campos
    $nombre  = $conexion->real_escape_string($jsonOBJ->nombre);
    $marca   = $conexion->real_escape_string($jsonOBJ->marca);
    $modelo  = $conexion->real_escape_string($jsonOBJ->modelo);
    $precio  = floatval($jsonOBJ->precio);
    $detalles= $conexion->real_escape_string($jsonOBJ->detalles);
    $unidades= intval($jsonOBJ->unidades);
    $imagen  = isset($jsonOBJ->imagen) ? $conexion->real_escape_string($jsonOBJ->imagen) : "";

    // Validar si ya existe producto con mismo nombre y Eliminado=0
    $sql_check = "SELECT id FROM productos WHERE nombre='$nombre' AND Eliminado=0";
    $result = $conexion->query($sql_check);

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El producto ya existe']);
    } else {
        // Insertar producto
        $sql_insert = "INSERT INTO productos 
            (nombre, marca, modelo, precio, detalles, unidades, imagen, Eliminado, created_at)
            VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0, NOW())";

        if ($conexion->query($sql_insert)) {
            echo json_encode(['status' => 'ok', 'message' => 'Producto insertado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al insertar: '.$conexion->error]);
        }
    }

    $conexion->close();
}
?>
