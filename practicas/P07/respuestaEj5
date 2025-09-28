<?php
include __DIR__ . '/src/funciones.php';

$edad = isset($_POST['edad']) ? intval($_POST['edad']) : 0;
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';

$mensaje = verificarEdadSexo($edad, $sexo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Ejercicio 5</title>
</head>
<body>
    <h2>Resultado Ejercicio 5</h2>
    <p><?php echo $mensaje; ?></p>
    <a href="index.php">Regresar</a>
</body>
</html>
