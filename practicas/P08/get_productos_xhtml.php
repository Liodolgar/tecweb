<?php
// get_productos_xhtml.php
require_once 'db_connect.php';

// Límite de unidades desde la URL (ej: ?tope=10)
$tope = isset($_GET['tope']) ? (int) $_GET['tope'] : 0;

$stmt = $mysqli->prepare('SELECT id, nombre, marca, modelo, precio, detalles, unidades, imagen 
                          FROM productos 
                          WHERE unidades <= ? 
                          ORDER BY id');
$stmt->bind_param('i', $tope);
$stmt->execute();
$result = $stmt->get_result();

// Cabecera XHTML
header('Content-Type: application/xhtml+xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
  <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
  <title>Productos con ≤ <?php echo $tope; ?> unidades</title>
</head>
<body>
  <h1>Productos con ≤ <?php echo $tope; ?> unidades</h1>
  <?php if ($result->num_rows === 0): ?>
    <p>No hay productos que cumplan la condición.</p>
  <?php else: ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div>
        <h2><?php echo htmlspecialchars($row['nombre']); ?> (<?php echo htmlspecialchars($row['marca']); ?> - <?php echo htmlspecialchars($row['modelo']); ?>)</h2>
        <p><?php echo htmlspecialchars($row['detalles']); ?></p>
        <p>Precio: $<?php echo number_format($row['precio'], 2); ?></p>
        <p>Unidades: <?php echo (int)$row['unidades']; ?></p>
        <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($row['nombre']); ?>" width="200"/>
      </div>
      <hr/>
    <?php endwhile; ?>
  <?php endif; ?>
</body>
</html>
<?php
$stmt->close();
$mysqli->close();
?>