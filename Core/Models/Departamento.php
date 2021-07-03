<?php namespace Models;

    class Departamento
    {
        
        public $id;
        public $nombre;

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

        // Métodos

        function consultarTodos()
        {
            $sql = "SELECT * FROM departamentos;";

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

        function consultarPorId()
        {
            $sql = "SELECT * FROM departamentos WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->nombre = $datos[0]->nombre;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' =>  $this
                ]);
            }

            return $respuesta;
        }

    }
    
?>