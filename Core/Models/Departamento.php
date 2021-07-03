<?php namespace Models;

    class Departamento
    {
        
        public $id;
        public $nombre;

        function __construct()
        {

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

    }
    
?>