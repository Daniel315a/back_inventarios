<?php namespace Controllers;

    class Departamento
    {
        
        public static function get()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $departamento = new \Models\Departamento();
            $parametrosOk = true;

            if(isset($_GET['solicitud']))
            {
                $solicitud = $_GET['solicitud'];
                
                if($solicitud == 'consultar_todos')
                {
                    $respuesta = $departamento->consultarTodos();
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }
    
?>