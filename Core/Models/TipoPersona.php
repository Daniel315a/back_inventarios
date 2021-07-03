<?php namespace Models;

    class TipoPersona
    {
        
        public $id;
        public $nombre;
        public $es_empleado;

        function _construct()
        {

        }

        // Métodos

        public function consultarTodos()
        {
            $sql = "SELECT * FROM tipos_persona;";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' =>  $datos
                ]);
            }

            return $respuesta;            
        }

    }
    
?>