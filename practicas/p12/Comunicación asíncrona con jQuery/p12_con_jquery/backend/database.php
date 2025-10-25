<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        'dap048ac',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        // Para mejor manejo de errores en AJAX
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => 'error',
            'message' => '¡Base de datos NO conectada!'
        ));
        exit();
    }
?>