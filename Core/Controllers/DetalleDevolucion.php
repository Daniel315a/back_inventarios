<?php namespace Controllers;

    class DetalleDevolucion
    {
        
        public static function post()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $detalleDevolucion = new \Models\DetalleDevolucion();
            $parametrosOk = true;

            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];

                if($solicitud == 'crear')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, [
                        'id_producto',
                        'id_remision',
                        'cantidad',
                        'precio',
                        'inventario_interno'
                    ]);

                    if($parametrosOk)
                    {
                        $remision = new \Models\Remision($_POST['id_remision']);
                        
                        $detalleDevolucion->producto = new \Models\Producto($_POST['id_producto']);
                        $detalleDevolucion->cantidad = $_POST['cantidad'];
                        $detalleDevolucion->precio = $_POST['precio'];
                        $detalleDevolucion->inventario_interno = $_POST['inventario_interno'];
                        $detalleDevolucion->descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

                        $respuesta = $detalleDevolucion->crear($remision);
                    }
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }
    
?>