<?php namespace Models;

    class DetalleDevolucion extends BaseModelo
    {

        public $id;
        public $producto;
        public $cantidad;
        public $precio;
        public $inventario_interno;
        public $descripcion;

        /**
         * Métodos
         */

        public function crear($remision)
        {
            $sql = "INSERT INTO decora_transforma.detalles_devolucion
                    (
                        producto,
                        remision,
                        cantidad,
                        precio,
                        inventario_interno,
                        descripcion
                    )
                    VALUES
                    (
                        {$this->producto->id},
                        {$remision->id},
                        {$this->cantidad},
                        {$this->precio},
                        {$this->inventario_interno},
                        '{$this->descripcion}'
                    );";
                
            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

    }
    
?>