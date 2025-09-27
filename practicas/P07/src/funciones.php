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

// Ejercicio 3 - con while
function encontrarMultiploWhile($divisor) {
    $divisor = intval($divisor);
    if ($divisor <= 0) {
        return null; // divisor inválido
    }

    $encontrado = null;
    while ($encontrado === null) {
        $n = rand(1, 1000000);
        if ($n % $divisor == 0) {
            $encontrado = $n;
        }
    }
    return $encontrado;
}

function encontrarMultiploDoWhile($divisor) {
    $divisor = intval($divisor);
    if ($divisor <= 0) {
        return null;
    }

    do {
        $n = rand(1, 1000000);
    } while ($n % $divisor != 0);

    return $n;
}

// Ejercicio 4
function generarArreglo() {
    $arr = [];
    for ($i = 97; $i <= 122; $i++) {
        $arr[$i] = chr($i); // chr convierte código ASCII en carácter
    }
    return $arr;
}

