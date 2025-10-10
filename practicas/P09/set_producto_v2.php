<?php
// Configuración de conexión
$link = new mysqli('localhost', 'root', '', 'marketzone');
if ($link->connect_errno) {
    die('<h3>Error de conexión:</h3> ' . $link->connect_error);
}

// Recuperar los datos enviados desde el formulario
$nombre   = isset($_POST['nombre']) ? $link->real_escape_string($_POST['nombre']) : '';
$marca    = isset($_POST['marca']) ? $link->real_escape_string($_POST['marca']) : '';
$modelo   = isset($_POST['modelo']) ? $link->real_escape_string($_POST['modelo']) : '';
$precio   = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$detalles = isset($_POST['detalles']) ? $link->real_escape_string($_POST['detalles']) : '';
$unidades = isset($_POST['unidades']) ? intval($_POST['unidades']) : 0;
$imagen   = isset($_POST['imagen']) ? $link->real_escape_string($_POST['imagen']) : '';

// Verificar que los campos requeridos no estén vacíos
if ($nombre == '' || $marca == '' || $modelo == '') {
    die('<h3>Error:</h3> Debes llenar los campos Nombre, Marca y Modelo.');
}

// Validar que no exista ya un producto igual
$sql_check = "SELECT * FROM productos WHERE nombre = '$nombre' AND marca = '$marca' AND modelo = '$modelo'";
$result = $link->query($sql_check);

if ($result && $result->num_rows > 0) {
    echo '<h3>Error:</h3> Ya existe un producto con el mismo nombre, marca y modelo.';
    $link->close();
    exit;
}

// Insertar el nuevo producto
$sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen)
               VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";

if ($link->query($sql_insert)) {
    // Mostrar resumen de los datos insertados
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Producto Insertado</title>
    </head>
    <body>
        <h2>Producto insertado correctamente ✅</h2>
        <p><strong>ID:</strong> {$link->insert_id}</p>
        <p><strong>Nombre:</strong> {$nombre}</p>
        <p><strong>Marca:</strong> {$marca}</p>
        <p><strong>Modelo:</strong> {$modelo}</p>
        <p><strong>Precio:</strong> {$precio}</p>
        <p><strong>Detalles:</strong> {$detalles}</p>
        <p><strong>Unidades:</strong> {$unidades}</p>
        <p><strong>Imagen:</strong> {$imagen}</p>
        <br>
        <a href="formulario_productos.html">Volver al formulario</a>
    </body>
    </html>
HTML;
} else {
    echo '<h3>Error al insertar el producto:</h3> ' . $link->error;
}

$link->close();
?>
