<?php
/**
 * Ejercicio 1: Función para comprobar si un número es múltiplo de 5 y 7
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


/**
 * Ejercicio 2: Función para generar secuencias de 3 números aleatorios hasta obtener impar, par, impar
 * @return array Array con la matriz de secuencias y estadísticas
 */
function generarSecuenciaImparParImpar() {
    $matriz = []; // Matriz Mx3 donde M es el número de filas
    $encontrado = false;
    $iteraciones = 0;
    
    while (!$encontrado) {
        $iteraciones++;
        // Generar 3 números aleatorios entre 100 y 999
        $fila = [
            rand(100, 999),
            rand(100, 999),
            rand(100, 999)
        ];
        
        // Agregar la fila a la matriz
        $matriz[] = $fila;
        
        // Verificar si cumple el patrón impar, par, impar
        $cumplePatron = ($fila[0] % 2 != 0) && ($fila[1] % 2 == 0) && ($fila[2] % 2 != 0);
        
        // Si cumple el patrón, terminar el bucle
        if ($cumplePatron) {
            $encontrado = true;
        }
    }
    
    // Calcular total de números generados
    $totalNumeros = count($matriz) * 3;
    
    return [
        'matriz' => $matriz,
        'iteraciones' => $iteraciones,
        'totalNumeros' => $totalNumeros,
        'ultimaSecuencia' => end($matriz)
    ];
}

/**
 * Función auxiliar para determinar si un número es par o impar
 * @param int $numero El número a evaluar
 * @return string "par" o "impar"
 */
function esParOImpar($numero) {
    return ($numero % 2 == 0) ? "par" : "impar";
}

/**
 * Función para formatear la matriz en una tabla HTML
 * @param array $matriz La matriz de números
 * @return string HTML de la tabla formateada
 */
function mostrarMatriz($matriz) {
    $html = '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin: 10px 0;">';
    $html .= '<tr><th>Iteración</th><th>Número 1</th><th>Número 2</th><th>Número 3</th><th>Patrón</th></tr>';
    
    foreach ($matriz as $indice => $fila) {
        $iteracion = $indice + 1;
        $patron = esParOImpar($fila[0]) . ', ' . esParOImpar($fila[1]) . ', ' . esParOImpar($fila[2]);
        
        // Verificar si es la última fila (la que cumple el patrón)
        $esUltima = ($iteracion == count($matriz));
        $fondo = $esUltima ? 'background-color: #d4edda;' : '';
        
        $html .= '<tr style="' . $fondo . '">';
        $html .= '<td><strong>' . $iteracion . '</strong></td>';
        $html .= '<td>' . $fila[0] . ' (' . esParOImpar($fila[0]) . ')</td>';
        $html .= '<td>' . $fila[1] . ' (' . esParOImpar($fila[1]) . ')</td>';
        $html .= '<td>' . $fila[2] . ' (' . esParOImpar($fila[2]) . ')</td>';
        $html .= '<td><strong>' . $patron . '</strong>' . ($esUltima ? ' ✓' : '') . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}


/**
 * Ejercicio 3: Función para encontrar múltiplo usando ciclo WHILE
 * @param int $multiplo El múltiplo a buscar
 * @return array Resultados del proceso
 */
function encontrarMultiploConWhile($multiplo) {
    $intentos = 0;
    $numerosGenerados = [];
    $numeroEncontrado = null;
    
    // Validar que el múltiplo sea válido
    if ($multiplo <= 0) {
        return [
            'encontrado' => false,
            'numero' => null,
            'intentos' => 0,
            'numerosGenerados' => [],
            'error' => 'El múltiplo debe ser un número positivo mayor que 0'
        ];
    }
    
    while ($numeroEncontrado === null) {
        $intentos++;
        $numeroAleatorio = rand(1, 1000); // Generar número entre 1 y 1000
        $numerosGenerados[] = $numeroAleatorio;
        
        if ($numeroAleatorio % $multiplo == 0) {
            $numeroEncontrado = $numeroAleatorio;
        }
        
        // Límite de seguridad para evitar bucles infinitos
        if ($intentos > 10000) {
            return [
                'encontrado' => false,
                'numero' => null,
                'intentos' => $intentos,
                'numerosGenerados' => $numerosGenerados,
                'error' => 'Límite de intentos alcanzado (10,000)'
            ];
        }
    }
    
    return [
        'encontrado' => true,
        'numero' => $numeroEncontrado,
        'intentos' => $intentos,
        'numerosGenerados' => $numerosGenerados,
        'error' => null
    ];
}

/**
 * Ejercicio 3: Función para encontrar múltiplo usando ciclo DO-WHILE
 * @param int $multiplo El múltiplo a buscar
 * @return array Resultados del proceso
 */
function encontrarMultiploConDoWhile($multiplo) {
    $intentos = 0;
    $numerosGenerados = [];
    $numeroEncontrado = null;
    
    // Validar que el múltiplo sea válido
    if ($multiplo <= 0) {
        return [
            'encontrado' => false,
            'numero' => null,
            'intentos' => 0,
            'numerosGenerados' => [],
            'error' => 'El múltiplo debe ser un número positivo mayor que 0'
        ];
    }
    
    do {
        $intentos++;
        $numeroAleatorio = rand(1, 1000); // Generar número entre 1 y 1000
        $numerosGenerados[] = $numeroAleatorio;
        
        if ($numeroAleatorio % $multiplo == 0) {
            $numeroEncontrado = $numeroAleatorio;
        }
        
        // Límite de seguridad para evitar bucles infinitos
        if ($intentos > 10000) {
            return [
                'encontrado' => false,
                'numero' => null,
                'intentos' => $intentos,
                'numerosGenerados' => $numerosGenerados,
                'error' => 'Límite de intentos alcanzado (10,000)'
            ];
        }
    } while ($numeroEncontrado === null);
    
    return [
        'encontrado' => true,
        'numero' => $numeroEncontrado,
        'intentos' => $intentos,
        'numerosGenerados' => $numerosGenerados,
        'error' => null
    ];
}


/**
 * Ejercicio 4: Función para crear arreglo ASCII de letras minúsculas
 * @return array Arreglo con índices 97-122 y valores a-z
 */
function crearArregloAscii() {
    $arreglo = [];
    
    // Crear arreglo con ciclo for (97 a 122)
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }
    
    return $arreglo;
}

/**
 * Ejercicio 4: Función para generar tabla HTML del arreglo ASCII
 * @param array $arreglo Arreglo ASCII a mostrar
 * @return string HTML de la tabla formateada
 */
function generarTablaAscii($arreglo) {
    $html = '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; margin: 10px 0; width: 100%;">';
    $html .= '<tr><th>Código ASCII</th><th>Carácter</th><th>Letra</th></tr>';
    
    $contador = 0;
    foreach ($arreglo as $codigo => $letra) {
        // Alternar colores de fondo para mejor legibilidad
        $fondo = ($contador % 2 == 0) ? 'background-color: #f9f9f9;' : 'background-color: #ffffff;';
        
        $html .= '<tr style="' . $fondo . '">';
        $html .= '<td style="text-align: center; font-weight: bold;">' . $codigo . '</td>';
        $html .= '<td style="text-align: center; font-family: monospace; font-size: 1.2em;">' . chr($codigo) . '</td>';
        $html .= '<td style="text-align: center; font-size: 1.2em; font-weight: bold;">' . strtoupper($letra) . ' (' . $letra . ')</td>';
        $html .= '</tr>';
        
        $contador++;
    }
    
    $html .= '</table>';
    return $html;
}


/**
 * Ejercicio 5: Función para validar edad y sexo (Ejercicio 5)
 * @param int $edad La edad de la persona
 * @param string $sexo El sexo de la persona (femenino/masculino)
 * @return array Resultado de la validación con mensaje
 */
function validarEdadSexo($edad, $sexo) {
    // Validaciones básicas
    if (!is_numeric($edad) || $edad < 0 || $edad > 150) {
        return [
            'valido' => false,
            'mensaje' => 'Error: La edad debe ser un número válido entre 0 y 150 años.'
        ];
    }
    
    $edad = (int)$edad;
    $sexo = strtolower(trim($sexo));
    
    // Verificar condiciones: sexo femenino y edad entre 18-35
    if ($sexo === 'femenino' && $edad >= 18 && $edad <= 35) {
        return [
            'valido' => true,
            'mensaje' => '¡Bienvenida! Usted está en el rango de edad permitido.'
        ];
    } else {
        $mensaje = 'Lo sentimos, no cumple con los requisitos. ';
        
        if ($sexo !== 'femenino') {
            $mensaje .= 'El acceso está permitido solo para sexo femenino. ';
        }
        
        if ($edad < 18) {
            $mensaje .= 'Debe ser mayor de 18 años. ';
        } elseif ($edad > 35) {
            $mensaje .= 'La edad máxima permitida es 35 años. ';
        }
        
        return [
            'valido' => false,
            'mensaje' => $mensaje
        ];
    }
}


/**
 * Ejercicio 6: Función para crear el arreglo del parque vehicular
 * @return array Arreglo asociativo con los datos de 15 vehículos
 */
function crearParqueVehicular() {
    return [
        'UBN6338' => [
            'Auto' => [
                'marca' => 'HONDA',
                'modelo' => 2020,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Alfonzo Esparza',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'C.U., Jardines de San Manuel'
            ]
        ],
        'ABC1234' => [
            'Auto' => [
                'marca' => 'TOYOTA',
                'modelo' => 2022,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'María González',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Centro Histórico 123'
            ]
        ],
        'XYZ5678' => [
            'Auto' => [
                'marca' => 'NISSAN',
                'modelo' => 2019,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Carlos Rodríguez',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Av. Juárez 456'
            ]
        ],
        'DEF9012' => [
            'Auto' => [
                'marca' => 'VOLKSWAGEN',
                'modelo' => 2021,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Ana Martínez',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Col. La Paz 789'
            ]
        ],
        'GHI3456' => [
            'Auto' => [
                'marca' => 'FORD',
                'modelo' => 2018,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Roberto Sánchez',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Blvd. 5 de Mayo 321'
            ]
        ],
        'JKL7890' => [
            'Auto' => [
                'marca' => 'CHEVROLET',
                'modelo' => 2023,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Laura Hernández',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Zona Dorada 654'
            ]
        ],
        'MNO2345' => [
            'Auto' => [
                'marca' => 'HYUNDAI',
                'modelo' => 2020,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Miguel Torres',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Residencial San Jorge 987'
            ]
        ],
        'PQR6789' => [
            'Auto' => [
                'marca' => 'KIA',
                'modelo' => 2021,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Sofía Ramírez',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Fracc. Las Ánimas 147'
            ]
        ],
        'STU0123' => [
            'Auto' => [
                'marca' => 'MAZDA',
                'modelo' => 2019,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Javier López',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Av. Reforma 258'
            ]
        ],
        'VWX4567' => [
            'Auto' => [
                'marca' => 'SUBARU',
                'modelo' => 2022,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Elena Castro',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Col. El Carmen 369'
            ]
        ],
        'YZA8901' => [
            'Auto' => [
                'marca' => 'BMW',
                'modelo' => 2023,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Diego Morales',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Privada de los Pinos 753'
            ]
        ],
        'BCD2345' => [
            'Auto' => [
                'marca' => 'AUDI',
                'modelo' => 2021,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Patricia Reyes',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Calle 5 de Febrero 159'
            ]
        ],
        'EFG6789' => [
            'Auto' => [
                'marca' => 'MERCEDES-BENZ',
                'modelo' => 2020,
                'tipo' => 'sedan'
            ],
            'Propietario' => [
                'nombre' => 'Ricardo Ortega',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Av. 14 Sur 486'
            ]
        ],
        'HIJ0123' => [
            'Auto' => [
                'marca' => 'VOLVO',
                'modelo' => 2022,
                'tipo' => 'camioneta'
            ],
            'Propietario' => [
                'nombre' => 'Carmen Vargas',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Blvd. Atlixco 642'
            ]
        ],
        'KLM4567' => [
            'Auto' => [
                'marca' => 'RENAULT',
                'modelo' => 2019,
                'tipo' => 'hachback'
            ],
            'Propietario' => [
                'nombre' => 'Fernando Mendoza',
                'ciudad' => 'Puebla, Pue.',
                'direccion' => 'Col. Amalucan 825'
            ]
        ]
    ];
}


/**
 * Ejercicio 6: Función para buscar vehículo por matrícula
*/
function buscarPorMatricula($matricula, $parqueVehicular) {
    $matricula = strtoupper(trim($matricula));
    
    if (array_key_exists($matricula, $parqueVehicular)) {
        return [
            'matricula' => $matricula,
            'datos' => $parqueVehicular[$matricula],
            'encontrado' => true
        ];
    }
    
    return [
        'matricula' => $matricula,
        'datos' => null,
        'encontrado' => false
    ];
}

    // Obtener datos del formulario via POST
    $tipoConsulta = isset($_POST['tipo_consulta']) ? $_POST['tipo_consulta'] : 'todos';
    $matricula = isset($_POST['matricula']) ? $_POST['matricula'] : '';

    // Validar que se hayan enviado los datos
    if ($tipoConsulta === 'por_matricula' && empty($matricula)) {
        header('Location: ejercicio6_formulario.html');
        exit();
    }

    // Crear el parque vehicular
    $parqueVehicular = crearParqueVehicular();

    // Procesar la consulta
    if ($tipoConsulta === 'por_matricula') {
        $resultado = buscarPorMatricula($matricula, $parqueVehicular);
    } else {
        $resultado = ['todos' => true];
    }
?>