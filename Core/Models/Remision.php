<?php namespace Models;

    class Remision extends BaseModelo
    {
    
        public $id;
        public $factura;
        public $encargado;
        public $estado;
        public $nombre_archivo_soporte;
        public $notas;
        public $fecha_entrega;
        public $fecha_instalacion;

        /**
         * Métodos
         */

        public function crear()
        {
            $sql = "
            INSERT INTO decora_transforma.remisiones
            (
                factura,
                encargado,
                estado,
                notas,
                fecha_entrega,
                fecha_instalacion
            )
            VALUES
            (
                {$this->factura->id},
                {$this->encargado->id},
                0,
                '{$this->notas}',
                '{$this->fecha_entrega}',
                '{$this->fecha_instalacion}'
            );";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        public function consultarPorId()
        {
            $sql = "SELECT * 
                    FROM remisiones 
                    WHERE id = {$this->id};";

            $datos = $this->conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $this->id = $datos[0]->id;
                $this->factura = new Factura($datos[0]->factura);
                $this->encargado = new Persona($datos[0]->encargado);
                $this->estado = $datos[0]->estado;
                $this->nombre_archivo_soporte = $datos[0]->nombre_archivo_soporte;
                $this->notas = $datos[0]->notas;
                $this->fecha_entrega = $datos[0]->fecha_entrega;
                $this->fecha_instalacion = $datos[0]->fecha_instalacion;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function consultarListado()
        {
            
        }

    }
    
?>