<?php

// Ejercicio 1
function esMultiplo5y7($num) {
    if (!is_numeric($num)) return null;
    $num = intval($num);
    return ($num % 5 == 0) && ($num % 7 == 0);
}

// Ejercicio 2
function generarSecuencia($maxIter = 100000) {
    $filas = [];
    $iteraciones = 0;

    while (true) {
        // Generar 3 números aleatorios entre 1 y 999
        $a = rand(1, 999);
        $b = rand(1, 999);
        $c = rand(1, 999);

        $filas[] = [$a, $b, $c];
        $iteraciones++;

        // Revisar si cumplen impar - par - impar
        if ($a % 2 != 0 && $b % 2 == 0 && $c % 2 != 0) {
            break;
        }

        // Evitar ciclo infinito
        if ($iteraciones >= $maxIter) {
            break;
        }
    }

    return [
        'filas' => $filas,
        'iteraciones' => $iteraciones,
        'numerosGenerados' => $iteraciones * 3
    ];
}
