<?php
    // Incluir el archivo de funciones
    include 'funciones.php';

    // Generar la secuencia cuando se carga la página
    $resultadoSecuencia = generarSecuenciaImparParImpar();
    $matriz = $resultadoSecuencia['matriz'];
    $iteraciones = $resultadoSecuencia['iteraciones'];
    $totalNumeros = $resultadoSecuencia['totalNumeros'];
    $ultimaSecuencia = $resultadoSecuencia['ultimaSecuencia'];

    // Procesar ejercicio 3 si se proporciona un múltiplo
    $resultadoWhile = null;
    $resultadoDoWhile = null;
    $multiplo = null;

    if (isset($_GET['multiplo']) && $_GET['multiplo'] !== '') {
        $multiplo = (int)$_GET['multiplo'];
        $resultadoWhile = encontrarMultiploConWhile($multiplo);
        $resultadoDoWhile = encontrarMultiploConDoWhile($multiplo);
    }
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
         .ejercicio3 {
            background-color: #ffffffff;
        }
        .resultado {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #333;
        }
        .resultado-exito {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }
        .resultado-error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        form {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: 200px;
            margin: 5px;
        }
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .resumen {
            background-color: #fff3cdff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .explicacion {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3ff;
        }
        .estadisticas {
            background-color: #fff3cdff;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 1.1em;
        }
        .comparativa {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }
        .ciclo {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .ciclo-while {
            background-color: #e8f5e8;
        }
        .ciclo-dowhile {
            background-color: #e3f2fd;
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
        .numeros-lista {
            max-height: 150px;
            overflow-y: auto;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 1.3em;
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


    <!-- Ejercicio 3: Encontrar múltiplo usando WHILE y DO-WHILE -->
    <div class="ejercicio ejercicio3">
        <h2>Ejercicio 3: Encontrar múltiplo con ciclos WHILE y DO-WHILE</h2>
        <p>Encontrar el primer número aleatorio que sea múltiplo de un número dado</p>
        
        <form method="GET" action="">
            <label for="multiplo">Ingresa el múltiplo a buscar:</label>
            <input type="number" name="multiplo" id="multiplo" min="1" max="1000" 
                   placeholder="Ej: 7" value="<?php echo isset($_GET['multiplo']) ? htmlspecialchars($_GET['multiplo']) : ''; ?>" required>
            <button type="submit">Buscar múltiplo</button>
            <button type="button" onclick="location.href='index.php'">Limpiar</button>
        </form>
        
        <?php if ($multiplo !== null): ?>
            <div class="estadisticas">
                <h3>Buscando múltiplo de: <?php echo $multiplo; ?></h3>
                <p>Números generados entre 1 y 1000</p>
            </div>
            
            <div class="comparativa">
                <!-- Ciclo WHILE -->
                <div class="ciclo ciclo-while">
                    <h3>Usando ciclo WHILE</h3>
                    <?php if ($resultadoWhile['error']): ?>
                        <div class="resultado resultado-error">
                            <strong>Error:</strong> <?php echo $resultadoWhile['error']; ?>
                        </div>
                    <?php else: ?>
                        <div class="resultado resultado-exito">
                            <strong>¡Encontrado!</strong> El número <?php echo $resultadoWhile['numero']; ?> es múltiplo de <?php echo $multiplo; ?>
                        </div>
                        <p><strong>Intentos realizados:</strong> <?php echo $resultadoWhile['intentos']; ?></p>
                        <p><strong>Números generados:</strong> <?php echo count($resultadoWhile['numerosGenerados']); ?></p>
                        
                        <div class="numeros-lista">
                            <strong>Lista de números generados:</strong><br>
                            <?php 
                            $numeros = array_slice($resultadoWhile['numerosGenerados'], 0, 50);
                            echo implode(', ', $numeros);
                            if (count($resultadoWhile['numerosGenerados']) > 50) {
                                echo '... (' . (count($resultadoWhile['numerosGenerados']) - 50) . ' más)';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Ciclo DO-WHILE -->
                <div class="ciclo ciclo-dowhile">
                    <h3>Usando ciclo DO-WHILE</h3>
                    <?php if ($resultadoDoWhile['error']): ?>
                        <div class="resultado resultado-error">
                            <strong>Error:</strong> <?php echo $resultadoDoWhile['error']; ?>
                        </div>
                    <?php else: ?>
                        <div class="resultado resultado-exito">
                            <strong>¡Encontrado!</strong> El número <?php echo $resultadoDoWhile['numero']; ?> es múltiplo de <?php echo $multiplo; ?>
                        </div>
                        <p><strong>Intentos realizados:</strong> <?php echo $resultadoDoWhile['intentos']; ?></p>
                        <p><strong>Números generados:</strong> <?php echo count($resultadoDoWhile['numerosGenerados']); ?></p>
                        
                        <div class="numeros-lista">
                            <strong>Lista de números generados:</strong><br>
                            <?php 
                            $numeros = array_slice($resultadoDoWhile['numerosGenerados'], 0, 50);
                            echo implode(', ', $numeros);
                            if (count($resultadoDoWhile['numerosGenerados']) > 50) {
                                echo '... (' . (count($resultadoDoWhile['numerosGenerados']) - 50) . ' más)';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="resumen">
                <h3>Diferencia entre WHILE y DO-WHILE:</h3>
                <ul>
                    <li><strong>WHILE:</strong> Primero verifica la condición, luego ejecuta el código</li>
                    <li><strong>DO-WHILE:</strong> Primero ejecuta el código, luego verifica la condición</li>
                    <li>El DO-WHILE siempre se ejecuta al menos una vez</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>