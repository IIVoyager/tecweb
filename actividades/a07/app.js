// VARIABLES GLOBALES
var productoEditando = null;
var validaciones = {
    nombre: { valido: false, mensaje: '' },
    marca: { valido: false, mensaje: '' },
    modelo: { valido: false, mensaje: '' },
    precio: { valido: false, mensaje: '' },
    detalles: { valido: true, mensaje: '' },
    unidades: { valido: false, mensaje: '' },
    imagen: { valido: true, mensaje: '' }
};
var nombreExiste = false;

function init() {
    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();

    // EVENT HANDLERS CON JQUERY
    $(document).ready(function() {
        // Buscar producto al enviar formulario de búsqueda
        $('#search-form').on('submit', buscarProducto);
        
        // Buscar producto en tiempo real mientras se escribe
        $('#search').on('input', buscarProductoRealTime);
        
        // Agregar producto al enviar formulario
        $('#product-form').on('submit', manejarFormularioProducto);
        
        // Eliminar producto (event delegation para elementos dinámicos)
        $('#products').on('click', '.product-delete', eliminarProducto);

        // Editar producto (event delegation para elementos dinámicos)
        $('#products').on('click', '.product-edit', editarProducto);
        
        // Cancelar edición
        $('#cancelar-edicion').on('click', cancelarEdicion);

        // VALIDACIONES EN TIEMPO REAL
        $('#nombre').on('blur', validarNombre);
        $('#nombre').on('input', verificarNombreExistente);
        $('#marca').on('blur', validarMarca);
        $('#modelo').on('blur', validarModelo);
        $('#precio').on('blur', validarPrecio);
        $('#detalles').on('blur', validarDetalles);
        $('#unidades').on('blur', validarUnidades);
        $('#imagen').on('blur', validarImagen);

        // Limpiar validaciones al enfocar
        $('input, select, textarea').on('focus', function() {
            $(this).removeClass('is-invalid is-valid');
        });
    });
}

// FUNCIÓN PARA MANEJAR EL FORMULARIO (AGREGAR O EDITAR)
function manejarFormularioProducto(e) {
    e.preventDefault();
    
    // Validar todos los campos antes de enviar
    if (!validarFormularioCompleto()) {
        mostrarEstado('error', 'Por favor, corrige los errores en el formulario');
        return;
    }

    if (productoEditando) {
        guardarProductoEditado();
    } else {
        agregarProducto();
    }
}

// VALIDACIÓN DEL FORMULARIO COMPLETO
function validarFormularioCompleto() {
    validarNombre();
    validarMarca();
    validarModelo();
    validarPrecio();
    validarDetalles();
    validarUnidades();
    validarImagen();

    return Object.values(validaciones).every(valid => valid.valido);
}

// VALIDACIONES INDIVIDUALES
function validarNombre() {
    const nombre = $('#nombre').val().trim();
    const statusElement = $('#nombre-status');
    const fieldElement = $('#nombre');

    if (!nombre) {
        validaciones.nombre = { valido: false, mensaje: 'El nombre es requerido' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'El nombre es requerido');
        return false;
    }

    if (nombre.length > 100) {
        validaciones.nombre = { valido: false, mensaje: 'Máximo 100 caracteres' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Máximo 100 caracteres');
        return false;
    }

    if (nombreExiste && !productoEditando) {
        validaciones.nombre = { valido: false, mensaje: 'El nombre ya existe' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'El nombre ya existe en la base de datos');
        return false;
    }

    validaciones.nombre = { valido: true, mensaje: 'Nombre válido' };
    mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Nombre válido');
    return true;
}

function validarMarca() {
    const marca = $('#marca').val();
    const statusElement = $('#marca-status');
    const fieldElement = $('#marca');

    if (!marca) {
        validaciones.marca = { valido: false, mensaje: 'La marca es requerida' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Selecciona una marca');
        return false;
    }

    validaciones.marca = { valido: true, mensaje: 'Marca válida' };
    mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Marca válida');
    return true;
}

function validarModelo() {
    const modelo = $('#modelo').val().trim();
    const statusElement = $('#modelo-status');
    const fieldElement = $('#modelo');
    const alfanumericoRegex = /^[a-zA-Z0-9\-_ ]+$/;

    if (!modelo) {
        validaciones.modelo = { valido: false, mensaje: 'El modelo es requerido' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'El modelo es requerido');
        return false;
    }

    if (modelo.length > 25) {
        validaciones.modelo = { valido: false, mensaje: 'Maximo 25 caracteres' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Máximo 25 caracteres');
        return false;
    }

    if (!alfanumericoRegex.test(modelo)) {
        validaciones.modelo = { valido: false, mensaje: 'Solo caracteres alfanumericos' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Solo se permiten caracteres alfanumericos, guiones y espacios');
        return false;
    }

    validaciones.modelo = { valido: true, mensaje: 'Modelo valido' };
    mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Modelo valido');
    return true;
}

function validarPrecio() {
    const precio = parseFloat($('#precio').val());
    const statusElement = $('#precio-status');
    const fieldElement = $('#precio');

    if (isNaN(precio)) {
        validaciones.precio = { valido: false, mensaje: 'El precio es requerido' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'El precio es requerido');
        return false;
    }

    if (precio <= 99.99) {
        validaciones.precio = { valido: false, mensaje: 'El precio debe ser mayor a 99.99' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'El precio debe ser mayor a 99.99');
        return false;
    }

    validaciones.precio = { valido: true, mensaje: 'Precio valido' };
    mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Precio valido');
    return true;
}

function validarDetalles() {
    const detalles = $('#detalles').val().trim();
    const statusElement = $('#detalles-status');
    const fieldElement = $('#detalles');

    if (detalles.length > 250) {
        validaciones.detalles = { valido: false, mensaje: 'Maximo 250 caracteres' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Maximo 250 caracteres');
        return false;
    }

    validaciones.detalles = { valido: true, mensaje: 'Detalles validos' };
    if (detalles) {
        mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Detalles validos');
    } else {
        mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Campo opcional');
    }
    return true;
}

function validarUnidades() {
    const unidades = parseInt($('#unidades').val());
    const statusElement = $('#unidades-status');
    const fieldElement = $('#unidades');

    if (isNaN(unidades)) {
        validaciones.unidades = { valido: false, mensaje: 'Las unidades son requeridas' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Las unidades son requeridas');
        return false;
    }

    if (unidades < 0) {
        validaciones.unidades = { valido: false, mensaje: 'Las unidades no pueden ser negativas' };
        mostrarEstadoCampo(statusElement, fieldElement, 'invalid', 'Las unidades no pueden ser negativas');
        return false;
    }

    validaciones.unidades = { valido: true, mensaje: 'Unidades validas' };
    mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Unidades validas');
    return true;
}

function validarImagen() {
    const imagen = $('#imagen').val().trim();
    const statusElement = $('#imagen-status');
    const fieldElement = $('#imagen');

    if (!imagen) {
        // Si no hay imagen, usar la por defecto
        $('#imagen').val('img/default.png');
        mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Se usara imagen por defecto');
    } else {
        mostrarEstadoCampo(statusElement, fieldElement, 'valid', 'Imagen valida');
    }

    validaciones.imagen = { valido: true, mensaje: 'Imagen valida' };
    return true;
}

// FUNCIÓN PARA VERIFICAR SI EL NOMBRE EXISTE EN LA BD
function verificarNombreExistente() {
    const nombre = $('#nombre').val().trim();
    
    if (nombre.length < 2) {
        nombreExiste = false;
        return;
    }

    // Esperar 500ms después de que el usuario deje de escribir
    clearTimeout(window.nombreTimeout);
    window.nombreTimeout = setTimeout(() => {
        $.ajax({
            url: './backend/product-validate-name.php',
            type: 'GET',
            data: { 
                nombre: nombre,
                excluir: productoEditando || ''
            },
            dataType: 'json',
            success: function(respuesta) {
                nombreExiste = respuesta.existe;
                if (nombreExiste && !productoEditando) {
                    $('#nombre-status').html('<span class="status-invalid"> Este nombre ya existe. </span>');
                    $('#nombre').addClass('is-invalid');
                    validaciones.nombre.valido = false;
                } else {
                    validarNombre(); // Re-validar para actualizar estado
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al validar nombre:', error);
            }
        });
    }, 500);
}

// FUNCIÓN AUXILIAR PARA MOSTRAR ESTADO DEL CAMPO
function mostrarEstadoCampo(elemento, campo, tipo, mensaje) {
    elemento.removeClass('status-valid status-invalid status-warning');
    
    switch(tipo) {
        case 'valid':
            elemento.addClass('status-valid').text('✓ ' + mensaje);
            campo.removeClass('is-invalid').addClass('is-valid');
            break;
        case 'invalid':
            elemento.addClass('status-invalid').text('✗ ' + mensaje);
            campo.removeClass('is-valid').addClass('is-invalid');
            break;
        case 'warning':
            elemento.addClass('status-warning').text(mensaje);
            campo.removeClass('is-invalid is-valid');
            break;
    }
}

// FUNCIÓN PARA CANCELAR EDICIÓN
function cancelarEdicion() {
    productoEditando = null;
    nombreExiste = false;
    limpiarFormulario();
    $('#submit-btn').text('Agregar Producto');
    $('#cancelar-edicion').addClass('d-none');
    mostrarEstado('info', 'Edición cancelada');
}

// FUNCIÓN PARA LIMPIAR FORMULARIO
function limpiarFormulario() {
    $('#product-form')[0].reset();
    $('.field-status').empty();
    $('.form-control').removeClass('is-invalid is-valid');
    
    // Reiniciar validaciones
    Object.keys(validaciones).forEach(key => {
        if (key === 'detalles' || key === 'imagen') {
            validaciones[key] = { valido: true, mensaje: '' };
        } else {
            validaciones[key] = { valido: false, mensaje: '' };
        }
    });
}

// FUNCIÓN PARA EDITAR PRODUCTO
function editarProducto() {
    var id = $(this).closest('tr').attr('productId');
    var fila = $(this).closest('tr');
    
    // Obtener datos del producto de la fila
    var nombre = fila.find('td:eq(1)').text();
    
    // Obtener los detalles del producto de la lista
    var detallesProducto = {};
    fila.find('ul li').each(function() {
        var texto = $(this).text();
        if (texto.includes('precio:')) {
            detallesProducto.precio = parseFloat(texto.replace('precio:', '').trim());
        } else if (texto.includes('unidades:')) {
            detallesProducto.unidades = parseInt(texto.replace('unidades:', '').trim());
        } else if (texto.includes('modelo:')) {
            detallesProducto.modelo = texto.replace('modelo:', '').trim();
        } else if (texto.includes('marca:')) {
            detallesProducto.marca = texto.replace('marca:', '').trim();
        } else if (texto.includes('detalles:')) {
            detallesProducto.detalles = texto.replace('detalles:', '').trim();
        } else if (texto.includes('imagen:')) {
            detallesProducto.imagen = texto.replace('imagen:', '').trim();
        }
    });
    
    // Llenar el formulario con los datos del producto
    $('#nombre').val(nombre);
    $('#marca').val(detallesProducto.marca || '');
    $('#modelo').val(detallesProducto.modelo || '');
    $('#precio').val(detallesProducto.precio || '');
    $('#detalles').val(detallesProducto.detalles || '');
    $('#unidades').val(detallesProducto.unidades || '');
    $('#imagen').val(detallesProducto.imagen || 'img/default.png');
    
    // Cambiar el texto del botón
    $('#submit-btn').text('Guardar Cambios');
    
    // Mostrar botón de cancelar
    $('#cancelar-edicion').removeClass('d-none');
    
    // Guardar el ID del producto que se está editando
    productoEditando = id;
    
    // Validar campos automáticamente
    setTimeout(() => {
        validarNombre();
        validarMarca();
        validarModelo();
        validarPrecio();
        validarDetalles();
        validarUnidades();
        validarImagen();
    }, 100);
    
    mostrarEstado('info', 'Editando producto: ' + nombre);
}

// FUNCIÓN PARA GUARDAR PRODUCTO EDITADO
function guardarProductoEditado() {
    const productoData = {
        id: productoEditando,
        nombre: $('#nombre').val().trim(),
        marca: $('#marca').val(),
        modelo: $('#modelo').val().trim(),
        precio: parseFloat($('#precio').val()),
        detalles: $('#detalles').val().trim(),
        unidades: parseInt($('#unidades').val()),
        imagen: $('#imagen').val().trim() || 'img/default.png'
    };

    $.ajax({
        url: './backend/product-edit.php',
        type: 'POST',
        data: JSON.stringify(productoData),
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

            if (respuesta.status === 'success') {
                // LIMPIAR FORMULARIO Y RESTAURAR ESTADO
                cancelarEdicion();
                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al editar producto:', error);
            mostrarEstado('error', 'Error al editar producto');
        }
    });
}

// FUNCIÓN PARA AGREGAR PRODUCTO
function agregarProducto() {
    const productoData = {
        nombre: $('#nombre').val().trim(),
        marca: $('#marca').val(),
        modelo: $('#modelo').val().trim(),
        precio: parseFloat($('#precio').val()),
        detalles: $('#detalles').val().trim(),
        unidades: parseInt($('#unidades').val()),
        imagen: $('#imagen').val().trim() || 'img/default.png'
    };

    $.ajax({
        url: './backend/product-add.php',
        type: 'POST',
        data: JSON.stringify(productoData),
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

            if (respuesta.status === 'success') {
                // LIMPIAR FORMULARIO
                limpiarFormulario();
                // SE LISTAN TODOS LOS PRODUCTOS
                listarProductos();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al agregar producto:', error);
            mostrarEstado('error', 'Error al agregar producto');
        }
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
                    descripcion += '<li>imagen: '+producto.imagen+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button style="width: 100px; height: 30px; font-size: 14px;" class="product-edit btn btn-warning mr-2">
                                    Editar
                                </button>
                                <button style="width: 100px; height: 30px; font-size: 14px;" class="product-delete btn btn-danger">
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
    
    if (search.length <= 1) return;
    
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
                    descripcion += '<li>imagen: '+producto.imagen+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button style="width: 100px; height: 30px; font-size: 14px;" class="product-edit btn btn-warning mr-2">
                                    Editar
                                </button>
                                <button style="width: 100px; height: 30px; font-size: 14px;" class="product-delete btn btn-danger">
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
            console.error('Error en busqueda:', error);
            mostrarEstado('error', 'Error en la búsqueda');
        }
    });
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