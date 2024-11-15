<?php

	/*
	 * Zona horaria
	 */ 
	date_default_timezone_set('America/Bogota');

	require_once ('Core/Global.php');
	require_once ('Core/config_conexion.php');
	require_once ('Core/config_mail.php');
	require_once ('Core/Respuesta.php');
	require_once ('Core/srcmailer/Exception.php');
    require_once ('Core/srcmailer/PHPMailer.php');
    require_once ('Core/srcmailer/SMTP.php');

	/**
 	 * Se establece el manejador de errores
	 */
	// error_reporting(0);
	// set_error_handler('errorHandler');
	// register_shutdown_function('fatalErrorHandler');

	spl_autoload_register(function($clase)
	{
		/*
		 * Esta variable define el namespace de la llamada
		 */
		$peticion = explode('\\', $clase)[0];
		$ruta = 'Core/' . obtenerNombreArchivo($clase) . '.php';

		if(is_readable($ruta))
		{
			require_once($ruta);
		}

	});

	function obtenerNombreArchivo($clase)
	{
		return str_replace('\\', '/', $clase);
	}

?>