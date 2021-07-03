<?php namespace Models;

    class Accion
    {

        private $id;
        public $nombre;
        public $valor;

        function __construct()
        {

        }

        /**
         * Métodos
         */

        public function consultarPorPermiso($id_permiso)
        {
            $sql = "SELECT id,
                            nombre,
                            valor
                    FROM acciones
                    WHERE permiso = {$id_permiso}";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $datos
                ]);
            }

            return $respuesta;
        }

    }
    
?>