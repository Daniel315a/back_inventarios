<?php namespace Controllers;

    class Cotizacion
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $cotizacion = new \Models\Cotizacion();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_por_id')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id']);

                    if($parametrosOk){
                        $respuesta = $cotizacion->consultarPorId($_GET['id']);
                    }
                }

                if($solicitud == 'consultar_por_empresa')
                {
                    $idEmpresa = 0;

                    if(isset($_GET['empresa'])){
                        $idEmpresa = $_GET['empresa'];
                    }

                    $respuesta = $cotizacion->consultarPorEmpresa($idEmpresa);
                }
            }
            
            \responder($respuesta, $parametrosOk);
        }

        public static function post(){
            $cotizacion = new \Models\Cotizacion();
            $respuesta = \Respuesta::obtenerDefault();
            $parametrosOk = true;
    
            if(isset($_POST['solicitud'])){
                $solicitud = $_POST['solicitud'];
    
                if($solicitud == 'crear'){
                    $parametrosOk = \variablesEnArreglo($_POST, 
                    [
                        'fecha',
                        'cliente', 
                        'notas', 
                        'precio_total'
                    ]);
                    
                    if($parametrosOk === true){
                        $cotizacion->fecha = $_POST['fecha'];
                        $cotizacion->cliente = new \Models\Persona($_POST['cliente']);
                        $cotizacion->notas = $_POST['notas'];
                        $cotizacion->precio_total = $_POST["precio_total"];

                        $respuesta = $cotizacion->crear();

                        if($respuesta->resultado){
                            if(isset($_POST['detalles'])){
                                $cotizacion->detalles = array();
                                $detalles = \json_decode($_POST['detalles']);

                                foreach ($detalles as $i => $detalle) {
                                    $detalleNuevo = new \Models\DetalleCotizacion();
                                    /*No se crean los objetos porque no retorna el json correctamente. */
                                    $detalleNuevo->cotizacion = $cotizacion->id;
                                    $detalleNuevo->producto = $detalle->producto;
                                    $detalleNuevo->cantidad = $detalle->cantidad;
                                    $detalleNuevo->descripcion = $detalle->descripcion;
                                    $detalleNuevo->precio_total = $detalle->precio_total;

                                    $detalleNuevo->crear();
                                    array_push($cotizacion->detalles, $detalleNuevo);
                                }
                            }
                        }
                    }
                }

                if($solicitud == 'actualizar'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
                    
                    if($parametrosOk === true){
                        $cotizacion = new \Models\Cotizacion($_POST['id']);
    

                        if(isset($_POST['cliente'])){
                            $cotizacion->cliente = new \Models\Persona($_POST['cliente']);
                        }

                        if(isset($_POST['notas'])){
                            $cotizacion->notas = $_POST["notas"];
                        }

                        if(isset($_POST['precio_total'])){
                            $cotizacion->precio_total = $_POST["precio_total"];
                        }

                        $respuesta = $cotizacion->actualizar();

                    }
                }

                if($solicitud == 'eliminar'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true){
                        $cotizacion->consultarPorId($_POST['id']);

                        $detalle = new \Models\DetalleCotizacion();
                        $detalle->eliminarPorCotizacion($_POST['id']);
                        
                        $respuesta = $cotizacion->eliminar();
                    }
    
                }

                if($solicitud == 'eliminar_detalle'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true){
                        $detalle = new \Models\DetalleCotizacion($_POST['id']);

                        $respuesta = $detalle->eliminar();
                    }
    
                }
                
                if($solicitud == 'eliminar_detalles'){
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true){
                        $detalle = new \Models\DetalleCotizacion();

                        $respuesta = $detalle->eliminarPorCotizacion($_POST['id']);
                    }
    
                }
            }
    
            \responder($respuesta, $parametrosOk);
        }

    }
    
?>