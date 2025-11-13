<?php
    namespace MARKETZONE\DB;

    abstract class DataBase {
        /** @var \mysqli $conexion Conexión activa con la base de datos */
        protected $conexion;

        /**
         * Inicializa la conexión con la base de datos.
         *
         * @param string $dbname Nombre de la base de datos
         * @param string $usuario Usuario de acceso
         * @param string $clave Contraseña del usuario
         */
        public function __construct($dbname, $usuario, $clave) {
            $this->conexion = @new \mysqli('localhost', $usuario, $clave, $dbname);
        }
    }
?>
