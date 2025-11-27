<?php
    use TECWEB\MYAPI\Create\Create;
    require_once __DIR__ . '/../vendor/autoload.php';

    $producto = new Create('marketzone');
    echo $producto->add(json_decode(json_encode($_POST)));
?>