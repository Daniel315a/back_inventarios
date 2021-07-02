<?php namespace Controllers;

    class Mail
    {

        public static function post()
        {
            $respuesta = \Respuesta::obtenerDefault();
            $parametrosOk = true;
            $template = $_POST['template'];
            $mail = new \Models\Mail();

            if($template == 'Contacto')
            {
                $parametrosOk = \variablesEnArreglo($_POST, [
                    'email',
                    'nombre',
                    'email_contacto',
                    'telefono',
                    'asunto',
                    'mensaje'
                ]);

                $template = new \EmailTemplates\Contacto();
                $template->nombre = $_POST['nombre'];
                $template->email = $_POST['email_contacto'];
                $template->telefono = $_POST['telefono'];
                $template->asunto = $_POST['asunto'];
                $template->mensaje = $_POST['mensaje'];

                $mail->email = $_POST['email'];
                $mail->asunto = $_POST['asunto'];
                $mail->contenido = $template->obtenerTemplate();
                $respuesta = $mail->enviar($_POST);

            }

            \responder($respuesta, $parametrosOk);
        }

    }

?>