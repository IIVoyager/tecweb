<?php
namespace MyAPI;
require_once __DIR__.'/myapi/Products.php';

$products = new Products('marketzone');
$products->delete($_GET['id']);
echo $products->getData();
?>