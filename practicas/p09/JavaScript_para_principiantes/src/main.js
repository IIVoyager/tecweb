// Función de ejemplo
function getDatos() {
    var nombre = prompt("Nombre: ", "");
    var edad = prompt("Edad: ", 0);
    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';
    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

// Ejemplo 1: Hola mundo con document.write()
function ejemplo1() {
    document.getElementById('resultado1').innerHTML = '';
    document.write("Hola Mundo");
}

// Ejemplo 2: Mostrar variables
function mostrarVariables() { 
    // Definir las variables
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;
    
    document.getElementById('resultadoVariables').innerHTML = '';
    document.write('<h3>Nombre: '+nombre+'</h3>');
    document.write('<h3>Edad: '+edad+'</h3>');
    document.write('<h3>Altura: '+altura+'</h3>');
    document.write('<h3>Casado: '+casado+'</h3>');
}

// Ejemplo 3: Solicitar datos al usuario
function solicitarDatos() {
    var nombre;
    var edad;
    
    // Solicitar datos al usuario
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad:', '');
    
    // Limpiar el contenido anterior
    document.getElementById('resultadoSolicitarDatos').innerHTML = '';
    
    // Mostrar los datos usando document.write()
    document.write('Hola ');
    document.write(nombre);
    document.write(' así que tienes ');
    document.write(edad);
    document.write(' años');
}

// Ejemplo 4: Suma y Producto
function sumaProducto() {
    var valor1;
    var valor2;
    
    valor1 = prompt('Introducir primer número:', '');
    valor2 = prompt('Introducir segundo número:', '');
    
    var suma = parseInt(valor1) + parseInt(valor2);
    var producto = parseInt(valor1) * parseInt(valor2);
    
    document.getElementById('resultadoSumaProducto').innerHTML = '';
    document.write('La suma es ');
    document.write(suma);
    document.write('<br>');
    document.write('El producto es ');
    document.write(producto);
}

// Ejemplo 5: Verificar Aprobación
function verificarAprobacion() {
    var nombre;
    var nota;
    
    nombre = prompt('Ingresa tu nombre:', '');
    nota = prompt('Ingresa tu nota:', '');
    
    document.getElementById('resultadoAprobacion').innerHTML = '';
    
    if (nota >= 4) {
        document.write(nombre + ' esta aprobado con un ' + nota);
    }
}

// Ejemplo 6: Número Mayor
function numeroMayor() {
    var num1, num2;
    
    num1 = prompt('Ingresa el primer número:', '');
    num2 = prompt('Ingresa el segundo número:', '');
    
    num1 = parseInt(num1);
    num2 = parseInt(num2);
    
    document.getElementById('resultadoNumeroMayor').innerHTML = '';
    
    if (num1 > num2) {
        document.write('el mayor es ' + num1);
    } else {
        document.write('el mayor es ' + num2);
    }
}

// Ejemplo 7: Promedio de Notas
function promedioNotas() {
    var nota1, nota2, nota3;

    nota1 = prompt('Ingresa 1ra. nota:', '');
    nota2 = prompt('Ingresa 2da. nota:', '');
    nota3 = prompt('Ingresa 3ra. nota:', '');

    // Convertimos los 3 string en enteros
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);

    var pro;
    pro = (nota1 + nota2 + nota3) / 3;
    
    document.getElementById('resultadoPromedio').innerHTML = '';
    
    if (pro >= 7) {
        document.write('aprobado');
    } else {
        if (pro >= 4) {
            document.write('regular');
        } else {
            document.write('reprobado');
        }
    }
}

// Ejemplo 8: Números con Switch
function numerosSwitch() {
    var valor;
    
    valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '');
    // Convertimos a entero
    valor = parseInt(valor);
    
    document.getElementById('resultadoSwitch').innerHTML = '';
    
    switch (valor) {
        case 1: 
            document.write('uno');
            break;
        case 2: 
            document.write('dos');
            break;
        case 3: 
            document.write('tres');
            break;
        case 4: 
            document.write('cuatro');
            break;
        case 5: 
            document.write('cinco');
            break;
        default:
            document.write('debe ingresar un valor comprendido entre 1 y 5.');
    }
}

// Ejemplo 9: Cambiar Color de Fondo
function cambiarColor() {
    var col;
    
    col = prompt('Ingresa el color con que quieras pintar el fondo de la ventana (rojo, verde, azul)', '');
    
    document.getElementById('resultadoColor').innerHTML = '';
    
    switch (col) {
        case 'rojo': 
            document.write('Color de fondo cambiado a rojo');
            document.bgColor = '#ff0000';
            break;
        case 'verde': 
            document.write('Color de fondo cambiado a verde');
            document.bgColor = '#00ff00';
            break;
        case 'azul': 
            document.write('Color de fondo cambiado a azul');
            document.bgColor = '#0000ff';
            break;
        default:
            document.write('Color no válido. Use rojo, verde o azul.');
    }
}