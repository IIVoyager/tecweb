<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    $jsonOBJ = json_decode($producto);

    if (!$jsonOBJ) {
        echo 'Error: El JSON recibido no es válido.';
        exit;
    }

    // SE OBTIENEN LOS DATOS DEL OBJETO
    $nombre   = mysqli_real_escape_string($conexion, $jsonOBJ->nombre);
    $marca    = mysqli_real_escape_string($conexion, $jsonOBJ->marca);
    $modelo   = mysqli_real_escape_string($conexion, $jsonOBJ->modelo);
    $precio   = floatval($jsonOBJ->precio);
    $detalles = mysqli_real_escape_string($conexion, $jsonOBJ->detalles ?? '');
    $unidades = intval($jsonOBJ->unidades);
    $imagen   = mysqli_real_escape_string($conexion, $jsonOBJ->imagen ?? 'img/default.jpg');

    // VALIDAR SI YA EXISTE UN PRODUCTO CON ESE NOMBRE Y eliminado = 0
    $queryCheck = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0 LIMIT 1";
    $result = $conexion->query($queryCheck);

    if ($result && $result->num_rows > 0) {
        echo "El producto '$nombre' ya existe en la base de datos.";
    } else {
        // INSERTAR EL NUEVO PRODUCTO
        $queryInsert = "
            INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado)
            VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)
        ";

        if ($conexion->query($queryInsert)) {
            echo "Producto '$nombre' agregado correctamente.";
        } else {
            echo "Error al insertar el producto: " . mysqli_error($conexion);
        }
    }

    if ($result) $result->free();
    $conexion->close();
} else {
    echo 'No se recibió ningún dato del cliente.';
}
?>