<?php
include __DIR__ . '/src/funciones.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
     <!-- Formulario GET -->
    <form method="get" action="">
        Número: <input type="number" name="numero" required>
        <input type="submit" value="Comprobar">
    </form>

    <?php
    // Si se envió el número por GET
    if (isset($_GET['numero'])) {
        $num = $_GET['numero'];

        if (esMultiplo5y7($num)) {
            echo '<h3>R= El número ' . htmlspecialchars($num) . ' SÍ es múltiplo de 5 y 7.</h3>';
        } else {
            echo '<h3>R= El número ' . htmlspecialchars($num) . ' NO es múltiplo de 5 y 7.</h3>';
        }
    }
    ?>

    <hr>
    <h2>Ejercicio 2</h2>
 <p>Generar números aleatorios hasta obtener la secuencia: <strong>impar - par - impar</strong></p>

 <form method="post" action="">
    <input type="hidden" name="ejercicio" value="2">
    <input type="submit" value="Generar secuencia">
 </form>

 <?php
 if (isset($_POST['ejercicio']) && $_POST['ejercicio'] == "2") {
    $resultado = generarSecuencia();

    echo "<p><strong>Iteraciones:</strong> {$resultado['iteraciones']}</p>";
    echo "<p><strong>Total de números generados:</strong> {$resultado['numerosGenerados']}</p>";

    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>#</th><th>N1</th><th>N2</th><th>N3</th></tr>";
    foreach ($resultado['filas'] as $i => $fila) {
        echo "<tr>";
        echo "<td>" . ($i+1) . "</td>";
        echo "<td>{$fila[0]}</td>";
        echo "<td>{$fila[1]}</td>";
        echo "<td>{$fila[2]}</td>";
        echo "</tr>";
    }
    echo "</table>";
}


?>
<hr>
<h2>Ejercicio 3</h2>
<p>Encontrar el primer número aleatorio que sea múltiplo de un divisor dado (GET).</p>

<form method="get" action="">
    Divisor: <input type="number" name="divisor" required>
    <select name="modo">
        <option value="while">while</option>
        <option value="dowhile">do...while</option>
    </select>
    <input type="submit" value="Buscar">
</form>

<?php
if (isset($_GET['divisor']) && isset($_GET['modo'])) {
    $div = $_GET['divisor'];
    $modo = $_GET['modo'];

    if ($modo === 'while') {
        $resultado = encontrarMultiploWhile($div);
    } else {
        $resultado = encontrarMultiploDoWhile($div);
    }

    if ($resultado === null) {
        echo "<p>El divisor no es válido.</p>";
    } else {
        echo "<p><strong>Divisor:</strong> " . htmlspecialchars($div) . "</p>";
        echo "<p><strong>Número encontrado:</strong> " . htmlspecialchars($resultado) . "</p>";
    }
}
?>
    <hr>
    <h2>Ejercicio 4</h2>
<p>Generar un arreglo asociativo con índices del 97 al 122 y valores de 'a' a 'z'.</p>

<form method="post" action="">
    <input type="hidden" name="ejercicio" value="4">
    <input type="submit" value="Mostrar arreglo">
</form>

<?php
if (isset($_POST['ejercicio']) && $_POST['ejercicio'] == "4") {
    $asciiArr = generarArreglo();

    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Índice (ASCII)</th><th>Letra</th></tr>";
    foreach ($asciiArr as $codigo => $letra) {
        echo "<tr><td>$codigo</td><td>$letra</td></tr>";
    }
    echo "</table>";
}
?>

    <hr>
<h2>Ejercicio 5</h2>
<p>Ingrese su edad y sexo para validar el rango permitido:</p>

<form method="post" action="">
    Edad: <input type="number" name="edad" required><br><br>
    Sexo: 
    <select name="sexo" required>
        <option value="">Seleccione...</option>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
    </select><br><br>
    <input type="hidden" name="ejercicio" value="5">
    <input type="submit" value="Validar">
</form>

<?php
if (isset($_POST['ejercicio']) && $_POST['ejercicio'] == "5") {
    $edad = isset($_POST['edad']) ? intval($_POST['edad']) : 0;
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';
    $mensaje = verificarEdadSexo($edad, $sexo);
    echo "<h3>$mensaje</h3>";
}
?>
</body>
</html>