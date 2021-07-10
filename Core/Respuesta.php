<?php

	/*
	 * Mensajes pre-definidos
	 */

	define('RECURSO_INEXISTENTE', 'El recurso solicitado no existe');
	define('FALLO_INTERPRETACION', 'No se pudo interpretar la solicitud');
	define('ACCESO_DENEGADO', 'Se denegó el acceso a la solicitud');
	define('ERROR_INTERNO', 'Se produjo un error interno');
	define('SOLICITUD_OK', 'La solicitud se ha procesado correctamente');
	define('ERROR_PARAMETROS', 'Los parámetros enviados no coinciden con la solicitud');	

	/**
	 * Contiene atributos, métodos y propiedades que permiten 
	 * estandarizar las respuestas dentro de la aplicación
	 */
	class Respuesta
	{		

		/**
		 * Constructores
		 */

		/**
		 * Descipción de parámetros por arreglo
		 * 
		 * [
		 *	'resultado' => value // (Boolean)
		 *	'datos' => value
		 *	'codigo_http' => value,
		 *	'mensaje' => value,
		 *	'mensaje_tecnico' => value,
		 *	'informacion_adicional' => value
		 * ]
		 */
		public function __construct()
		{
			if(func_num_args() > 0)
			{
				if(func_get_arg(0) != null)
				{
					$this->establecerParametrosConstructor(func_get_arg(0));
				}
			}
		}

		/**
		 * Métodos
		 */

		/**
		 * Recibe el arreglo de parámetros del constructor 
		 * y establece los valores de los atributos 
		 * si están inicializados
		 */
		private function establecerParametrosConstructor($parametros)
		{
			if(is_array($parametros))
			{
				if(count($parametros) > 0)
				{
					// Se verifica si cada parámetro existe antes de asignarlo

					if(isset($parametros['resultado']))
					{
						$this->resultado = $parametros['resultado'];
					}

					if(isset($parametros['datos']))
					{
						$this->datos = $parametros['datos'];

						// Si los datos recibidos están en null, se asigna un array vacío
						if($this->datos == null)
						{
							$this->datos = array();
						}
					}

					if(isset($parametros['mensaje']) && $parametros['mensaje'] != null && !empty($parametros['mensaje']))
					{
						$this->mensaje = $parametros['mensaje'];
					}

					if(isset($parametros['mensaje_tecnico']) && $parametros['mensaje_tecnico'] != null && !empty($parametros['mensaje_tecnico']))
					{
						$this->mensaje_tecnico = $parametros['mensaje_tecnico'];
					}

					if(isset($parametros['informacion_adicional']) && $parametros['informacion_adicional'] != null)
					{
						$this->informacion_adicional = $parametros['informacion_adicional'];
					}

				}
			}
		}

		/**
		 * Métodos estáticos
		 */

		/**
		 * Crea una respuesta con los parámetros recibidos,
		 * y la retorna para utilizarla posteriormente en una
		 * respuesta http
		 */
		public static function obtener($resultado, $mensaje, $datos)
		{
			$parametros = [
				'resultado' => $resultado,
				'mensaje' => $mensaje,
				'datos' => $datos
			];

			return new Respuesta($parametros);
		}

		/**
		 * Retorna una instancia de la clase Respuesta con
		 * el atributo $resultado en false
		 */
		public static function obtenerDefault()
		{
			$parametros = [
				'resultado' => false
			];

			return new Respuesta($parametros);
		}

		public static function http404($respuesta)
		{
			http_response_code(404);
			$respuesta->codigo_http = http_response_code();

			if(!isset($respuesta->mensaje))
			{
				$respuesta->mensaje = RECURSO_INEXISTENTE;
			}

			echo json_encode($respuesta);

			return $respuesta;
		}

		public static function http400($respuesta)
		{
			http_response_code(400);
			$respuesta->codigo_http = http_response_code();

			if(!isset($respuesta->mensaje))
			{
				$respuesta->mensaje = FALLO_INTERPRETACION;
			}

			echo json_encode($respuesta);

			return $respuesta;
		}

		public static function http403($respuesta)
		{
			http_response_code(403);
			$respuesta->codigo_http = http_response_code();

			if(!isset($respuesta->mensaje))
			{
				$respuesta->mensaje = ACCESO_DENEGADO;
			}

			echo json_encode($respuesta);

			return $respuesta;
		}

		public static function http500($respuesta)
		{
			http_response_code(500);
			$respuesta->codigo_http = http_response_code();

			if(!isset($respuesta->mensaje))
			{
				$respuesta->mensaje = ERROR_INTERNO;
			}

			echo json_encode($respuesta);

			return $respuesta;
		}

		public static function http200($respuesta)
		{
			http_response_code(200);
			$respuesta->codigo_http = http_response_code();

			if(!isset($respuesta->mensaje))
			{
				$respuesta->mensaje = SOLICITUD_OK;
			}

			echo json_encode($respuesta, JSON_NUMERIC_CHECK );

			return $respuesta;
		}

	}

?>