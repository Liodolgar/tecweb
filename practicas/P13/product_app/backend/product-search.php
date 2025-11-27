<?php
    use TECWEB\MYAPI\Read\Read;
    require_once __DIR__ . '/../vendor/autoload.php';

    $producto = new Read('marketzone');
    echo $producto->search($_GET['search']);
?>