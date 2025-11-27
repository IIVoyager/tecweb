<?php
require 'vendor/autoload.php';

$app = new \Slim\App();

$app->post("/pruebapost", function($request, $response, $args) {
    $reqPost = $request->getParsedBody();
    $val1 = $reqPost['val1'];
    $val2 = $reqPost['val2'];

    $response->write("Valores: " . $val1 . " " . $val2); 
    
    return $response;
});

$app->run();
?>