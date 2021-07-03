<?php

    /**
     * Ejemplo
     * 
     * Host = 'mail.grumov.com.co';
     * SMTPAuth = true;
     * Username = 'contacto@grumov.com.co';
     * Password = 'GestionGrum3ov';
     * SMTPSecure = 'ssl';
     * Port = 465;
     * Timeout = 30;
     * AuthType = 'LOGIN';
     */

    /**
     * Host de la conexión al proveedor de email
     */
    define('MAILHOST', '');

    /**
     * Determina si se hace autenticación por SMTP
     */
    define('SMTPAUTH', false);

    /**
     * Email que se va a usar para enviar correos
     */
    define('MAILUSER', '');

    /***
     * Email para mostrar al enviar el correo
     */
    define('FROMEMAIL', '');

    /**
     * Contaseña del email que se va a usar para enviar correos
     */
    define('MAILPASSWORD', '');
    
    /**
     * Determina si se habilita la encriptación de los email's enviados
     */
    define('SMTPSECURE', '');

    /**
     * Puerto de conexión al proveedor de email
     */
    define('PORT', 0);

    /**
     * Tiempo máximo de envío de un email
     */
    define('TIMEOUT', 0);

    /**
     * Tipo de autenticación con el proveedor de email
     */
    define('AUTHTYPE', '');

?>