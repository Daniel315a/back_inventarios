<?php namespace Models;

    class Usuario
    {
        
        public $id;
        public $tipo;
        public $persona;
        public $nombre;
        private $contrasenna;
        public $token;
        public $permisos;
        public $empresa;

        function __construct()
        {
            if(func_num_args() > 0)
            {   
                if(is_numeric(func_get_arg(0)))
                {
                    $this->consultarPorId(func_get_arg(0));
                }
            }
        }

        /***
         * Encapsulamiento
         */

        public function setContrasenna($contrasenna)
        {
            $this->contrasenna = \md5($contrasenna);
        }

        /**
         * Métodos
         */

        public function consultarPorId($id) {
            $this->id = $id;

            $sql = "SELECT *
                    FROM usuarios
                    WHERE id = '{$this->id}';";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $permiso = new Permiso();

                $this->tipo = new TipoUsuario($datos[0]->tipo_usuario);
                $this->token = $datos[0]->token;
                $this->nombre = $datos[0]->nombre;
                $this->empresa = new Empresa($datos[0]->empresa);
                $this->persona = new Persona($datos[0]->persona);

                $permisos = $permiso->consultarPermisosTipoUsuario($datos[0]->tipo_usuario)->datos;
                $this->permisos = isset($permisos) ? $permisos : array();

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function consultarPorToken()
        {
            $sql = "SELECT *
                    FROM usuarios
                    WHERE token = '{$this->token}';";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $permiso = new Permiso();

                $this->id = $datos[0]->id;
                $this->tipo = new TipoUsuario($datos[0]->tipo_usuario);
                $this->nombre = $datos[0]->nombre;
                $this->empresa = new Empresa($datos[0]->empresa);
                $this->persona = new Persona($datos[0]->persona);

                $permisos = $permiso->consultarPermisosTipoUsuario($datos[0]->tipo_usuario)->datos;
                $this->permisos = isset($permisos) ? $permisos : array();

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function login()
        {
            $sql = "SELECT * FROM usuarios
                    WHERE nombre = '{$this->nombre}' AND contrasenna = '{$this->contrasenna}';";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $permiso = new Permiso();

                $this->id = $datos[0]->id;
                $this->tipo = new TipoUsuario($datos[0]->tipo_usuario);
                $this->nombre = $datos[0]->nombre;
                $this->contrasenna = $datos[0]->contrasenna;
                $this->token = $datos[0]->token;
                $this->empresa = new Empresa($datos[0]->empresa);
                $this->persona = new Persona($datos[0]->persona);

                $permisos = $permiso->consultarPermisosTipoUsuario($datos[0]->tipo_usuario)->datos;
                $this->permisos = isset($permisos) ? $permisos : array();

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

    }
    

?>