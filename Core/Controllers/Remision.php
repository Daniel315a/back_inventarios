<?php namespace Controllers;

    class Remision
    {
        
        public static function post()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $remision = new \Models\Remision();
            $parametrosOk = true;

            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];

                if($solicitud == 'crear')
                {
                    $remision->factura = new \Models\Factura($_POST['id_factura']);
                    $remision->encargado = new \Models\Persona($_POST['id_encargado']);
                    $remision->estado = false;
                    $remision->notas = $_POST['notas'];
                    $remision->fecha_entrega = $_POST['fecha_entrega'];
                    $remision->fecha_instalacion = $_POST['fecha_instalacion'];

                    $respuesta = $remision->crear();
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }
    
?>