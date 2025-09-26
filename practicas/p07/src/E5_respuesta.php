<?php
// Incluir el archivo de funciones
include 'funciones.php';

// Obtener datos del formulario via POST
$edad = isset($_POST['edad']) ? $_POST['edad'] : '';
$sexo = isset($_POST['sexo']) ? $_POST['sexo'] : '';

// Validar los datos
$resultado = validarEdadSexo($edad, $sexo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultado - Validación de Edad y Sexo</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .resultado {
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 18px;
        }
        .exito {
            background-color: #d4edda;
            border: 2px solid #c3e6cb;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
        }
        .datos {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .botones {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-volver {
            background-color: #6c757d;
            color: white;
        }
        .btn-nuevo {
            background-color: #28a745;
            color: white;
        }
        .btn-principal {
            background-color: #007bff;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado de Validación</h1>
        
        <div class="datos">
            <h3>Datos ingresados:</h3>
            <p><strong>Edad:</strong> <?php echo htmlspecialchars($edad); ?> años</p>
            <p><strong>Sexo:</strong> <?php echo htmlspecialchars(ucfirst($sexo)); ?></p>
        </div>
        
        <div class="resultado <?php echo $resultado['valido'] ? 'exito' : 'error'; ?>">
            <h3><?php echo $resultado['valido'] ? '✓ Validación Exitosa' : '✗ Validación Fallida'; ?></h3>
            <p><?php echo $resultado['mensaje']; ?></p>
        </div>
        
        <div class="botones">
            <a href="E5_formulario.html" class="btn btn-nuevo">Nueva Validación</a>
            <a href="..\index.php" class="btn btn-principal">Index</a>
            <a href="javascript:history.back()" class="btn btn-volver">Volver Atrás</a>
        </div>
        
        <?php if (!$resultado['valido']): ?>
        <div class="datos">
            <h3>Requisitos necesarios:</h3>
            <ul>
                <li>Sexo debe ser: <strong>Femenino</strong></li>
                <li>Edad debe estar entre: <strong>18 y 35 años</strong></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>