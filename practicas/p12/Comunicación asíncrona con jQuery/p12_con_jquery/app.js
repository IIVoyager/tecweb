// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();

    // EVENT HANDLERS CON JQUERY
    $(document).ready(function() {
        // Buscar producto al enviar formulario de búsqueda
        $('#search-form').on('submit', buscarProducto);
        
        // Buscar producto en tiempo real mientras se escribe
        $('#search').on('input', buscarProductoRealTime);
        
        // Agregar producto al enviar formulario
        $('#product-form').on('submit', agregarProducto);
        
        // Eliminar producto (event delegation para elementos dinámicos)
        $('#products').on('click', '.product-delete', eliminarProducto);
    });
}

// FUNCIÓN PARA LISTAR TODOS LOS PRODUCTOS
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        dataType: 'json',
        success: function(productos) {
            if(Object.keys(productos).length > 0) {
                let template = '';

                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#products').html(template);
            } else {
                $('#products').html('<tr><td colspan="4" class="text-center">No hay productos</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar productos:', error);
            mostrarEstado('error', 'Error al cargar productos');
        }
    });
}

// FUNCIÓN PARA BÚSQUEDA EN TIEMPO REAL
function buscarProductoRealTime() {
    const search = $('#search').val().trim();
    
    if (search.length === 0) {
        listarProductos();
        $('#product-result').addClass('d-none');
        return;
    }
    
    if (search.length <= 1) return; // Esperar al menos 1 caracter
    
    buscarProductos(search);
}

// FUNCIÓN PARA BÚSQUEDA AL ENVIAR FORMULARIO
function buscarProducto(e) {
    if (e) e.preventDefault();
    const search = $('#search').val().trim();
    
    if (search.length === 0) {
        listarProductos();
        $('#product-result').addClass('d-none');
        return;
    }
    
    buscarProductos(search);
}

// FUNCIÓN COMÚN PARA BÚSQUEDA
function buscarProductos(search) {
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        dataType: 'json',
        success: function(productos) {
            if(Object.keys(productos).length > 0) {
                let template = '';
                let template_bar = '';

                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;

                    template_bar += `<li>${producto.nombre}</li>`;
                });
                
                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);
                $('#products').html(template);
            } else {
                $('#products').html('<tr><td colspan="4" class="text-center">No se encontraron productos</td></tr>');
                $('#product-result').removeClass('d-none');
                $('#container').html('<li>No se encontraron productos</li>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en búsqueda:', error);
            mostrarEstado('error', 'Error en la búsqueda');
        }
    });
}

// FUNCIÓN PARA AGREGAR PRODUCTO
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = $('#description').val();
    
    try {
        // SE CONVIERTE EL JSON DE STRING A OBJETO
        var finalJSON = JSON.parse(productoJsonString);
        // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
        finalJSON['nombre'] = $('#name').val();
        
        // VALIDACIONES BÁSICAS
        if (!finalJSON.nombre || finalJSON.nombre.trim() === '') {
            mostrarEstado('error', 'El nombre del producto es requerido');
            return;
        }

        // SE OBTIENE EL STRING DEL JSON FINAL
        productoJsonString = JSON.stringify(finalJSON,null,2);

        $.ajax({
            url: './backend/product-add.php',
            type: 'POST',
            data: productoJsonString,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            success: function(respuesta) {
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);

                // LIMPIAR FORMULARIO
                $('#name').val('');
                $('#description').val(JSON.stringify(baseJSON,null,2));

                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
            },
            error: function(xhr, status, error) {
                console.error('Error al agregar producto:', error);
                mostrarEstado('error', 'Error al agregar producto');
            }
        });
    } catch (error) {
        mostrarEstado('error', 'JSON inválido: ' + error.message);
    }
}

// FUNCIÓN PARA ELIMINAR PRODUCTO
function eliminarProducto() {
    if( confirm("¿De verdad deseas eliminar el Producto?") ) {
        var id = $(this).closest('tr').attr('productId');

        $.ajax({
            url: './backend/product-delete.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(respuesta) {
                let template_bar = '';
                template_bar += `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;

                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);

                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar producto:', error);
                mostrarEstado('error', 'Error al eliminar producto');
            }
        });
    }
}

// FUNCIÓN AUXILIAR PARA MOSTRAR ESTADO
function mostrarEstado(status, message) {
    let template_bar = '';
    template_bar += `
        <li style="list-style: none;">status: ${status}</li>
        <li style="list-style: none;">message: ${message}</li>
    `;

    $('#product-result').removeClass('d-none');
    $('#container').html(template_bar);
}
// SE ELIMINA LA FUNCIÓN getXMLHttpRequest() YA QUE SE USA JQUERY.AJAX