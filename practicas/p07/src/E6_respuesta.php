<?php
    // Incluir el archivo de funciones
    include 'funciones.php';

    // Variables auxiliares para clases dinámicas
    $claseResultado = '';
    if (isset($tipoConsulta) && $tipoConsulta === 'por_matricula') {
        $claseResultado = isset($resultado['encontrado']) && $resultado['encontrado'] ? 'exito' : 'error';
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultado - Consulta Parque Vehicular</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333333;
            text-align: center;
            margin-bottom: 30px;
        }
        .resultado {
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
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
        .info-vehiculo {
            background-color: #e7f3ff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .tabla-vehiculos {
            margin: 30px 0;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #dddddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
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
            color: #ffffff;
        }
        .btn-nuevo {
            background-color: #28a745;
            color: #ffffff;
        }
        .btn-principal {
            background-color: #007bff;
            color: #ffffff;
        }
        .detalles {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .seccion {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .estructura {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 12px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado - Consulta del Parque Vehicular</h1>            
        <?php if ($tipoConsulta === 'por_matricula'): ?>
            
            <!-- Resultado de búsqueda por matrícula -->    
                <h2>
                    <?php echo $resultado['encontrado'] ? '&#10003; Vehículo Encontrado' : '&#10007; Vehículo No Encontrado'; ?>
                </h2>
                <p><strong>Matrícula buscada:</strong> <?php echo htmlspecialchars($matricula, ENT_QUOTES, 'UTF-8'); ?></p>
                
                <?php if ($resultado['encontrado']): ?>
                    <p>Se encontró el vehículo con la matrícula <strong><?php echo htmlspecialchars($resultado['matricula'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                <?php else: ?>
                    <p>No se encontró ningún vehículo con la matrícula <strong><?php echo htmlspecialchars($resultado['matricula'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
                <?php endif; ?>
    </div>
            
            <?php if ($resultado['encontrado']): ?>
                <div class="info-vehiculo">
                    <h2>Información del Vehículo</h2>
                    <div class="detalles">
                        <div class="seccion">
                            <h3>Datos del Auto</h3>
                            <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($resultado['matricula'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Marca:</strong> <?php echo htmlspecialchars($resultado['datos']['Auto']['marca'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Modelo:</strong> <?php echo htmlspecialchars($resultado['datos']['Auto']['modelo'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Tipo:</strong> <?php echo ucfirst(htmlspecialchars($resultado['datos']['Auto']['tipo'], ENT_QUOTES, 'UTF-8')); ?></p>
                        </div>
                        
                        <div class="seccion">
                            <h3>Datos del Propietario</h3>
                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($resultado['datos']['Propietario']['nombre'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($resultado['datos']['Propietario']['ciudad'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($resultado['datos']['Propietario']['direccion'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>    
        
        <?php else: ?>
            <!-- Resultado de consulta general -->
            <div class="resultado exito">
                <h2>&#128221; Todos los Vehículos Registrados</h2>
                <p>Se muestran los <strong><?php echo count($parqueVehicular); ?> vehículos</strong> registrados en el parque vehicular.</p>
            </div>
            
            <div class="tabla-vehiculos">
                <table>
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Tipo</th>
                            <th>Propietario</th>
                            <th>Ciudad</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parqueVehicular as $matricula => $vehiculo): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($matricula, ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><?php echo htmlspecialchars($vehiculo['Auto']['marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['Auto']['modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($vehiculo['Auto']['tipo'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['Propietario']['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['Propietario']['ciudad'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($vehiculo['Propietario']['direccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <!-- Mostrar estructura del arreglo con print_r -->
        <div class="estructura">
            <h2>Estructura del Arreglo (print_r)</h2>
            <pre><?php 
            if ($tipoConsulta === 'por_matricula' && $resultado['encontrado']) {
                echo htmlspecialchars(print_r([$resultado['matricula'] => $resultado['datos']], true), ENT_QUOTES, 'UTF-8');
            } else {
                echo htmlspecialchars(print_r($parqueVehicular, true), ENT_QUOTES, 'UTF-8');
            }
            ?></pre>
        </div>
        
        <div class="botones">
            <a href="E6_formulario.html" class="btn btn-nuevo">Nueva Consulta</a>
            <a href="../index.php" class="btn btn-principal">Index</a>
        </div>    
        
        <p>
            <a href="https://validator.w3.org/check?uri=referer"><img
            src="https://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="36" width="93" /></a>
        </p>
</body>
</html>