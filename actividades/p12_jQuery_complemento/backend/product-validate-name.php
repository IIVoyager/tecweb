<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array('existe' => false);

    // SE VERIFICA HABER RECIBIDO EL NOMBRE
    if( isset($_GET['nombre']) ) {
        $nombre = $_GET['nombre'];
        $excluir = isset($_GET['excluir']) ? $_GET['excluir'] : '';
        
        // SE REALIZA LA QUERY DE BÚSQUEDA
        if ($excluir) {
            $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND id != {$excluir} AND eliminado = 0";
        } else {
            $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        }
        
        if ( $result = $conexion->query($sql) ) {
            $data['existe'] = $result->num_rows > 0;
            $result->free();
        }
    }

    $conexion->close();
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data);
?>