<?php
// Incluir el archivo de funciones
include 'funciones.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobar Múltiplo de 5 y 7</title>
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
    </style>
</head>
<body>
    <h1>Comprobar si un número es múltiplo de 5 y 7</h1>
    
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
</body>
</html>