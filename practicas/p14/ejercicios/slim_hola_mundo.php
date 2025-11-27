<?php
require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get('/', function ($request, $response, $args) {
    $response->write("Hola, Mundo!");
    return $response;
});

$app->run();
?>