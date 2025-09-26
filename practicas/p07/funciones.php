<?php
/**
 * Ejercicio 1: Función para comprobar si un número es múltiplo de 5 y 7
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
 * Ejercicio 2: Función para generar secuencias de 3 números aleatorios hasta obtener impar, par, impar
 * @return array Array con la matriz de secuencias y estadísticas
 */
function generarSecuenciaImparParImpar() {
    $matriz = []; // Matriz Mx3 donde M es el número de filas
    $encontrado = false;
    $iteraciones = 0;
    
    while (!$encontrado) {
        $iteraciones++;
        // Generar 3 números aleatorios entre 100 y 999
        $fila = [
            rand(100, 999),
            rand(100, 999),
            rand(100, 999)
        ];
        
        // Agregar la fila a la matriz
        $matriz[] = $fila;
        
        // Verificar si cumple el patrón impar, par, impar
        $cumplePatron = ($fila[0] % 2 != 0) && ($fila[1] % 2 == 0) && ($fila[2] % 2 != 0);
        
        // Si cumple el patrón, terminar el bucle
        if ($cumplePatron) {
            $encontrado = true;
        }
    }
    
    // Calcular total de números generados
    $totalNumeros = count($matriz) * 3;
    
    return [
        'matriz' => $matriz,
        'iteraciones' => $iteraciones,
        'totalNumeros' => $totalNumeros,
        'ultimaSecuencia' => end($matriz)
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

/**
 * Función para formatear la matriz en una tabla HTML
 * @param array $matriz La matriz de números
 * @return string HTML de la tabla formateada
 */
function mostrarMatriz($matriz) {
    $html = '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">';
    $html .= '<tr><th>Iteración</th><th>Número 1</th><th>Número 2</th><th>Número 3</th><th>Patrón</th></tr>';
    
    foreach ($matriz as $indice => $fila) {
        $iteracion = $indice + 1;
        $patron = esParOImpar($fila[0]) . ', ' . esParOImpar($fila[1]) . ', ' . esParOImpar($fila[2]);
        
        // Verificar si es la última fila (la que cumple el patrón)
        $esUltima = ($iteracion == count($matriz));
        $fondo = $esUltima ? 'background-color: #d4edda;' : '';
        
        $html .= '<tr style="' . $fondo . '">';
        $html .= '<td><strong>' . $iteracion . '</strong></td>';
        $html .= '<td>' . $fila[0] . ' (' . esParOImpar($fila[0]) . ')</td>';
        $html .= '<td>' . $fila[1] . ' (' . esParOImpar($fila[1]) . ')</td>';
        $html .= '<td>' . $fila[2] . ' (' . esParOImpar($fila[2]) . ')</td>';
        $html .= '<td><strong>' . $patron . '</strong>' . ($esUltima ? ' ✓' : '') . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}
?>