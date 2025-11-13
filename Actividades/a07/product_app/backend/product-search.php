<?php
use MARKETZONE\MAIN\Products as Product;
require_once __DIR__ . '/myapi/Products.php';

$product = new Product('marketzone');
$product->search($_GET['search'] ?? '');
echo $product->getResponse();
?>
