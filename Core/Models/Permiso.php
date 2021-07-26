<?php namespace Models;

    class Permiso
    {
        
        public $id;
        public $elemento; // Objeto de la clase Elemento
        public $nombre;
        public $acciones; // Lista de objetos de la clase Accion
		public $solicitud;
		public $acceso_denegado;

        function __construct()
        {

        }

        /**
         * Métodos
         */

        public function consultarPermisosUsuario($id_usuario)
        {
            $sql = "SELECT uxp.permiso AS id,
                            permisos.nombre,
                            permisos.elemento 
                    FROM usuarios_x_permisos AS uxp 
                    LEFT JOIN permisos 
                        ON uxp.permiso = permisos.id 
                    WHERE uxp.usuario = {$id_usuario};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                foreach ($datos as $permiso) {
                    $accion = new Accion();

                    $permiso->elemento = new Elemento($permiso->elemento);
                    $permiso->acciones = $accion->consultarPorPermiso($permiso->id)->datos;
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $datos
                ]);
            }

            return $respuesta;
        }

        public function consultarPermisosTipoUsuario($id_tipo_usuario)
		{
			$sql = "SELECT permisos.id,
						permisos.nombre,
						permisos.elemento AS id_elemento,
						permisos.solicitud AS id_solicitud,
						solicitudes.nombre AS nombre_solicitud,
        				solicitudes.nombre_visible AS nombre_visible_solicitud,
						permisos.acceso_denegado,
						elementos.controlador AS controlador_elemento,
						(CASE 
							WHEN get_.valor IS NOT NULL THEN get_.valor
							ELSE false
						END) AS 'get',
						(CASE 
							WHEN post.valor IS NOT NULL THEN post.valor
							ELSE false
						END) AS 'post',
						(CASE 
							WHEN put.valor IS NOT NULL THEN put.valor
							ELSE false
						END) AS 'put',
						(CASE 
							WHEN delete_.valor IS NOT NULL THEN delete_.valor
							ELSE false
						END) AS 'delete'        
				FROM permisos_x_tipos_usuario
					LEFT JOIN permisos
						ON permisos_x_tipos_usuario.permiso = permisos.id
					LEFT JOIN elementos
						ON permisos.elemento = elementos.id
					LEFT JOIN acciones AS get_
						ON permisos.id = get_.permiso AND get_.nombre = 'GET'
					LEFT JOIN acciones AS post
						ON permisos.id = post.permiso AND post.nombre = 'POST'
					LEFT JOIN acciones AS put
						ON permisos.id = put.permiso AND put.nombre = 'PUT'
					LEFT JOIN acciones AS delete_
						ON permisos.id = delete_.permiso AND delete_.nombre = 'DELETE'
					LEFT JOIN solicitudes
						ON solicitudes.id = permisos.solicitud
				WHERE permisos_x_tipos_usuario.tipo_usuario = {$id_tipo_usuario};";

			$conexion = new \Conexion();
			$data = $conexion->getData($sql);
			$respuesta = \Respuesta::obtenerDefault();

			if($conexion->getCantidadRegistros() > 0)
			{
				$permisos = array();

				foreach ($data as $permiso) {
					$obj_permiso = new Permiso();
					$obj_permiso->acceso_denegado = $permiso->acceso_denegado;
					$obj_permiso->elemento = new Elemento();
					
					$obj_permiso->id = $permiso->id;
					$obj_permiso->nombre = $permiso->nombre;
					$obj_permiso->elemento->id = $permiso->id_elemento;
					$obj_permiso->elemento->controlador = $permiso->controlador_elemento;
					
					$obj_permiso->acciones = array();

					$accion_get = new Accion();
					$accion_get->nombre = 'get';
					$accion_get->valor = (bool)$permiso->get;

					$accion_post = new Accion();
					$accion_post->nombre = 'post';
					$accion_post->valor = (bool)$permiso->post;

					$accion_put = new Accion();
					$accion_put->nombre = 'put';
					$accion_put->valor = (bool)$permiso->put;

					$accion_delete = new Accion();
					$accion_delete->nombre = 'delete';
					$accion_delete->valor = (bool)$permiso->delete;

					array_push($obj_permiso->acciones, $accion_get);
					array_push($obj_permiso->acciones, $accion_post);
					array_push($obj_permiso->acciones, $accion_put);
					array_push($obj_permiso->acciones, $accion_delete);

					if(isset($permiso->id_solicitud))
					{
						$obj_permiso->solicitud = new Solicitud();
					
						$obj_permiso->solicitud->id = $permiso->id_solicitud;
						$obj_permiso->solicitud->nombre = $permiso->nombre_solicitud;
						$obj_permiso->solicitud->nombre_visible = $permiso->nombre_visible_solicitud;
					}
					
					array_push($permisos, $obj_permiso);
				}

				$respuesta = new \Respuesta([
					'datos' => $permisos,
					'resultado' => true
				]);
			}

			return $respuesta;
		}

    }
    
?>