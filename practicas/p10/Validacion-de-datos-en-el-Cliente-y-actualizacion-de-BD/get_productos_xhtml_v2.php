<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
    // Verificar si se recibió el parámetro 'tope' por GET
    if(isset($_GET['tope']))
        $tope = $_GET['tope'];

    // Variable para almacenar los resultados de la consulta
    $rows = array();

    // Verificar que el parámetro 'tope' no esté vacío
    if (!empty($tope))
    {
        /** SE CREA EL OBJETO DE CONEXIÓN */
        @$link = new mysqli('localhost', 'root', 'dap048ac', 'marketzone');    

        /** Comprobar la conexión */
        if ($link->connect_errno) 
        {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
                /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
        }

        /** Consulta para obtener productos con unidades menores o iguales al tope especificado */
        // Se usa prepared statement para prevenir inyecciones SQL
        $sql = "SELECT * FROM productos WHERE unidades <= ?";
        
        if ($stmt = $link->prepare($sql)) 
        {
            // Vincular el parámetro (se asume que tope es un entero)
            $stmt->bind_param("i", $tope);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $result = $stmt->get_result();
            
            // Almacenar todos los resultados en un array
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
            
            // Cerrar el statement
            $stmt->close();
        }

        // Cerrar la conexión
        $link->close();
    }
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Productos por Unidades</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h3><br>PRODUCTOS CON UNIDADES MENORES O IGUALES A: <?= isset($tope) ? $tope : 'N/A' ?></h3>

            <br/>
            
            <?php if( !empty($rows) ) : ?>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rows as $row): ?>
                        <tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['marca'] ?></td>
                            <td><?= $row['modelo'] ?></td>
                            <td>$<?= number_format($row['precio'], 2) ?></td>
                            <td><?= $row['unidades'] ?></td>
                            <td><?= utf8_encode($row['detalles']) ?></td>
                            <td><img src="<?= $row['imagen'] ?>" width="170" height="120"></td>
                            <td>
                                <button class="btn btn-primary btn-sm" 
                                        onclick="modificarProducto(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)">
                                    Modificar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Mostrar el total de productos encontrados -->
                <div class="alert alert-info" role="alert">
                    Total de productos encontrados: <?= count($rows) ?>
                </div>

            <?php elseif(!empty($tope)) : ?>

                <!-- Mensaje cuando no se encuentran productos -->
                <div class="alert alert-warning" role="alert">
                    No se encontraron productos con un número de unidades menor o igual a <?= $tope ?>
                </div>

            <?php else : ?>

                <!-- Mensaje cuando no se proporciona el parámetro tope -->
                <div class="alert alert-danger" role="alert">
                    Error: Debe proporcionar el parámetro 'tope' en la URL. 
                </div>

            <?php endif; ?>
        </div>

        <script>
            function modificarProducto(producto) {
                // Codificar los datos del producto para pasarlos por URL
                const datosCodificados = encodeURIComponent(JSON.stringify(producto));
                
                // Redirigir al formulario de modificación con los datos del producto
                window.location.href = 'formulario_productos_v2.html?producto=' + datosCodificados;
            }
        </script>
    </body>
</html>