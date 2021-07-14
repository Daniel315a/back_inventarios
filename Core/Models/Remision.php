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

    }
    
?>