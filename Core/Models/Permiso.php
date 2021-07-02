<?php namespace Models;

    class Permiso
    {
        
        public $id;
        public $elemento; // Objeto de la clase Elemento
        public $nombre;
        public $acciones; // Lista de objetos de la clase Accion

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


    }
    
?>