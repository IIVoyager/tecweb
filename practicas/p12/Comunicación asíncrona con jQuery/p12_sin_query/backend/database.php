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
        die('¡Base de datos NO conextada!');
    }
?>