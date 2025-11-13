<?php
use MARKETZONE\MAIN\Products as Product;
require_once __DIR__ . '/myapi/Products.php';

$product = new Product('marketzone');
$product->delete($_POST['id'] ?? 0);
echo $product->getResponse();
?>
