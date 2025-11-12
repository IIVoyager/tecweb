<?php
namespace MyAPI;
require_once __DIR__.'/myapi/Products.php';

$products = new Products('marketzone');
$products->edit(json_decode(file_get_contents('php://input')));
echo $products->getData();
?>