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

    }
    
?>