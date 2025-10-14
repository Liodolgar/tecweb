<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar / Modificar Producto</title>
</head>
<body>
    <h2>Registro / Modificación de Productos</h2>

    <form id="formProducto" action="set_producto_v2.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" maxlength="100" required 
            value="<?= !empty($_POST['nombre']) ? $_POST['nombre'] : (!empty($_GET['nombre']) ? $_GET['nombre'] : '') ?>"><br><br>

        <label>Marca:</label><br>
        <select name="marca" id="marca" required>
            <?php
            $marcas = ['Sony', 'Samsung', 'Xiaomi', 'LG'];
            $marca_sel = !empty($_POST['marca']) ? $_POST['marca'] : (!empty($_GET['marca']) ? $_GET['marca'] : '');
            echo '<option value="">Seleccione una marca</option>';
            foreach ($marcas as $m) {
                $sel = ($m == $marca_sel) ? 'selected' : '';
                echo "<option value='$m' $sel>$m</option>";
            }
            ?>
        </select><br><br>

        <label>Modelo:</label><br>
        <input type="text" name="modelo" id="modelo" maxlength="25" required
            value="<?= !empty($_POST['modelo']) ? $_POST['modelo'] : (!empty($_GET['modelo']) ? $_GET['modelo'] : '') ?>"><br><br>

        <label>Precio:</label><br>
        <input type="number" name="precio" id="precio" step="0.01" required
            value="<?= !empty($_POST['precio']) ? $_POST['precio'] : (!empty($_GET['precio']) ? $_GET['precio'] : '') ?>"><br><br>

        <label>Detalles:</label><br>
        <textarea name="detalles" id="detalles" rows="3" cols="30" maxlength="250"><?= !empty($_POST['detalles']) ? $_POST['detalles'] : (!empty($_GET['detalles']) ? $_GET['detalles'] : '') ?></textarea><br><br>

        <label>Unidades:</label><br>
        <input type="number" name="unidades" id="unidades" min="0" required
            value="<?= !empty($_POST['unidades']) ? $_POST['unidades'] : (!empty($_GET['unidades']) ? $_GET['unidades'] : '') ?>"><br><br>

        <label>Ruta de imagen:</label><br>
        <input type="text" name="imagen" id="imagen" placeholder="img/imagen.png"
            value="<?= !empty($_POST['imagen']) ? $_POST['imagen'] : (!empty($_GET['imagen']) ? $_GET['imagen'] : '') ?>"><br><br>

        <input type="submit" value="Guardar producto">
    </form>
</body>
</html>
