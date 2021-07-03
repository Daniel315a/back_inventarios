<?php namespace Models;

    class Usuario
    {
        
        public $id;
        public $nombre;
        private $contrasenna;
        public $token;
        public $permisos;
        

        function __construct()
        {

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
                $this->nombre = $datos[0]->nombre;
                $this->permisos = $permiso->consultarPermisosUsuario($this->id)->datos;

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
                $this->nombre = $datos[0]->nombre;
                $this->contrasenna = $datos[0]->contrasenna;
                $this->token = $datos[0]->token;
                $this->permisos = isset($permiso->consultarPermisosUsuario($this->id)->datos) ? $permiso->consultarPermisosUsuario($this->id)->datos : array();

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

    }
    

?>