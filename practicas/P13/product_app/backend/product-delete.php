<?php
    use TECWEB\MYAPI\Delete\Delete;
    require_once __DIR__ . '/../vendor/autoload.php';

    $producto = new Delete('marketzone');
    echo $producto->delete($_POST['id']);
?>