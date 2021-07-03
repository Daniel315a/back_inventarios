<?php namespace Models;

    class Municipio
    {
        
        public $id;
        public $nombre;
        public $departamento;

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

        public function consultarPorDepartamento()
        {
            $sql = "SELECT id, nombre FROM municipios WHERE departamento = {$this->departamento->id};";

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

        public function consultarPorId()
        {
            $sql = "SELECT * FROM municipios WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->nombre = $datos[0]->nombre;
                $this->departamento = new Departamento($datos[0]->departamento);

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' =>  $this
                ]);
            }

            return $respuesta;
        }

    }
    
?>