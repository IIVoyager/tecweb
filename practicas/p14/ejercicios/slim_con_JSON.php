<?php
require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get("/testjson", function($request, $response, $args) {
    $data[0] ["nombre"] = "Leonardo";
    $data[0] ["apellido"] = "Avalos";
    $data[1] ["nombre"] = "Juan";
    $data[1] ["apellido"] = "Cielo";
    $data[2] ["nombre"] = "Berenice";
    $data[2] ["apellido"] = "Castellanos";
    $data[3] ["nombre"] = "Angel";
    $data[3] ["apellido"] = "Carrillo";

    $response->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response;
});
$app->run();
?>