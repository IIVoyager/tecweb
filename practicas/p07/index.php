<?php
    // Incluir el archivo de funciones
    include 'funciones.php';

    // Generar la secuencia cuando se carga la página
    $resultadoSecuencia = generarSecuenciaImparParImpar();
    $secuencias = $resultadoSecuencia['secuencias'];
    $totalIntentos = $resultadoSecuencia['totalIntentos'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 7</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .ejercicio {
            margin: 30px 0;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        .ejercicio1 {
            background-color: #f9f9f9;
        }
        .ejercicio2 {
            background-color: #f0f8ff;
        }
        .resultado {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #333;
        }
        form {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        input[type="text"] {
            padding: 8px;
            width: 200px;
        }
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .secuencia {
            margin: 5px 0;
            padding: 8px;
            font-family: monospace;
        }
        .secuencia-cumple {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            font-weight: bold;
        }
        .secuencia-no-cumple {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .resumen {
            background-color: #e7f3ff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .explicacion {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3ff;
        }
    </style>
</head>
<body>
    <h1>Práctica 7: Uso de funciones, ciclos y arreglos en PHP </h1>

    <!-- Ejercicio 1: Múltiplos de 5 y 7 -->
    <div class="ejercicio ejercicio1">
        <h2>Ejercicio 1: Comprobar si un número es múltiplo de 5 y 7</h2>
        
        <!-- Formulario para ingresar el número -->
        <form method="GET" action="">
            <label for="numero">Ingresa un número:</label>
            <input type="text" name="numero" id="numero" placeholder="Ej: 35" required>
            <button type="submit">Comprobar</button>
        </form>
        
        <?php
        // Verificar si se ha pasado el parámetro 'numero' por GET
        if (isset($_GET['numero'])) {
            $numero = $_GET['numero'];
            echo '<div class="resultado">';
            echo '<h3>Resultado:</h3>';
            echo esMultiploDe5y7($numero);
            echo '</div>';
        }
        ?>
        
        <div class="explicacion">       
            <h3>Explicación:</h3>
            <p>Un número es múltiplo de 5 y 7 si es divisible entre ambos números.</p>
            <p><strong>Fórmula:</strong> (número % 5 == 0) Y (número % 7 == 0)</p>
        </div>
    </div>

    
    <!-- Ejercicio 2: Secuencia impar, par, impar -->
    <div class="ejercicio ejercicio2">
        <h2>Ejercicio 2: Generar secuencia impar, par, impar</h2>
        <p>Generar números aleatorios de 3 dígitos hasta obtener una secuencia que cumpla: IMPAR, PAR, IMPAR</p>
        
        <div class="resumen">
            <h3>Resumen:</h3>
            <p>Se generaron <strong><?php echo $totalIntentos; ?> intentos</strong> hasta encontrar la secuencia deseada.</p>
            <p>La secuencia final encontrada: 
                <strong><?php echo $secuencias[count($secuencias)-1]['numeros'][0]; ?>, 
                <?php echo $secuencias[count($secuencias)-1]['numeros'][1]; ?>, 
                <?php echo $secuencias[count($secuencias)-1]['numeros'][2]; ?></strong>
            </p>
        </div>
        
        <h3>Secuencias generadas:</h3>
        <?php
        foreach ($secuencias as $secuencia) {
            $clase = $secuencia['cumplePatron'] ? 'secuencia-cumple' : 'secuencia-no-cumple';
            echo '<div class="secuencia ' . $clase . '">';
            echo '<strong>Intento ' . $secuencia['intento'] . ':</strong> ';
            echo $secuencia['numeros'][0] . ' (' . esParOImpar($secuencia['numeros'][0]) . '), ';
            echo $secuencia['numeros'][1] . ' (' . esParOImpar($secuencia['numeros'][1]) . '), ';
            echo $secuencia['numeros'][2] . ' (' . esParOImpar($secuencia['numeros'][2]) . ')';
            
            if ($secuencia['cumplePatron']) {
                echo ' <strong>✓ PATRÓN ENCONTRADO</strong>';
            }
            echo '</div>';
        }
        ?>
        
        <form method="GET" action="">
            <input type="hidden" name="numero" value="<?php echo isset($_GET['numero']) ? $_GET['numero'] : ''; ?>">
            <button type="submit">Generar nueva secuencia</button>
        </form>
    </div>
</body>
</html>