<?php namespace Models;

    class Mail
    {

        public $email;
        public $asunto;
        public $contenido;

        function __construct()
        {

        }

        /**
         * Métodos
         */

        /**
         * Envía un correo teniendo en cuenta los datos preconfigurados para el envío de email's 
         * y los parámetros enviados con los datos del receptor y del correo
         * 
         * [
         *		'nombre' => 'Juan Camilo de las Casas'
        *		'correo' => 'juan@juan.com'
        *		'telefono' => '5458525'
        *		'asunto' => 'Solicitud de solicitudes'
        *		'mensaje' => 'Un mensaje hermoso'
        * ]
        * 
        */
        function enviar($parametros)
        {
            $respuesta = \Respuesta::obtenerDefault();

            try 
            {        
                $mail = new \PHPMailer\PHPMailer\PHPMailer;
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = MAILHOST;
                $mail->SMTPAuth = SMTPAUTH;
                $mail->Username = MAILUSER;
                $mail->setFrom(FROMEMAIL);
                $mail->Password = MAILPASSWORD;
                $mail->SMTPSecure = SMTPSECURE;
                $mail->Port = PORT;
                $mail->Timeout = TIMEOUT;
                $mail->AuthType = AUTHTYPE;
                $mail->CharSet = "UTF-8"; 
            
                /**
                 * Destinatario
                 */
                $mail->addAddress($parametros['email']);

                /**
                 * Agregar copias:
                 * 
                 * $mail->addBCC('');
                 */ 
                $mail->addReplyTo($parametros['email']);
            
                /**
                 * Contenido
                 */
                $mail->isHTML(true);                                  
                $mail->Subject = $this->asunto;
                $mail->Body = $this->contenido; 
                
                $mail->send();

                $respuesta = new \Respuesta([
                    'resultado' => true
                ]);

                return $respuesta;
            } 
            catch (\PHPMailer\PHPMailer\Exception $e) 
            {
                return $respuesta;
            }

        }

        public function consultarHtml($parametros)
        {
            $str_get = '?';
            
            foreach ($parametros as $llave => $valor) {
                $str_get .= $llave . '=' . $valor . '&';
            }

            \trim($str_get, '&');

            $respuesta = file_get_contents('Core/Controllers/EmailTemplates/Contacto.php', true);

            echo $respuesta;
        }

    }

?>