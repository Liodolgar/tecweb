<?php
    use TECWEB\MYAPI\Update\Update;
    require_once __DIR__ . '/../vendor/autoload.php';

    $producto = new Update('marketzone');
    echo $producto->edit(json_decode(json_encode($_POST)));
?>