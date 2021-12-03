<?php namespace Controllers;

    class Factura
    {
        
        public static function get()
        {
            $parametrosOk = true;
            $respuesta = \Respuesta::obtenerDefault();
            $factura = new \Models\Factura();

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_consecutivo')
                {
                    $respuesta = $factura->consultarConsecutivo();
                }
                else if($solicitud == 'por_id')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id']);

                    if($parametrosOk)
                    {
                        $factura->id = $_GET['id'];
                        $respuesta = $factura->consultarPorId();
                    }
                }
                else if($solicitud == 'listado')
                {
                    $respuesta = $factura->consultarListado();
                }
                else if($solicitud == 'informe_csv')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, 
                    [
                        'fecha_inicial', 
                        'fecha_final', 
                        'texto'
                    ]);
                    
                    if($parametrosOk)
                    {
                        $respuesta = $factura->consultarCsvConFiltro($_GET['fecha_inicial'], $_GET['fecha_final'], $_GET['texto']);
                    }
                }
            }

            \responder($respuesta, $parametrosOk);
        }

        public static function post()
        {
            $parametrosOk = true;
            $respuesta = \Respuesta::obtenerDefault();
            $factura = new \Models\Factura();

            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];

                if($solicitud == 'crear')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, [
                        'id_cliente',
                        'id_vendedor',
                        'fecha'
                    ]);

                    if($parametrosOk)
                    {
                        $factura->fecha = $_POST['fecha'];
                        $factura->cliente = new \Models\Persona($_POST['id_cliente']);
                        $factura->vendedor = new \Models\Persona($_POST['id_vendedor']);
                        $factura->usuario = $GLOBALS['usuario'];
                        $factura->valor_total = isset($_POST['valor_total']) ? $_POST['valor_total'] : 0;
                        $factura->porcentaje_comision = isset($_POST['porcentaje_comision']) ? $_POST['porcentaje_comision'] : 0;
                        $factura->valor_comision = isset($_POST['valor_comision']) ? $_POST['valor_comision'] : 0;
                        $factura->total_descuento = isset($_POST['total_descuento']) ? $_POST['total_descuento'] : 0;
                        $factura->total_iva = isset($_POST['total_iva']) ? $_POST['total_iva'] : 0;

                        $respuesta = $factura->crear($_POST['detalles']);
                    }
                }
                else if($solicitud == 'anular')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, ['id']);

                    if($parametrosOk)
                    {
                        $factura->id = $_POST['id'];
                        $respuesta = $factura->anular();
                    }
                }
            }

            \responder($respuesta, $parametrosOk);

        }

    }
    
?>