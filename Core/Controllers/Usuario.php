<?php namespace Controllers;

    class Usuario
    {
    
        public static function post()
        {
            $usuario = new \Models\Usuario();
            $respuesta = \Respuesta::obtenerDefault();
            $parametrosOk = true;

            if(isset($_POST['solicitud']))
            {
                $solicitud = $_POST['solicitud'];

                if($solicitud == 'login')
                {
                    $parametrosOk = \variablesEnArreglo($_POST, [
                        'nombre',
                        'contrasenna'
                    ]);

                    if($parametrosOk)
                    {
                        $usuario->nombre = $_POST['nombre'];
                        $usuario->setContrasenna($_POST['contrasenna']);
                        $respuesta = $usuario->login();
                    }
                }
            }

            \responder($respuesta, $parametrosOk);
        }

    }
    
?>