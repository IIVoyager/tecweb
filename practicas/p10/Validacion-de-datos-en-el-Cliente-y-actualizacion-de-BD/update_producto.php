<?php
/** 
 * Script: update_producto.php
 * Descripción: Actualiza un producto existente en la base de datos
 */

// Configuración de conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = 'dap048ac';
$database = 'marketzone';

// Crear conexión
$link = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error);
}

// Inicializar variables
$mensaje = '';
$success = false;

// Verificar si se recibieron datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recoger y sanitizar datos del formulario
    $id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $nombre = isset($_POST['nombre']) ? $link->real_escape_string(trim($_POST['nombre'])) : '';
    $marca = isset($_POST['marca']) ? $link->real_escape_string(trim($_POST['marca'])) : '';
    $modelo = isset($_POST['modelo']) ? $link->real_escape_string(trim($_POST['modelo'])) : '';
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
    $detalles = isset($_POST['detalles']) ? $link->real_escape_string(trim($_POST['detalles'])) : '';
    $unidades = isset($_POST['unidades']) ? intval($_POST['unidades']) : 0;
    
    // Validaciones básicas
    if ($id <= 0) {
        $mensaje = 'Error: ID de producto inválido';
    } elseif (empty($nombre) || empty($marca) || empty($modelo)) {
        $mensaje = 'Error: Campos obligatorios vacíos';
    } elseif ($precio <= 99.99) {
        $mensaje = 'Error: El precio debe ser mayor a 99.99';
    } elseif ($unidades < 0) {
        $mensaje = 'Error: Las unidades no pueden ser negativas';
    } else {
        
        // Procesar imagen
        $ruta_imagen = '';
        
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Hay una nueva imagen para subir
            $imagen_temporal = $_FILES['imagen']['tmp_name'];
            $nombre_imagen = $_FILES['imagen']['name'];
            $directorio_destino = 'img/';
            
            // Crear directorio si no existe
            if (!is_dir($directorio_destino)) {
                mkdir($directorio_destino, 0755, true);
            }
            
            // Validar tipo de archivo
            $tipo_imagen = $_FILES['imagen']['type'];
            $tipos_permitidos = ['image/jpeg', 'image/png'];
            
            if (in_array($tipo_imagen, $tipos_permitidos)) {
                // Mover archivo al directorio destino
                $ruta_imagen = $directorio_destino . $nombre_imagen;
                if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
                    $ruta_imagen = $link->real_escape_string($ruta_imagen);
                } else {
                    $mensaje = 'Error: No se pudo guardar la imagen';
                }
            } else {
                $mensaje = 'Error: Tipo de imagen no permitido';
            }
        }
        
        // Si no hay errores con la imagen, proceder con la actualización
        if (empty($mensaje)) {
            // Construir consulta UPDATE
            if (!empty($ruta_imagen)) {
                // Actualizar incluyendo la nueva imagen
                $sql = "UPDATE productos SET 
                        nombre = '$nombre', 
                        marca = '$marca', 
                        modelo = '$modelo', 
                        precio = $precio, 
                        detalles = '$detalles', 
                        unidades = $unidades, 
                        imagen = '$ruta_imagen' 
                        WHERE id = $id";
            } else {
                // Actualizar sin cambiar la imagen
                $sql = "UPDATE productos SET 
                        nombre = '$nombre', 
                        marca = '$marca', 
                        modelo = '$modelo', 
                        precio = $precio, 
                        detalles = '$detalles', 
                        unidades = $unidades 
                        WHERE id = $id";
            }
            
            // Ejecutar consulta
            if ($link->query($sql)) {
                if ($link->affected_rows > 0) {
                    $mensaje = 'Producto actualizado correctamente';
                    $success = true;
                } else {
                    $mensaje = 'No se realizaron cambios en el producto';
                    $success = true;
                }
            } else {
                $mensaje = 'Error al actualizar el producto: ' . $link->error;
            }
        }
    }
} else {
    $mensaje = 'Error: Método de solicitud no válido';
}

// Cerrar conexión
$link->close();

// Redirigir de vuelta al formulario con mensaje
$parametros = [];
if ($success) {
    $parametros['success'] = '1';
} else {
    $parametros['error'] = urlencode($mensaje);
}

// Si tenemos el ID del producto, lo pasamos para que pueda recargarse
if ($id > 0) {
    $parametros['producto_id'] = $id;
}

$query_string = http_build_query($parametros);
header("Location: formulario_productos_v2.html?$query_string");
exit();
?>