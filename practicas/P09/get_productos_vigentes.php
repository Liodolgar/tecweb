<?php
// Configuración de conexión
$link = new mysqli('localhost', 'root', '', 'marketzone');
if ($link->connect_errno) {
    die('Error de conexión: ' . $link->connect_error);
}

// Consulta para obtener solo productos no eliminados
$sql = "SELECT * FROM productos WHERE eliminado = 0";
$result = $link->query($sql);

if (!$result) {
    die('Error en la consulta: ' . $link->error);
}

// Crear el documento XHTML
header('Content-Type: application/xhtml+xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
    <title>Productos Vigentes</title>
</head>
<body>
    <h1>Lista de Productos Vigentes</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Detalles</th>
                <th>Unidades</th>
                <th>Imagen</th>
                <th>Eliminado</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['marca']) ?></td>
                <td><?= htmlspecialchars($row['modelo']) ?></td>
                <td>$<?= number_format($row['precio'], 2) ?></td>
                <td><?= htmlspecialchars($row['detalles']) ?></td>
                <td><?= htmlspecialchars($row['unidades']) ?></td>
                <td><?= htmlspecialchars($row['imagen']) ?></td>
                <td><?= isset($row['eliminado']) ? htmlspecialchars($row['eliminado']) : '0' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <p>Total de productos vigentes: <?= $result->num_rows ?></p>
    <?php else: ?>
        <p>No hay productos vigentes en el sistema.</p>
    <?php endif; ?>
    
    <br />
    <a href="formulario_productos.html">Registrar nuevo producto</a>
</body>
</html>

<?php
$link->close();
?>