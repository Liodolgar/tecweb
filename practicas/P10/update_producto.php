<?php
// Conexión a la base de datos
$link = mysqli_connect("localhost", "root", "", "marketzone");

// Chequea conexión
if($link === false){
    die("ERROR: No se pudo conectar con la DB. " . mysqli_connect_error());
}

// Verifica que se recibieron todos los campos necesarios
if(isset($_POST['id'], $_POST['nombre'], $_POST['marca'], $_POST['modelo'], $_POST['precio'], $_POST['unidades'], $_POST['detalles'], $_POST['imagen'])){
    
    // Limpieza básica (para evitar errores de sintaxis, no es inyección)
    $id = intval($_POST['id']);
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $marca = mysqli_real_escape_string($link, $_POST['marca']);
    $modelo = mysqli_real_escape_string($link, $_POST['modelo']);
    $precio = floatval($_POST['precio']);
    $unidades = intval($_POST['unidades']);
    $detalles = mysqli_real_escape_string($link, $_POST['detalles']);
    $imagen = mysqli_real_escape_string($link, $_POST['imagen']);

    // Construye la consulta UPDATE
    $sql = "UPDATE productos SET 
                nombre='$nombre',
                marca='$marca',
                modelo='$modelo',
                precio=$precio,
                unidades=$unidades,
                detalles='$detalles',
                imagen='$imagen'
            WHERE id=$id";

    if(mysqli_query($link, $sql)){
        echo "Producto actualizado correctamente.";
    } else {
        echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
    }

} else {
    echo "Faltan datos obligatorios para actualizar el producto.";
}

// Cierra la conexión
mysqli_close($link);
?>
