<?php
    include("encabezado.inc.php");    // 1. Incluye y ejecuta el archivo encabezado.inc.php
    echo "<hr />";                    // 2. Imprime una línea horizontal después del encabezado
    include_once("cuerpo.inc.php");   // 3. Incluye cuerpo.inc.php SOLO UNA VEZ
    require("cuerpo.html");           // 4. Requiere cuerpo.html (si falla, detiene la ejecución)
    require_once("pie.inc.php");      // 5. Requiere pie.inc.php SOLO UNA VEZ (si falla, detiene la ejecución)
?>

/* 
    -------------------------- Secuencia lógica -----------------------------
    
    1. principal.php inicia ejecución
    2. Incluye y ejecuta encabezado.inc.php
        a. Define variable $variable1 con valor "PHP 5"
        b. Imprime título con variable
        c. Define otra variable $variableext
        d. Imprime encabezado con estilo
        e. Imprime texto de variable
        f. Muestra script actual y ruta del archivo incluido
    3. Regresa a principal.php y ejecuta echo "<hr />"
    4. Incluye cuerpo.inc.php (solo una vez)
        a. Imprime contenido del cuerpo
    5. Regresa a principal.php
    6. Requiere cuerpo.html (si falla, detiene la ejecución)
        a. Imprime contenido del cuerpo HTML                    
    7. Regresa a principal.php
    8. Requiere pie.inc.php (solo una vez, si falla, detiene la ejecución)
        a. Imprime pie de página
    9. Regresa a principal.php y finaliza ejecución
    
    ------------------------------------------------------------------------
*/