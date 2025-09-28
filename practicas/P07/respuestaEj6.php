<?php
include __DIR__ . '/src/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Ejercicio 6</title>
</head>
<body>
    <h2>Resultado Ejercicio 6</h2>

<?php
if (isset($_POST['matricula'])) {
    $matricula = strtoupper(trim($_POST['matricula']));
    $resultado = buscarPorMatricula($matricula);
    if ($resultado) {
        echo "<h3>Resultado para matrícula $matricula:</h3>";
        echo "<pre>";
        print_r($resultado);
        echo "</pre>";
    } else {
        echo "<p>No se encontró un auto con la matrícula $matricula.</p>";
    }
} elseif (isset($_POST['accion']) && $_POST['accion'] == "mostrar_todos") {
    $parque = obtenerParqueVehicular();
    echo "<h3>Todos los autos registrados:</h3>";
    echo "<pre>";
    print_r($parque);
    echo "</pre>";
}
?>
    <br>
    <a href="index.php">Regresar</a>
</body>
</html>
