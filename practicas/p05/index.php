<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 5</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar, $_7var, myvar, $myvar, $var7, $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>

    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <p>$a = “ManejadorSQL” <br> $b = 'MySQL’ <br>$c = &$a</p>

    <?php
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;
    ?>

    <p><b> a. Muestra el contenido de cada variable </b></p>
     <?php
        echo '<h4>Respuesta:</h4>';   
        echo "<p>\$a = $a <br> \$b = $b <br> \$c = $c</p>";
    ?>

    <p><b>b. Agrega al código actual las siguientes asignaciones: </b></p>
    <p>$a = “PHP server” <br>$b = &$a</p>
    <?php
        $a = "PHP server";
        $b = &$a;
    ?>

    <p><b>c. Vuelve a mostrar el contenido de cada uno</b></p>
    <?php
        echo '<h4>Respuesta:</h4>';
        echo "<p>\$a = $a <br> \$b = $b <br> \$c = $c</p>";
    ?>

    <p><b>d. Describe qué ocurrió en el segundo bloque de asignaciones</b></p>
    <?php
        echo '<h4>Respuesta:</h4>';
        echo "<p>En el segundo bloque de asignaciones, la variable \$a fue reasignada al valor 'PHP server'. 
        Dado que a la variable \$b se le cambia su valor para hacer referencia a la variable \$a, 
        ahora refleja el nuevo valor de \$a. 
        La variable, \$c sigue siendo una referencia a \$a (desde la asignación anterior \$c = &\$a) y dado
        que \$a cambió de valor, \$c también muestra 'PHP server'.</p>";

        unset($a, $b, $c); // Limpiar variables para evitar conflictos en el siguiente ejercicio
    ?>

    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación verificando la evolución 
        del tipo de estas variables (imprime todos los componentes de los arreglos):</p>
    <p>$a = “PHP5” <br>$z[] = &$a <br>$b = “5a version de PHP” <br>$c = $b*10 <br>$a .= $b <br>$b *= $c<br> $z[0] = “MySQL”</p>
    <?php
        echo '<h4>Respuesta:</h4>';
        
        $a = "PHP5";
        echo "<p><i>Al asignar \$a = \"PHP5\": </i><br>";
        echo "\$a = $a (tipo: " . gettype($a) . ")</p>";
        
        $z[] = &$a;
        echo "<p><i>Al asignar \$z[] = &\$a:</i><br>";
        echo "\$z = ";
        print_r($z);
        echo " (tipo: " . gettype($z) . ")</p>";
        
        $b = "5a version de PHP";
        echo "<p><i>Al asignar \$b = \"5a version de PHP\":</i><br>"; echo "\$b = $b (tipo: " . gettype($b) . ")</p>";
        
        $b = (int)$b; // Convertir a entero para evitar warning en la siguiente operación
        $c = $b*10;
        echo "<p><i>Al asignar \$c = \$b * 10:</i><br>";
        echo "\$c = $c (tipo: " . gettype($c) . ")</p>";
        
        $a .= $b;
        echo "<p><i>Al asignar \$a .= \$b:</i><br>";
        echo "\$a = $a (tipo: " . gettype($a) . ")</p>";
        
        $b *= $c;
        echo "<p>Al asignar \$b *= \$c:</i><br>";
        echo "\$b = $b (tipo: " . gettype($b) . ")</p>";
        
        $z[0] = "MySQL";
        echo "<p><i>Al asignar \$z[0] = \"MySQL\":</i><br>";
        echo "\$a = $a (tipo: " . gettype($a) . ")<br>";
        echo "\$z = ";
        print_r($z);
        echo " (tipo: " . gettype($z) . ")</p>";
        
        unset($a, $b, $c, $z); // Limpiar variables para evitar conflictos en el siguiente ejercicio
    ?>

    <h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
       la matriz $GLOBALS o del modificador global de PHP.</p>
    <?php
        echo '<h4>Respuesta:</h4>';
        echo "<p>Usando \$GLOBALS:</p>";
        echo "<ul>";
        echo "<li>\$GLOBALS['a'] = " . $GLOBALS['a'] . "</li>";
        echo "<li>\$GLOBALS['b'] = " . $GLOBALS['b'] . "</li>";
        echo "<li>\$GLOBALS['c'] = " . $GLOBALS['c'] . "</li>";
        echo "<li>\$GLOBALS['z'] = ";
        print_r($GLOBALS['z']);
        echo "</li>";
        echo "</ul>";
    ?>

    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <p>$a = “7 personas” <br> $b = (integer) $a <br> $a = “9E3” <br> $c = (double) $a</p>
    <?php
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;
        
        echo '<h4>Respuesta:</h4>';
        echo "<p>\$a = $a <br> \$b = $b <br> \$c = $c</p>";
    ?>
</body>
</html>