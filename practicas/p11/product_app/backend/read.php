<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();

    // SE VERIFICA HABER RECIBIDO EL PARÁMETRO DE BÚSQUEDA
    if (isset($_POST['id'])) {
        $busqueda = $conexion->real_escape_string($_POST['id']);

        /**
         * CONSULTA MODIFICADA:
         * Busca coincidencias parciales en nombre, marca o detalles.
         * La cláusula LIKE permite usar el comodín % para buscar subcadenas.
         */
        $query = "
            SELECT * FROM productos 
            WHERE eliminado = 0
            AND (
                nombre LIKE '%{$busqueda}%' 
                OR marca LIKE '%{$busqueda}%'
                OR detalles LIKE '%{$busqueda}%'
            )
        ";

        if ($result = $conexion->query($query)) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $producto = array();
                foreach ($row as $key => $value) {
                    $producto[$key] = utf8_encode($value);
                }
                $data[] = $producto;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }

        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
