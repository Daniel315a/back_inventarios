<?php namespace EmailTemplates;

    class Contacto
    {

        public $nombre;
        public $email;
        public $telefono;
        public $asunto;
        public $mensaje;

        /**
         * Métodos
         */

        public function obtenerTemplate()
        {
            $template = "<!DOCTYPE html>
                        <html lang=\"en\">
                        <head>
                            <meta charset=\"UTF-8\">
                            <title>Document</title>
                        </head>
                        <body>
                            <div>
                                <p>
                                    Un cliente ha solicitado una asesoría:
                                    <br>
                                    <br>
                                    <strong>Nombre:</strong> {$this->nombre} <br>
                                    <strong>Correo:</strong> {$this->email} <br>
                                    <strong>Telefono:</strong> {$this->telefono} <br>
                                    <strong>Asunto:</strong> {$this->asunto} <br>
                                    <strong>Mensaje:</strong> {$this->mensaje} <br>
                                </p>
                            </div>
                        </body>
                        </html>";
            
            return $template;
        }

    }

?>