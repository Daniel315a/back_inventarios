<?php namespace Controllers;

    class Producto
    {

        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $producto = new \Models\Producto();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {            
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_por_id')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id']);
                    
                    if($parametrosOk)
                    {
                        $producto->id = $_GET['id'];
                        $respuesta = $producto->consultarPorId();
                    }
                }

            }

            \responder($respuesta, $parametrosOk);
        }

        public static function post()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $producto = new \Models\Producto();
            $parametrosOk = true;

            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];

                if($solicitud == 'crear')
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
                else if($solicitud == 'actualizar')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);

                    if($parametrosOk)
                    {
                        $producto = new \Models\Producto($_POST['id']);
                        
                        $producto->detalle = isset($_POST['detalle']) ? $_POST['detalle'] : $producto->detalle;
                        $producto->cantidad_interna = isset($_POST['cantidad_interna']) ? $_POST['cantidad_interna'] : $producto->cantidad_interna;
                        $producto->cantidad_disponible = isset($_POST['cantidad_disponible']) ? $_POST['cantidad_disponible'] : $producto->cantidad_disponible;
                        $producto->precio = isset($_POST['precio']) ? $_POST['precio'] : $producto->precio;

                        $respuesta = $producto->actualizar();
                    }
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }

?>