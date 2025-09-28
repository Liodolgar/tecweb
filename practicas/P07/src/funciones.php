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

//Ejercicio 5

function verificarEdadSexo($edad, $sexo) {
    if ($sexo === "femenino" && $edad >= 18 && $edad <= 35) {
        return "Bienvenida, usted está en el rango de edad permitido.";
    } else {
        return "Lo sentimos, no cumple con los requisitos.";
    }
}
?>

<?php
// Función que devuelve el registro vehicular
function obtenerVehiculos() {
    return [
        "ABC1234" => [
            "Auto" => ["marca" => "HONDA", "modelo" => 2020, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Alfonzo Esparza", "ciudad" => "Puebla, Pue.", "direccion" => "C.U., Jardines de San Manuel"]
        ],
        "DEF5678" => [
            "Auto" => ["marca" => "MAZDA", "modelo" => 2019, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Ma. del Consuelo Molina", "ciudad" => "Puebla, Pue.", "direccion" => "97 oriente"]
        ],
        "GHI9012" => [
            "Auto" => ["marca" => "TOYOTA", "modelo" => 2021, "tipo" => "hachback"],
            "Propietario" => ["nombre" => "José Ramírez", "ciudad" => "Oaxaca, Oax.", "direccion" => "Av. Juárez 123"]
        ],
        "JKL3456" => [
            "Auto" => ["marca" => "FORD", "modelo" => 2018, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Ana Pérez", "ciudad" => "Puebla, Pue.", "direccion" => "Calle 5 de Mayo 45"]
        ],
        "MNO7890" => [
            "Auto" => ["marca" => "NISSAN", "modelo" => 2020, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Luis Gómez", "ciudad" => "Tlaxcala, Tlax.", "direccion" => "Av. Reforma 12"]
        ],
        "PQR2345" => [
            "Auto" => ["marca" => "CHEVROLET", "modelo" => 2022, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "María López", "ciudad" => "Oaxaca, Oax.", "direccion" => "Calle Hidalgo 78"]
        ],
        "STU6789" => [
            "Auto" => ["marca" => "VOLKSWAGEN", "modelo" => 2019, "tipo" => "hachback"],
            "Propietario" => ["nombre" => "Pedro Martínez", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Juárez 200"]
        ],
        "VWX0123" => [
            "Auto" => ["marca" => "KIA", "modelo" => 2021, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Sofía Hernández", "ciudad" => "Oaxaca, Oax.", "direccion" => "Calle 20 de Noviembre 5"]
        ],
        "YZA4567" => [
            "Auto" => ["marca" => "HYUNDAI", "modelo" => 2020, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Carlos Torres", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Central 15"]
        ],
        "BCD8901" => [
            "Auto" => ["marca" => "SUZUKI", "modelo" => 2018, "tipo" => "hachback"],
            "Propietario" => ["nombre" => "Laura Sánchez", "ciudad" => "Oaxaca, Oax.", "direccion" => "Callejón del Ángel 10"]
        ],
        "EFG2345" => [
            "Auto" => ["marca" => "MITSUBISHI", "modelo" => 2021, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Rafael Díaz", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Reforma 90"]
        ],
        "HIJ6789" => [
            "Auto" => ["marca" => "BMW", "modelo" => 2022, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Isabel Ramírez", "ciudad" => "Oaxaca, Oax.", "direccion" => "Calle Morelos 33"]
        ],
        "KLM0123" => [
            "Auto" => ["marca" => "AUDI", "modelo" => 2020, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Fernando Castillo", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Reforma 150"]
        ],
        "NOP4567" => [
            "Auto" => ["marca" => "JEEP", "modelo" => 2019, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Verónica Ruiz", "ciudad" => "Oaxaca, Oax.", "direccion" => "Calle 5 de Mayo 60"]
        ],
        "QRS8901" => [
            "Auto" => ["marca" => "TESLA", "modelo" => 2022, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Diego Moreno", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Juárez 300"]
        ]
    ];
}

// Función para buscar un auto por matrícula
function buscarPorMatricula($matricula) {
    $parque = obtenervehiculos();
    if (isset($parque[$matricula])) {
        return $parque[$matricula];
    } else {
        return null;
    }
}
?>



