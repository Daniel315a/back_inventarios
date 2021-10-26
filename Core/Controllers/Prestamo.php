<?php namespace Controllers;

    class Prestamo
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $prestamo = new \Models\Prestamo();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_por_id')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id']);

                    if($parametrosOk){
                        $respuesta = $prestamo->consultarPorId($_GET['id']);
                    }
                }

                if($solicitud == 'consultar_por_empresa')
                {
                    $idEmpresa = 0;

                    if(isset($_GET['empresa'])){
                        $idEmpresa = $_GET['empresa'];
                    }

                    $respuesta = $prestamo->consultarPorEmpresa($idEmpresa);
                }
            }
            
            \responder($respuesta, $parametrosOk);
        }

        public static function post()
        {
            $prestamo = new \Models\Prestamo();
            $respuesta = \Respuesta::obtenerDefault();
            $parametrosOk = true;
    
            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];
    
                if($solicitud == 'crear')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['distribuidor', 'fecha_prestamo', 'detalles']);
                    
                    if($parametrosOk === true)
                    {
                        $prestamo->distribuidor = new \Models\Persona($_POST['distribuidor']);
                        $prestamo->fecha_prestamo = $_POST['fecha_prestamo'];
                        $prestamo->notas = isset($_POST['notas']) ? $_POST['notas'] : null;

                        if(isset($_POST['empleado']))
                        {
                            $prestamo->empleado = new \Models\Persona($_POST['empleado']);
                        }
    
                        if(isset($_POST['fecha_devolucion']))
                        {
                            $prestamo->empleado = $_POST['fecha_devolucion'];
                        }
        
                        $respuesta = $prestamo->crear($_POST['detalles']);
                    }
                }

                if($solicitud == 'actualizar')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);

                    if($parametrosOk)
                    {
                        $prestamo = new \Models\Prestamo($_POST['id']);

                        $prestamo->distribuidor = isset($_POST['id_distribuidor']) ? new \Models\Persona($_POST['id_distribuidor']) : $prestamo->distribuidor;
                        $prestamo->empleado = isset($_POST['id_empleado']) ? new \Models\Persona($_POST['id_empleado']) : $prestamo->empleado;
                        $prestamo->fecha_devolucion = isset($_POST['fecha_devolucion']) ? $_POST['fecha_devolucion'] : $prestamo->fecha_devolucion;
                        $prestamo->notas = isset($_POST['notas']) ? $_POST['notas'] : $prestamo->notas;

                        $respuesta = $prestamo->actualizar();
                    }
                    
                }

                if($solicitud == 'eliminar')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true){
                        $prestamo->consultarPorId($_POST['id']);

                        if($prestamo->fecha_devolucion == null){

                            $detalle = new \Models\DetallePrestamo();
                            $detalle->eliminarPorPrestamo($_POST['id']);

                            $respuesta = $prestamo->eliminar();
                        }else{
                            $respuesta = \Respuesta::obtener(false, 'No puede eliminar un prestamo entregado', null);
                        }

                        
                    }
    
                }

                if($solicitud == 'eliminar_detalle')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true)
                    {
                        $detalle = new \Models\DetallePrestamo($_POST['id']);

                        $respuesta = $detalle->eliminar();
                    }
    
                }
                
                if($solicitud == 'eliminar_detalles')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);
    
                    if($parametrosOk === true)
                    {
                        $detalle = new \Models\DetallePrestamo();

                        $respuesta = $detalle->eliminarPorPrestamo($_POST['id']);
                    }
    
                }
            }
    
            \responder($respuesta, $parametrosOk);
        }

    }
    
?>