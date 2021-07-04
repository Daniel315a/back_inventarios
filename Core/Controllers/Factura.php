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
            }

            \responder($respuesta, $parametrosOk);
        }

    }
    
?>