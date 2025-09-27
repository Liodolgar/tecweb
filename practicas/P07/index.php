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


    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>
</body>
</html>