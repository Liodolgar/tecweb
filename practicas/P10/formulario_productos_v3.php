<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h2>Editar Producto</h2>

    <?php
    // Recibe los datos del producto vía GET
    $id       = $_GET['id'] ?? '';
    $nombre   = $_GET['nombre'] ?? '';
    $marca    = $_GET['marca'] ?? '';
    $modelo   = $_GET['modelo'] ?? '';
    $precio   = $_GET['precio'] ?? '';
    $detalles = $_GET['detalles'] ?? '';
    $unidades = $_GET['unidades'] ?? '';
    $imagen   = $_GET['imagen'] ?? '';
    ?>

    <form id="formProducto" action="update_producto.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <label>Nombre:</label><br>
        <input type="text" name="nombre" maxlength="100" required 
            value="<?= htmlspecialchars($nombre) ?>"><br><br>

        <label>Marca:</label><br>
        <input type="text" name="marca" maxlength="50" required
            value="<?= htmlspecialchars($marca) ?>"><br><br>

        <label>Modelo:</label><br>
        <input type="text" name="modelo" maxlength="25" required
            value="<?= htmlspecialchars($modelo) ?>"><br><br>

        <label>Precio:</label><br>
        <input type="number" name="precio" step="0.01" required
            value="<?= htmlspecialchars($precio) ?>"><br><br>

        <label>Detalles:</label><br>
        <textarea name="detalles" rows="3" cols="30" maxlength="250"><?= htmlspecialchars($detalles) ?></textarea><br><br>

        <label>Unidades:</label><br>
        <input type="number" name="unidades" min="0" required
            value="<?= htmlspecialchars($unidades) ?>"><br><br>

        <label>Ruta de imagen:</label><br>
        <input type="text" name="imagen" placeholder="img/imagen.png"
            value="<?= htmlspecialchars($imagen) ?>"><br><br>

        <input type="submit" value="Actualizar Producto">
    </form>
</body>
</html>

