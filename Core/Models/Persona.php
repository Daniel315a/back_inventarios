<?php namespace Models;

    class Persona extends BaseModelo
    {
    
        public $id;
        public $municipio;
        public $tipo;
        public $empresa;
        public $tipo_documento;
        public $numero_documento;
        public $nombres;
        public $apellidos;
        public $razon_social;
        public $direccion;
        public $telefono;
        public $email;
        public $habilitada;

        function __construct(){
            parent::__construct();
            if(func_num_args() > 0)
            {   
                if(is_numeric(func_get_arg(0)))
                {
                    $this->consultarPorId(func_get_arg(0));
                }
            }
        }

        public function consultarPorId($id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM personas WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->municipio = new \Models\Municipio($datos[0]->municipio);
                $this->tipo = new \Models\TipoPersona($datos[0]->tipo);
                $this->empresa = new \Models\Empresa($datos[0]->empresa);
                $this->tipo_documento = new \Models\TipoDocumento($datos[0]->tipo_documento);
                $this->numero_documento = $datos[0]->numero_documento;
                $this->nombres = $datos[0]->nombres;
                $this->apellidos = $datos[0]->apellidos;
                $this->razon_social = $datos[0]->razon_social;
                $this->direccion = $datos[0]->direccion;
                $this->telefono = $datos[0]->telefono;
                $this->email = $datos[0]->email;
                $this->habilitada = $datos[0]->habilitada;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function consultarPorMumeroDocumento($numero_documento)
        {
            $this->numero_documento = $numero_documento;
            $sql = "SELECT * FROM personas WHERE numero_documento = {$this->numero_documento};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->id = $datos[0]->id;
                $this->municipio = new \Models\Municipio($datos[0]->municipio);
                $this->tipo = new \Models\TipoPersona($datos[0]->tipo);
                $this->empresa = new \Models\Empresa($datos[0]->empresa);
                $this->tipo_documento = new \Models\TipoDocumento($datos[0]->tipo_documento);
                $this->nombres = $datos[0]->nombres;
                $this->apellidos = $datos[0]->apellidos;
                $this->razon_social = $datos[0]->razon_social;
                $this->direccion = $datos[0]->direccion;
                $this->telefono = $datos[0]->telefono;
                $this->email = $datos[0]->email;
                $this->habilitada = $datos[0]->habilitada;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function consultarPorEmpresa($empresa)
        {
            $sql = "SELECT * FROM personas WHERE empresa = {$empresa} AND habilitada = 1;";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $personas = array();

                for ($i=0; $i < count($datos) ; $i++) { 
                    $persona = new \Models\Persona();

                    $persona->id = $datos[$i]->id;
                    $persona->municipio = new \Models\Municipio($datos[$i]->municipio);
                    $persona->tipo = new \Models\TipoPersona($datos[$i]->tipo);
                    $persona->empresa = new \Models\Empresa($datos[$i]->empresa);
                    $persona->tipo_documento = new \Models\TipoDocumento($datos[$i]->tipo_documento);
                    $persona->numero_documento = $datos[0]->numero_documento;
                    $persona->nombres = $datos[$i]->nombres;
                    $persona->apellidos = $datos[$i]->apellidos;
                    $persona->razon_social = $datos[$i]->razon_social;
                    $persona->direccion = $datos[$i]->direccion;
                    $persona->telefono = $datos[$i]->telefono;
                    $persona->email = $datos[$i]->email;
                    $persona->habilitada = $datos[$i]->habilitada;

                    array_push($personas, $persona);
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $personas
                ]);
            }

            return $respuesta;
        }

        public function consultarPorTipo($empresa, $tipo)
        {
            $sql = "SELECT * FROM personas WHERE  empresa = {$empresa} AND tipo = {$tipo} AND habilitada = 1;";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $personas = array();

                for ($i=0; $i < count($datos) ; $i++) { 
                    $persona = new \Models\Persona();

                    $persona->id = $datos[$i]->id;
                    $persona->municipio = new \Models\Municipio($datos[$i]->municipio);
                    $persona->tipo = new \Models\TipoPersona($datos[$i]->tipo);
                    $persona->empresa = new \Models\Empresa($datos[$i]->empresa);
                    $persona->tipo_documento = new \Models\TipoDocumento($datos[$i]->tipo_documento);
                    $persona->numero_documento = $datos[0]->numero_documento;
                    $persona->nombres = $datos[$i]->nombres;
                    $persona->apellidos = $datos[$i]->apellidos;
                    $persona->razon_social = $datos[$i]->razon_social;
                    $persona->direccion = $datos[$i]->direccion;
                    $persona->telefono = $datos[$i]->telefono;
                    $persona->email = $datos[$i]->email;
                    $persona->habilitada = $datos[$i]->habilitada;

                    array_push($personas, $persona);
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $personas
                ]);
            }

            return $respuesta;
        }

        public function consultarPorTipoEmpleado($empresa)
        {
            $sql = "SELECT * 
            FROM personas 
            LEFT JOIN tipos_persona
                ON personas.tipo = tipos_persona.id
            WHERE  empresa = {$empresa} AND habilitada = 1 AND es_empleado = 1;";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $personas = array();

                for ($i=0; $i < count($datos) ; $i++) { 
                    $persona = new \Models\Persona();

                    $persona->id = $datos[$i]->id;
                    $persona->municipio = new \Models\Municipio($datos[$i]->municipio);
                    $persona->tipo = new \Models\TipoPersona($datos[$i]->tipo);
                    $persona->empresa = new \Models\Empresa($datos[$i]->empresa);
                    $persona->tipo_documento = new \Models\TipoDocumento($datos[$i]->tipo_documento);
                    $persona->numero_documento = $datos[0]->numero_documento;
                    $persona->nombres = $datos[$i]->nombres;
                    $persona->apellidos = $datos[$i]->apellidos;
                    $persona->razon_social = $datos[$i]->razon_social;
                    $persona->direccion = $datos[$i]->direccion;
                    $persona->telefono = $datos[$i]->telefono;
                    $persona->email = $datos[$i]->email;
                    $persona->habilitada = $datos[$i]->habilitada;

                    array_push($personas, $persona);
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $personas
                ]);
            }

            return $respuesta;
        }

        function crear(){
            
            $sql = "INSERT INTO personas(
                municipio,
                tipo,
                empresa,
                tipo_documento,
                numero_documento,
                nombres,
                apellidos,
                razon_social,
                direccion,
                telefono,
                email,
                habilitada
            ) VALUES({$this->municipio->id},
            {$this->tipo->id},
            {$this->empresa->id},
            {$this->tipo_documento->id},
            '{$this->numero_documento}',
            '{$this->nombres}',
            '{$this->apellidos}',
            '{$this->razon_social}',
            '{$this->direccion}',
            '{$this->telefono}',
            '{$this->email}',
            {$this->habilitada})";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        function actualizar(){
            $sql = "UPDATE personas
                    SET municipio = {$this->municipio->id},
                        tipo = {$this->tipo->id},
                        empresa = {$this->empresa->id},
                        tipo_documento = {$this->tipo_documento->id},
                        numero_documento = '{$this->numero_documento}',
                        nombres = '{$this->nombres}',
                        apellidos = '{$this->apellidos}',
                        razon_social = '{$this->razon_social}',
                        direccion = '{$this->direccion}',
                        telefono = '{$this->telefono}',
                        email = '{$this->email}',
                        habilitada = {$this->habilitada}
                    WHERE id = {$this->id};";

            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }
    
        function eliminar(){
            $sql = "UPDATE personas
            SET habilitada = false
            WHERE id = {$this->id};;";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }

    }
    
?>