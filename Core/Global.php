<?php

	/**
	 * Variables globales del archivo
	 */
	$GLOBALS['parametros_faltantes'] = array();

	function verificarUsuario()
	{
		$accesoOk = false;
  		$usuario = new \Models\Usuario();
  		$usuario->token = obtenerTokenLoginWs();
  		$usuarioOk = $usuario->consultarPorToken()->resultado;
  		$controlador = obtenerControlador(true);
  		$peticion = strtolower($_SERVER['REQUEST_METHOD']);

  		if($usuarioOk)
  		{
  			$accesoOk = verificarPermisosUsuario($usuario, $controlador);
  		}

  		return $accesoOk;
	}

	function verificarPermisosUsuario($usuario, $controlador)
	{
		$permisos = $usuario->permisos;
		$tienePermiso = false;

		foreach ($permisos as $permiso) 
		{
			if($permiso->elemento->controlador == $controlador)
			{
				$acciones = $permiso->acciones;

				foreach ($acciones as $accion) 
				{
					if(strtolower($_SERVER['REQUEST_METHOD']) == $accion->nombre)
					{
						$tienePermiso = $accion->valor;
					}	
				}
			}
		}

		return $tienePermiso;
	}

	function verificarSolicitudLogin()
	{
		$solicitud = null;

		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$solicitud = isset($_GET['solicitud']) ? $_GET['solicitud'] : null;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$solicitud = isset($_POST['solicitud']) ? $_POST['solicitud'] : null;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'PUT')
		{
			$_PUT = _PUT();
			$solicitud = isset($_PUT['solicitud']) ? $_PUT['solicitud'] : null;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'DELETE')
		{
			$_DELETE = _DELETE();
			$solicitud = isset($_DELETE['solicitud']) ? $_DELETE['solicitud'] : null;
		}

		if($solicitud == 'login')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function obtenerTokenLoginWs()
	{
		$token = null;

		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$token = isset($_GET['token']) ? $_GET['token'] : null;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$token = isset($_POST['token']) ? $_POST['token'] : null;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'PUT')
		{
			$_PUT = _PUT();
			$token = isset($_PUT['token']) ? $_PUT['token'] : null;
		}
		else if($_SERVER['REQUEST_METHOD'] == 'DELETE')
		{
			$_DELETE = _DELETE();
			$token = isset($_DELETE['token']) ? $_DELETE['token'] : null;
		}

		if($token == null)
		{
			array_push($GLOBALS['parametros_faltantes'], 'token');
			responder(\Respuesta::obtenerDefault(), false);
		}

		return $token;
	}

	/*
	 * Comprueba que una lista de variables estén presentes en un arreglo asociativo
	 *
	 * Parámetros:
	 * $arreglo: arreglo asociativo que se desea verificar
	 * $nombres_variables: arreglo con los nombres de las posiciones que se van a revisar en el $arreglo
	 *
	 * Retorno:
	 * true: si todas las variables están presentes en $arreglo
	 * false: si alguna variable NO está presente en $arreglo
	 */
	function variablesEnArreglo($arreglo, $nombres_variables)
	{
		$variables_encontradas = true;

		foreach ($nombres_variables as $nombre_variable) {
			
			if(isset($arreglo[$nombre_variable]) == false)
			{
				array_push($GLOBALS['parametros_faltantes'], $nombre_variable);
				$variables_encontradas = false;
			}
			
		}

		return $variables_encontradas;
	}

	function responder($respuesta, $parametrosOk)
	{

		if($parametrosOk == false)
		{
			$respuesta = new \Respuesta([
				'resultado' => false,
				'datos' => $GLOBALS['parametros_faltantes'],
				'mensaje' => ERROR_PARAMETROS
			]);
		}

		if(isset($respuesta->resultado))
		{
			\Respuesta::http200($respuesta);
			exit();
		}
	}

	/**
	 * Retorna el token de una petición por el método DELETE
	 */
	function _DELETE($clave = '')
	{
		$parametros = obtenerParametrosUrl();

		if(empty($clave))
		{
			return $parametros;
		}

		if (isset($parametros[$clave]))
		{
			return $parametros[$clave];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Retorna el valor de un parámetro recibiendo la clave
	 * si no se recibe nada, se retorna todo el arreglo de parámetros
	 */
	function _PUT($clave = '')
	{
		$parametros = obtenerParametrosUrl();

		if(empty($clave))
		{
			return $parametros;
		}

		if (isset($parametros[$clave]))
		{
			return $parametros[$clave];
		}
		else
		{		
			return null;
		}
	}

	/**
	 * Retorna arreglo de parámetros URLEncode
	 */
	function obtenerParametrosUrl()
	{
		$datos_put = fopen('php://input', "r");
		$url = fread($datos_put, 1024);
		$url = urldecode($url);
		$parametros = array();
		$arr_url = explode('&', $url);
		
		if(count($arr_url) > 0 &&
			!empty($arr_url[0]))
		{
			foreach ($arr_url as $str_parametro) 
			{
				$parametro = explode('=', $str_parametro);
				$parametros[$parametro[0]] = $parametro[1];
			}
		}

		return $parametros;
	}

	/**
	 * Retorna un controlador teniendo en cuenta
	 * los parámetros de la URI actual
	 */
	function obtenerControlador($soloNombre = false)
	{
		$url = explode('?', $_SERVER['REQUEST_URI']);
		$arr_uri = explode('/', $url[0]);
		$controlador = 'Controllers\\' . end($arr_uri);
		$ruta_controlador = 'Core/' . obtenerNombreArchivo($controlador) . '.php';

		/*
		 * Si sólo se requiere el nombre de la petición
		 */
		if($soloNombre)
		{
			return end($arr_uri);
		}

		/*
		 * Si el archivo del controlador no existe
		 */
		if(!is_readable($ruta_controlador))
		{
			return false;
		}

		return $controlador;
	}

	/**
	 * Establece las cabeceras necesarias
	 * en todos los controlador de la app
	 */
	function establecerCabecerasGenerales()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Allow: GET, POST, OPTIONS, PUT, DELETE");
		header('Content-Type: application/json; charset=utf-8');
	}

	/**
	 * Recibe todos los errores NO CRÍTICOS que se prensentan 
	 * en el sistema y les da formato con la clase Respuesta
	 */
	function errorHandler($errno, $errstr, $errfile, $errline)
	{
		$constantes = get_defined_constants(true)['Core'];
		$errno = obtenerNombreConstanteError($errno);

		$respuesta = new Respuesta([
			'mensaje_tecnico' => $errno . ': ' . $errstr,
		]);

		if(DEBUG == true)
		{
			$respuesta->informacion_adicional = [
				'Archivo' => $errfile, 
				'Línea' => $errline
			];
		}

		Respuesta::http500($respuesta);
		exit(1);
	}

	/**
	 * Recibe todos los errores CRÍTICOS que se prensentan 
	 * en el sistema y les da formato con la clase Respuesta
	 */
	function fatalErrorHandler()
	{
		$error = error_get_last();

	    if( $error !== null) 
	    {
	        $errno = obtenerNombreConstanteError($error["type"]);
	        $archivo = $error["file"];
	        $linea = $error["line"];
	        $errstr = preg_replace("/[\r\n|\n|\r|\t]+/", '',$error['message']);
	        $arr_error = explode('Stack trace:', $errstr);
	        $errstr = $arr_error[0];
	        $pila_llamadas = count($arr_error) > 1 ? explode('#', $arr_error[1]) : null;
	        unset($pila_llamadas[0]);

			$respuesta = new Respuesta([]);

			if(DEBUG == true)
			{
				$respuesta->mensaje_tecnico = $errno . ': ' . $errstr;
				$respuesta->informacion_adicional = [
					'Archivo' => $archivo, 
					'Línea' => $linea
				];
				$respuesta->pila_llamadas = $pila_llamadas;
			}

			Respuesta::http500($respuesta);
			exit(1);
	    }
	}

	/**
	 * Retorna el nombre de una constante de 
	 * error de las definidas en las constantes
	 * del core, recibe el valor de la constante
	 * por el parámetro $errno
	 */
	function obtenerNombreConstanteError($errno)
	{
       	$constantes = get_defined_constants(true)['Core'];
       	$nombre_constante = '';

		foreach ( $constantes as $nombre => $valor )
        {
            if ($valor == $errno)
            {
                $nombre_constante = $nombre;
                break;
            }
        }

        return $nombre_constante;
	}


?>