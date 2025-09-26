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
?>