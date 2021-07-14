<?php namespace Models;

    class DetalleFactura extends BaseModelo
    {
        
        public $id;
        public $producto;
        public $descripcion;
        public $precio;
        public $porcentaje_descuento;
        public $valor_descuento;
        public $es_instalacion;

        function __construct()
        {
            parent::__construct();
        }

        /**
         * Métodos
         */

        public static function consultarDeFactura($id_factura)
        {
            $sql = "SELECT 
                        id,
                        producto,
                        cantidad,
                        descripcion,
                        porcentaje_descuento,
                        valor_descuento,
                        precio_unitario,
                        precio_total,
                        es_instalacion
                    FROM detalles_factura 
                    WHERE factura = {$id_factura};";

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
                    'datos' => $datos 
                ]);
            }

            return $respuesta;
        }

        public static function crearDeFactura($json_detalles, $id_factura)
        {
            $detalles = json_decode($json_detalles);
            $sql = "INSERT INTO detalles_factura 
                    (
                        producto,
                        factura,
                	    cantidad,
                	    descripcion,
                	    porcentaje_descuento,
                	    valor_descuento,
                	    precio_unitario,
                	    precio_total,
                	    es_instalacion
                    )
                    VALUES";

            for ($i=0; $i < \count($detalles); $i++) { 
                $sql .= "(
                            {$detalles[$i]->producto->id},
                            {$id_factura},
                            {$detalles[0]->cantidad},
                            '{$detalles[0]->descripcion}',
                            {$detalles[0]->porcentaje_descuento},
                            {$detalles[0]->valor_descuento},
                            {$detalles[0]->precio_unitario},
                            {$detalles[0]->precio_total},
                            {$detalles[0]->es_instalacion}
                        )";

                if($i < \count($detalles) - 1)
                {
                    $sql .= ',';
                }
                else
                {
                    $sql .= ';';
                }
            }

            $conexion = new \Conexion();
            $conexion->execCommand($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getRegistrosAfectados() > 0)
            {
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => DetalleFactura::consultarDeFactura($id_factura)->datos
                ]);
            }

            return $respuesta;
        }

    }
    
?>