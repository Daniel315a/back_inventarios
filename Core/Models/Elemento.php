<?php namespace Models;

    class Elemento
    {
    
        public $id;
        public $controlador;

        function __construct()
        {
            if(func_num_args() > 0)
            {
                if(is_numeric(func_get_arg(0)))
                {
                    $this->id = func_get_arg(0);
                    $this->consultarPorId();                    
                }                
            }
        }

        /**
         * Métodos
         */

        public function consultarPorId()
        {
            $sql = "SELECT * 
                    FROM elementos 
                    WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->controlador = $datos[0]->controlador;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

    }
    

?>