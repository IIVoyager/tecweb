// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

// FUNCIÓN PARA BÚSQUEDA VERSÁTIL DE PRODUCTOS 
function buscarProducto(e) {
    e.preventDefault();

    var criterio = document.getElementById('search').value.trim();
    if (criterio === "") {
        alert("Por favor, escribe algo para buscar.");
        return;
    }

    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);

            // CONVERTIR RESPUESTA A OBJETO JSON (array de productos)
            let productos = JSON.parse(client.responseText);

            // LIMPIAR TABLA
            document.getElementById("productos").innerHTML = "";

            // SI HAY RESULTADOS
            if (productos.length > 0) {
                let template = "";
                productos.forEach(p => {
                    let descripcion = `
                        <li>precio: ${p.precio}</li>
                        <li>unidades: ${p.unidades}</li>
                        <li>modelo: ${p.modelo}</li>
                        <li>marca: ${p.marca}</li>
                        <li>detalles: ${p.detalles}</li>
                    `;
                    template += `
                        <tr>
                            <td>${p.id}</td>
                            <td>${p.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });
                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = `
                    <tr><td colspan="3">No se encontraron productos.</td></tr>
                `;
            }
        }
    };
    client.send("id=" + encodeURIComponent(criterio));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE EL NOMBRE
    const nombre = document.getElementById('name').value.trim();
    if (nombre === '' || nombre.length > 100) {
        alert('El nombre es requerido y debe tener 100 caracteres o menos.');
        return;
    }

    // SE OBTIENE EL JSON DESDE EL FORMULARIO
    let productoJsonString = document.getElementById('description').value;
    let finalJSON;

    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch (error) {
        alert('El JSON del producto no es válido.');
        return;
    }

    // VALIDACIONES DE LOS CAMPOS DEL JSON
    const { marca, modelo, precio, detalles, unidades, imagen } = finalJSON;

    // b. Marca requerida (debe venir de una lista)
    const marcasValidas = ['Acer', 'HP', 'Dell', 'Logitech', 'Sony', 'Samsung', 'Seagate', 'LG'];
    if (!marca || !marcasValidas.includes(marca)) {
        alert('La marca es requerida y debe seleccionarse de la lista: ' + marcasValidas.join(', '));
        return;
    }

    // c. Modelo requerido, alfanumérico, <= 25 caracteres
    const modeloRegex = /^[a-zA-Z0-9\-]+$/;
    if (!modelo || !modeloRegex.test(modelo) || modelo.length > 25) {
        alert('El modelo es requerido, alfanumérico y debe tener 25 caracteres o menos.');
        return;
    }

    // d. Precio requerido y > 99.99
    if (isNaN(precio) || precio <= 99.99) {
        alert('El precio es requerido y debe ser mayor a 99.99.');
        return;
    }

    // e. Detalles opcional pero <= 250 caracteres
    if (detalles && detalles.length > 250) {
        alert('Los detalles deben tener 250 caracteres o menos.');
        return;
    }

    // f. Unidades requeridas >= 0
    if (isNaN(unidades) || unidades < 0) {
        alert('Las unidades deben ser un número mayor o igual a 0.');
        return;
    }

    // g. Imagen opcional (si no existe, usar por defecto)
    finalJSON.imagen = imagen && imagen.trim() !== '' ? imagen : 'img/default.jpg';

    // SE AGREGA EL NOMBRE AL JSON FINAL
    finalJSON.nombre = nombre;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            alert(client.responseText); // Mostrar respuesta del servidor
        }
    };
    client.send(JSON.stringify(finalJSON));
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}