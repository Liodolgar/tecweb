<?php

// Ejercicio 1
function esMultiplo5y7($num) {
    if (!is_numeric($num)) return null;
    $num = intval($num);
    return ($num % 5 == 0) && ($num % 7 == 0);
}