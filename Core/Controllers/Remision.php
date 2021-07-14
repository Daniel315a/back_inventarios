<?php namespace Controllers;

    class Remision
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $remision = new \Models\Remision();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'por_id')
                {
                    $parametrosOk = \variablesEnArreglo($_GET, ['id']);

                    if($parametrosOk)
                    {
                        $remision->id = $_GET['id'];
                        $respuesta = $remision->consultarPorId();
                    }
                }
                else if($solicitud == 'consultar_listado')
                {
                    $respuesta = $remision->consultarListado();
                }
            }

            \responder($respuesta, $parametrosOk);
        }

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