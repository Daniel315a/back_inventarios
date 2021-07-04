<?php namespace Controllers;

    class TipoDocumento
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $tipo_documento = new \Models\TipoDocumento();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_todos')
                {
                    $respuesta = $tipo_documento->consultarTodos();
                }
            }
            
            \responder($respuesta, $parametrosOk);
        }

    }
    
?>