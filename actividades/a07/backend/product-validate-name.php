<?php
namespace MyAPI;
require_once __DIR__.'/myapi/Products.php';

$products = new Products('marketzone');
$products->singleByName($_GET['nombre']);
echo json_encode(['existe' => !empty($products->getProductsData())]);
?>