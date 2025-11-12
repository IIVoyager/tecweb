<?php
namespace MyAPI;

require_once 'Database.php';
/**
 * Clase Products para manejar operaciones de productos
 * Hereda de la clase Database
 */
class Products extends Database {
    /**
     * @var array Almacena los datos de respuesta de las operaciones
     */
    private $response = [];

    /**
     * @var array Almacena los datos de los productos
     */
    private $data = [];

    /**
     * Constructor de la clase Products
     * 
     * @param string $db Nombre de la base de datos
     * @param string $user Usuario de la base de datos (opcional)
     * @param string $pass Contraseña de la base de datos (opcional)
     */
    public function __construct(string $db, string $user = 'root', string $pass = '') {
        // Inicializar el array de respuesta
        $this->response = [
            'status' => 'error',
            'message' => 'Operación no realizada'
        ];

        // Inicializar el array de datos
        $this->data = [];

        // Llamar al constructor de la clase padre
        parent::__construct($db, $user, $pass);
    }

    /**
     * Agrega un nuevo producto a la base de datos
     * 
     * @param \stdClass $productData Objeto con los datos del producto
     * @return void
     */
    public function add(\stdClass $productData): void {
        try {
            // Verificar si el producto ya existe
            $sqlCheck = "SELECT * FROM productos WHERE nombre = '{$productData->nombre}' AND eliminado = 0";
            $resultCheck = $this->conexion->query($sqlCheck);

            if ($resultCheck->num_rows == 0) {
                // Insertar el nuevo producto
                $sql = "INSERT INTO productos VALUES (
                    null, 
                    '{$productData->nombre}', 
                    '{$productData->marca}', 
                    '{$productData->modelo}', 
                    {$productData->precio}, 
                    '{$productData->detalles}', 
                    {$productData->unidades}, 
                    '{$productData->imagen}', 
                    0
                )";

                if ($this->conexion->query($sql)) {
                    $this->response = [
                        'status' => 'success',
                        'message' => 'Producto agregado'
                    ];
                } else {
                    $this->response = [
                        'status' => 'error',
                        'message' => 'ERROR: No se ejecutó ' . $sql . '. ' . mysqli_error($this->conexion)
                    ];
                }
                $resultCheck->free();
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Ya existe un producto con ese nombre'
                ];
                $resultCheck->free();
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error al agregar producto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un producto (marcándolo como eliminado)
     * 
     * @param string $id ID del producto a eliminar
     * @return void
     */
    public function delete(string $id): void {
        try {
            $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";

            if ($this->conexion->query($sql)) {
                $this->response = [
                    'status' => 'success',
                    'message' => 'Producto eliminado'
                ];
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'ERROR: No se ejecutó ' . $sql . '. ' . mysqli_error($this->conexion)
                ];
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error al eliminar producto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Edita un producto existente
     * 
     * @param \stdClass $productData Objeto con los datos actualizados del producto
     * @return void
     */
    public function edit(\stdClass $productData): void {
        try {
            $sql = "UPDATE productos SET 
                    nombre = '{$productData->nombre}',
                    marca = '{$productData->marca}',
                    modelo = '{$productData->modelo}',
                    precio = {$productData->precio},
                    detalles = '{$productData->detalles}',
                    unidades = {$productData->unidades},
                    imagen = '{$productData->imagen}'
                    WHERE id = {$productData->id} AND eliminado = 0";

            if ($this->conexion->query($sql)) {
                $this->response = [
                    'status' => 'success',
                    'message' => 'Producto actualizado correctamente'
                ];
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'ERROR: No se ejecutó ' . $sql . '. ' . mysqli_error($this->conexion)
                ];
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error al editar producto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene la lista de todos los productos no eliminados
     * 
     * @return void
     */
    public function list(): void {
        try {
            $sql = "SELECT * FROM productos WHERE eliminado = 0";
            
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
                
                $this->response = [
                    'status' => 'success',
                    'message' => 'Productos obtenidos correctamente'
                ];
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Query Error: ' . mysqli_error($this->conexion)
                ];
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error al listar productos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Busca productos por término de búsqueda
     * 
     * @param string $search Término de búsqueda
     * @return void
     */
    public function search(string $search): void {
        try {
            $sql = "SELECT * FROM productos WHERE 
                    (id = '{$search}' OR 
                     nombre LIKE '%{$search}%' OR 
                     marca LIKE '%{$search}%' OR 
                     detalles LIKE '%{$search}%') 
                    AND eliminado = 0";
            
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
                
                $this->response = [
                    'status' => 'success',
                    'message' => 'Búsqueda completada'
                ];
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Query Error: ' . mysqli_error($this->conexion)
                ];
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error en búsqueda: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene un producto específico por su ID
     * 
     * @param string $id ID del producto
     * @return void
     */
    public function single(string $id): void {
        try {
            $sql = "SELECT * FROM productos WHERE id = {$id} AND eliminado = 0";
            
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
                
                $this->response = [
                    'status' => 'success',
                    'message' => 'Producto obtenido correctamente'
                ];
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Query Error: ' . mysqli_error($this->conexion)
                ];
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error al obtener producto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtiene un producto específico por su nombre
     * 
     * @param string $name Nombre del producto
     * @return void
     */
    public function singleByName(string $name): void {
        try {
            $sql = "SELECT * FROM productos WHERE nombre = '{$name}' AND eliminado = 0";
            
            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
                
                $this->response = [
                    'status' => 'success',
                    'message' => 'Producto obtenido por nombre correctamente'
                ];
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Query Error: ' . mysqli_error($this->conexion)
                ];
            }
        } catch (\Exception $e) {
            $this->response = [
                'status' => 'error',
                'message' => 'Error al obtener producto por nombre: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Convierte los datos a formato JSON y los devuelve
     * 
     * @return string Datos en formato JSON
     */
    public function getData(): string {
        // Si hay datos en $this->data, devolverlos, de lo contrario devolver la respuesta
        if (!empty($this->data)) {
            return json_encode($this->data, JSON_PRETTY_PRINT);
        } else {
            return json_encode($this->response, JSON_PRETTY_PRINT);
        }
    }

    /**
     * Obtiene la respuesta de la operación
     * 
     * @return array Array con la respuesta
     */
    public function getResponse(): array {
        return $this->response;
    }

    /**
     * Obtiene los datos de los productos
     * 
     * @return array Array con los datos de los productos
     */
    public function getProductsData(): array {
        return $this->data;
    }
}
?>