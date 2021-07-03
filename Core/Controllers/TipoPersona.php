<?php namespace Controllers;

    class TipoPersona
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $tipoPersona = new \Models\TipoPersona();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];

                if($solicitud == 'consultar_todos')
                {
                    $respuesta = $tipoPersona->consultarTodos();
                }
            }
            
            \responder($respuesta, $parametrosOk);
        }

    }
    
?>