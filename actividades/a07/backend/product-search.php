<?php
namespace MyAPI;
require_once __DIR__.'/myapi/Products.php';

$products = new Products('marketzone');
$products->search($_GET['search']);
echo $products->getData();
?>