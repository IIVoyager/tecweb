<hr/>  <!-- 16. Línea horizontal -->
    <?php
        echo "<div><h1 style=\"border-width:3;border-style:groove; background-color:
        #ffcc99;\"> Final de la página PHP Vínculos útiles : <a href=\"php.net\">php.net</a>
        &nbsp; <a href=\"mysql.org\">mysql.org</a></h1>";  // 17. Impie footer con enlaces y estilo
        echo "Nombre del archivo ejecutado: ", $_SERVER['PHP_SELF'],"&nbsp;&nbsp; &nbsp;";  // 20. Muestra script principal
        echo "Nombre del archivo incluido: ", __FILE__ ,"</div>";  // 19. Muestra ruta de este archivo
    ?>
    </body>  <!-- 20. Cierra body abierto en encabezado.inc.php -->
</html>  <!-- 21. Cierra html abierto en encabezado.inc.php -->