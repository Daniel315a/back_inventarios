<?php namespace Models;

    class TipoPersona
    {
        
        public $id;
        public $nombre;
        public $es_empleado;

        function __construct()
        {
            if(func_num_args() > 0)
            {   
                if(is_numeric(func_get_arg(0)))
                {
                    $this->consultarPorId(func_get_arg(0));
                }
            }
        }

        /**
         * Métodos
         */

        public function consultarPorId($id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM tipos_persona WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->nombre = $datos[0]->nombre;
                $this->es_empleado = $datos[0]->es_empleado;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

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