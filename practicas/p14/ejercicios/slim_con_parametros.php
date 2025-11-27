<?php
require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get('/hola[/{nombre}]', function ($request, $response, $args) {
    $response->write("Hola, " . ($args['nombre']));
    return $response;
});

$app->run();
?>