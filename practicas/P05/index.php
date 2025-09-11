<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';

        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>
<hr>

    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <?php
        $a = "ManejadorSQL";
        $b = "MySQL";
        $c = &$a;
        
        echo "<h3>Primer bloque de asignaciones</h3>";
echo "\$a = $a <br>";
echo "\$b = $b <br>";
echo "\$c = $c <br>";
?>

<?php
$a = "PHP server";
$b = &$a; // ahora b también referencia a a

echo "<h3>Segundo bloque de asignaciones</h3>";
echo "\$a = $a <br>";
echo "\$b = $b <br>";
echo "\$c = $c <br>";
?>
<?php
echo "<h3>Explicación</h3>";
echo "<p>En el primer bloque, \$c estaba referenciado a \$a, así que ambos mostraban el mismo valor inicial ManejadorSQL.<br>
En el segundo bloque, cuando le asignamos a \$a con 'PHP server' y se hizo que \$b también fuera referencia a \$a,<br>
entonces las tres variables apuntan al mismo valor.
Por eso al mostrar el contenido, \$a, \$b y \$c imprimen lo mismo.</p>";
?>

<hr>

<h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
verificar la evolución<br> del tipo de estas variables (imprime todos los componentes de los
arreglo):</p>
    <?php
    $a = "PHP5";
    echo @"<h3>a incial:  $a</h3>";
    $z[] = &$a;
    echo @"<h3>z inicial: $z</h3>";
    $b = "5a version de PHP";
    echo @"<h3>b inical: $b</h3>";
    $c = @($b*10);
    echo @"<h3>c inicial: $c</h3>";
    $a .= $b;
    echo @"<h3>a haciendo referencia a b: $a</h3>";
    $b *= $c;
    echo @"<h3>b haciendo referencia a c: $b</h3>";
    $z[0] = "MySQL";
    echo @"<h3>z con [0] en la cadena: $z</h3>";
    ?>

<hr>

<h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
la matriz $GLOBALS o del modificador global de PHP.:</p>
<?php
echo "a = " . $GLOBALS['a'] . "<br>";
echo "b = " . $GLOBALS['b'] . "<br>";
echo "c = " . $GLOBALS['c'] . "<br>";
echo "z = ";
print_r($GLOBALS['z']);
echo "<br>";
?>

</body>
</html>