<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "dap048ac";
$dbname = "marketzone";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para limpiar y validar datos
function limpiarDatos($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Inicializar variables
$nombre = $marca = $modelo = $precio = $detalles = $unidades = $imagen = "";
$errores = array();

// Procesar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y limpiar datos
    $nombre = limpiarDatos($_POST["nombre"]);
    $marca = limpiarDatos($_POST["marca"]);
    $modelo = limpiarDatos($_POST["modelo"]);
    $precio = limpiarDatos($_POST["precio"]);
    $detalles = limpiarDatos($_POST["detalles"]);
    $unidades = limpiarDatos($_POST["unidades"]);
    
    // Validar que los campos obligatorios no estén vacíos
    if (empty($nombre)) {
        $errores[] = "El nombre del producto es obligatorio.";
    }
    
    if (empty($marca)) {
        $errores[] = "La marca es obligatoria.";
    }
    
    if (empty($modelo)) {
        $errores[] = "El modelo es obligatorio.";
    }
    
    if (empty($precio) || !is_numeric($precio) || $precio <= 0) {
        $errores[] = "El precio debe ser un número mayor a 0.";
    }
    
    if (empty($unidades) || !is_numeric($unidades) || $unidades < 0) {
        $errores[] = "Las unidades deben ser un número positivo.";
    }
    
    // Procesar imagen
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $allowed_types = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $file_name = $_FILES["imagen"]["name"];
        $file_type = $_FILES["imagen"]["type"];
        $file_size = $_FILES["imagen"]["size"];
        
        // Verificar extensión del archivo
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed_types)) {
            $errores[] = "Error: Por favor selecciona un formato de imagen válido (JPG, JPEG, PNG).";
        }
        
        // Verificar tamaño del archivo (5MB máximo)
        $maxsize = 5 * 1024 * 1024;
        if ($file_size > $maxsize) {
            $errores[] = "Error: El tamaño de la imagen es mayor al límite permitido (5MB).";
        }
        
        // Verificar tipo MIME
        if (in_array($file_type, $allowed_types)) {
            // Generar nombre único para la imagen
            $imagen = uniqid() . "." . $ext;
            $target_dir = "img/";
            
            // Crear directorio si no existe
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $target_file = $target_dir . $imagen;
            
            // Mover archivo subido
            if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $errores[] = "Error al subir la imagen.";
            }
        } else {
            $errores[] = "Error: Hubo un problema al subir la imagen. Por favor intenta de nuevo.";
        }
    }
    
    // Si no hay errores, verificar duplicados en la base de datos
    if (empty($errores)) {
        // Verificar si ya existe un producto NO ELIMINADO con el mismo nombre, marca y modelo
        $sql = "SELECT id FROM productos WHERE nombre = ? AND marca = ? AND modelo = ? AND eliminado = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $marca, $modelo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errores[] = "Error: Ya existe un producto con el mismo nombre, marca y modelo en la base de datos.";
        }
        $stmt->close();
    }
    
    // Si no hay errores, insertar en la base de datos
    if (empty($errores)) {
        /* ---- QUERY ORIGINAL COMENTADA ----
        // Establecer valor por defecto para eliminado (0 = no eliminado)
        $eliminado = 0;

        // Query de inserción actualizada con el campo "eliminado"
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssddisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $eliminado);
        
        if ($stmt->execute()) {
            $id_insertado = $stmt->insert_id;
            $mensaje_exito = "Producto registrado exitosamente.";
        } else {
            $errores[] = "Error al insertar el producto: " . $stmt->error;
        }
        $stmt->close();
        */

        // QUERY USANDO COLUMN NAMES
        // La columna 'id' se auto-incrementa automáticamente
        // La columna 'eliminado' toma el valor por defecto (0) definido en la tabla
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssddis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
        
        if ($stmt->execute()) {
            $id_insertado = $stmt->insert_id;
            $mensaje_exito = "Producto registrado exitosamente.";
        } else {
            $errores[] = "Error al insertar el producto: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Generar documento XHTML
header('Content-Type: application/xhtml+xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
    <title>Resultado del Registro de Producto</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .success {
            color: #4CAF50;
            background-color: #f0f9f0;
            border: 1px solid #4CAF50;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error {
            color: #f44336;
            background-color: #fdeaea;
            border: 1px solid #f44336;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .product-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .product-info p {
            margin: 8px 0;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .status {
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado del Registro de Producto</h1>
        
        <?php if (!empty($errores)): ?>
            <div class="error">
                <h2>Errores encontrados:</h2>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif (isset($mensaje_exito)): ?>
            <div class="success">
                <h2><?php echo $mensaje_exito; ?></h2>
            </div>
            
            <div class="product-info">
                <h3>Resumen del Producto Registrado:</h3>
                <p><strong>ID:</strong> <?php echo $id_insertado; ?></p>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                <p><strong>Marca:</strong> <?php echo htmlspecialchars($marca); ?></p>
                <p><strong>Modelo:</strong> <?php echo htmlspecialchars($modelo); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($precio, 2); ?></p>
                <p><strong>Detalles:</strong> <?php echo !empty($detalles) ? htmlspecialchars($detalles) : 'No especificado'; ?></p>
                <p><strong>Unidades:</strong> <?php echo $unidades; ?></p>
                <p><strong>Imagen:</strong> <?php echo !empty($imagen) ? htmlspecialchars($imagen) : 'No se subió imagen'; ?></p>
                <p><strong>Estado:</strong> <span class="status">Disponible (No eliminado)</span></p>
            </div>
        <?php endif; ?>
        
        <a href="../formulario_productos.html" class="back-link">Regresar al formulario</a>
    </div>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>