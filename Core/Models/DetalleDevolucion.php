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

        public static function consultarDeRemision($id_remision)
        {
            $sql = "SELECT 
                        id,
                        producto,
                        cantidad,
                        precio,
                        inventario_interno,
                        descripcion
                    FROM detalles_devolucion
                    WHERE remision = {$id_remision};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                foreach ($datos as $detalle) {
                    $detalle->producto = new Producto($detalle->producto);
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos'=> $datos
                ]);
            }

            return $respuesta;
        }

    }
    
?>