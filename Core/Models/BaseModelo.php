<?php namespace Models;

class BaseModelo {
    protected $conexion;

    function __construct(){
        $this->conexion = new \Conexion();
    }

    protected function obtenerRespuesta($datos, $esInsert, $esUpdateOrDelete){
        $respuesta = null;
        $registros = 0;

        if($esInsert === true || $esUpdateOrDelete === true){
            $registros = $this->conexion->getRegistrosAfectados();
        }else{
            $registros = $this->conexion->getCantidadRegistros();
        }

        if($registros > 0){

            if($esInsert === true){
                $this->id = $this->conexion->getIdInsertado();
            }

            $respuesta = new \Respuesta(
                ['resultado' => true,
                'datos' => $datos]);

        }else{
            $respuesta = \Respuesta::obtenerDefault();
        }

        return $respuesta;
    }
}

?>