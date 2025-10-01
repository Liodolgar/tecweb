<!DOCTYPE html>
<html lang="es">
<?php
$row = null;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // fuerza a entero

    // Crear objeto de conexión
    @$link = new mysqli('localhost', 'root', '', 'marketzone');
    $link->set_charset("utf8");

    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error . '<br/>');
    }

    // Consulta segura con prepared statement
    $stmt = $link->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    $stmt->close();
    $link->close();
}
?>
<head>
    <meta charset="UTF-8">
    <title>Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body class="p-3">
    <h3>PRODUCTO</h3>
    <br/>

    <?php if ($row): ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Detalles</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?= $row['id'] ?></th>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                    <td><?= (int) $row['unidades'] ?></td>
                    <td><?= htmlspecialchars($row['detalles']) ?></td>
                    <td><img src="<?= htmlspecialchars($row['imagen']) ?>" width="150" alt="Imagen del producto"></td>
                </tr>
            </tbody>
        </table>
    <?php elseif (!empty($id)): ?>
        <script>alert('El ID del producto no existe');</script>
    <?php endif; ?>
</body>
</html>
