<?php namespace Models;

    class DetalleFactura extends BaseModelo
    {
        
        public $id;
        public $producto;
        public $descripcion;
        public $precio;
        public $porcentaje_descuento;
        public $valor_descuento;
        public $porcentaje_iva;
        public $valor_iva;
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
                        porcentaje_iva,
                        valor_iva,
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
                        porcentaje_iva,
                        valor_iva,
                	    precio_unitario,
                	    precio_total,
                	    es_instalacion
                    )
                    VALUES";

            for ($i=0; $i < \count($detalles); $i++) { 
                $sql .= "(
                            {$detalles[$i]->producto->id},
                            {$id_factura},
                            {$detalles[$i]->cantidad},
                            '{$detalles[$i]->descripcion}',
                            {$detalles[$i]->porcentaje_descuento},
                            {$detalles[$i]->valor_descuento},
                            {$detalles[$i]->porcentaje_iva},
                            {$detalles[$i]->valor_iva},
                            {$detalles[$i]->precio_unitario},
                            {$detalles[$i]->precio_total},
                            {$detalles[$i]->es_instalacion}
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
                $detalles = DetalleFactura::consultarDeFactura($id_factura)->datos;
                Producto::actualizar_existencias($detalles);

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $detalles
                ]);
            }

            return $respuesta;
        }

    }
    
?>