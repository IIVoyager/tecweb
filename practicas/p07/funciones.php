<?php
/**
 * Función para comprobar si un número es múltiplo de 5 y 7
 * @param int $numero El número a comprobar
 * @return string Mensaje indicando si es múltiplo o no
 */

function esMultiploDe5y7($numero) {
    // Verificar que el parámetro sea un número válido
    if (!is_numeric($numero)) {
        return "Error: El parámetro debe ser un número válido.";
    }
    
    // Convertir a número entero
    $numero = (int)$numero;
    
    // Comprobar si es múltiplo de 5 y 7
    if ($numero % 5 == 0 && $numero % 7 == 0) {
        return "El número $numero <strong>SÍ</strong> es múltiplo de 5 y 7.";
    } else {
        return "El número $numero <strong>NO</strong> es múltiplo de 5 y 7.";
    }
}


/**
 * Función para generar secuencias de 3 números aleatorios hasta obtener impar, par, impar
 * @return array Array con todas las secuencias generadas y el conteo de intentos
 */

function generarSecuenciaImparParImpar() {
    $secuencias = [];
    $intentos = 0;
    $encontrado = false;
    
    while (!$encontrado) {
        $intentos++;
        // Generar 3 números aleatorios entre 100 y 999
        $num1 = rand(100, 999);
        $num2 = rand(100, 999);
        $num3 = rand(100, 999);
        
        // Verificar si cumple el patrón impar, par, impar
        $cumplePatron = ($num1 % 2 != 0) && ($num2 % 2 == 0) && ($num3 % 2 != 0);
        
        // Almacenar la secuencia
        $secuencias[] = [
            'numeros' => [$num1, $num2, $num3],
            'cumplePatron' => $cumplePatron,
            'intento' => $intentos
        ];
        
        // Si cumple el patrón, terminar el bucle
        if ($cumplePatron) {
            $encontrado = true;
        }
    }
    
    return [
        'secuencias' => $secuencias,
        'totalIntentos' => $intentos
    ];
}

/**
 * Función auxiliar para determinar si un número es par o impar
 * @param int $numero El número a evaluar
 * @return string "par" o "impar"
 */
function esParOImpar($numero) {
    return ($numero % 2 == 0) ? "par" : "impar";
}
?>