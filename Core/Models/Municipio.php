<?php namespace Models;

    class Municipio
    {
        
        public $id;
        public $nombre;
        public $departamento;

        function __construct()
        {

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

    }
    
?>