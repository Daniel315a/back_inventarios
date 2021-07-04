<?php namespace Controllers;

    class Producto
    {
        
        public static function post()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $producto = new \Models\Producto();
            $parametrosOk = true;

            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];

                if($solicitud == 'crear_producto')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id_empresa', 'referencia']);

                    if($parametrosOk)
                    {
                        $producto->empresa = new \Models\Empresa($_POST['id_empresa']);
                        $producto->referencia = $_POST['referencia'];
                        $producto->detalle = $_POST['detalle'];
                        $producto->cantidad_interna = $_POST['cantidad_interna'];
                        $producto->cantidad_disponible = $_POST['cantidad_disponible'];
                        $producto->precio = $_POST['precio'];

                        $respuesta = $producto->crear();
                    }
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }

?>