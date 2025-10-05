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