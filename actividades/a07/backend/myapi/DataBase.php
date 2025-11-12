<?php
namespace MyAPI;

/**
 * Clase abstracta Database para manejar la conexión a la base de datos
 */
abstract class Database {
    /**
     * @var \mysqli Objeto de conexión a la base de datos
     */
    protected $conexion;

    /**
     * Constructor de la clase Database
     * 
     * @param string $db Nombre de la base de datos
     * @param string $user Usuario de la base de datos (opcional)
     * @param string $pass Contraseña de la base de datos (opcional)
     */
    public function __construct(string $db, string $user = 'root', string $pass = '') {
        $this->conectar($db, $user, $pass);
    }

    /**
     * Establece la conexión con la base de datos
     * 
     * @param string $db Nombre de la base de datos
     * @param string $user Usuario de la base de datos
     * @param string $pass Contraseña de la base de datos
     * @return void
     */
    protected function conectar(string $db, string $user, string $pass): void {
        // Intentar establecer la conexión
        $this->conexion = @mysqli_connect('localhost', $user, $pass, $db);

        // Verificar si la conexión fue exitosa
        if (!$this->conexion) {
            $this->manejarErrorConexion();
        }

        // Establecer el charset a UTF-8
        $this->conexion->set_charset("utf8");
    }

    /**
     * Maneja errores de conexión a la base de datos
     * 
     * @return void
     */
    protected function manejarErrorConexion(): void {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => '¡Base de datos NO conectada! Error: ' . mysqli_connect_error()
        ]);
        exit();
    }

    /**
     * Cierra la conexión a la base de datos
     * 
     * @return void
     */
    public function cerrarConexion(): void {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    /**
     * Destructor - cierra la conexión automáticamente
     */
    public function __destruct() {
        $this->cerrarConexion();
    }
}
?>