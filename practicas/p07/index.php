<?php
    // Incluir el archivo de funciones
    include 'funciones.php';

    // Generar la secuencia cuando se carga la página
    $resultadoSecuencia = generarSecuenciaImparParImpar();
    $matriz = $resultadoSecuencia['matriz'];
    $iteraciones = $resultadoSecuencia['iteraciones'];
    $totalNumeros = $resultadoSecuencia['totalNumeros'];
    $ultimaSecuencia = $resultadoSecuencia['ultimaSecuencia'];
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
        .explicacion {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3ff;
        }
        .estadisticas {
            background-color: #fff3cd;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 1.1em;
        }
        table {
            width: 100%;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
        }
        td {
            padding: 8px;
        }
        .patron-cumplido {
            background-color: #d4edda;
            font-weight: bold;
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
        
        <div class="estadisticas">
            <h3>Estadísticas:</h3>
            <p><strong><?php echo $totalNumeros; ?> números</strong> obtenidos en <strong><?php echo $iteraciones; ?> iteraciones</strong></p>
            <p><strong>Dimensión de la matriz:</strong> <?php echo count($matriz); ?> filas × 3 columnas</p>
            <p><strong>Secuencia final encontrada:</strong> 
                <?php echo $ultimaSecuencia[0]; ?> (<?php echo esParOImpar($ultimaSecuencia[0]); ?>), 
                <?php echo $ultimaSecuencia[1]; ?> (<?php echo esParOImpar($ultimaSecuencia[1]); ?>), 
                <?php echo $ultimaSecuencia[2]; ?> (<?php echo esParOImpar($ultimaSecuencia[2]); ?>)
            </p>
        </div>
        
        <h3>Matriz de secuencias generadas (<?php echo count($matriz); ?>×3):</h3>
        <?php echo mostrarMatriz($matriz); ?>
        
        <form method="GET" action="">
            <input type="hidden" name="numero" value="<?php echo isset($_GET['numero']) ? $_GET['numero'] : ''; ?>">
            <button type="submit">Generar nueva secuencia</button>
        </form>
    </div>
</body>
</html>