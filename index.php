<?php

	/**
	 * Constante que determina si se está 
	 * ejecutando en depuración o producción
	 */
	define('DEBUG', true);
	
	include ('autoload.php');

	/*
	 * Entrada el Backend
	 */

  	$controlador = obtenerControlador();
    establecerCabecerasGenerales();

  	if($controlador != false)
  	{
  		$solicitudLogin = verificarSolicitudLogin();
  		$usuarioOk = $solicitudLogin ? true : verificarUsuario();

  		if($usuarioOk)
  		{
  			call_user_func($controlador . '::' . strtolower($_SERVER['REQUEST_METHOD']));
  		}
  		else
  		{
  			$respuesta = \Respuesta::obtenerDefault();
  			\Respuesta::http403($respuesta);
  			exit();
  		}
  	}
  	else
  	{
  		$respuesta = \Respuesta::obtenerDefault();
  		\Respuesta::http404($respuesta);
  		exit();
  	}

?>
