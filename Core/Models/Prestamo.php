<?php namespace Models;

    class Prestamo extends BaseModelo
    {
    
        public $id;
        public $distribuidor;
        public $empleado;
        public $fecha_prestamo;
        public $fecha_devolucion;

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
            $sql = "SELECT * FROM prestamos WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->distribuidor = new \Models\Persona($datos[0]->distribuidor);
                $this->empleado = new \Models\Persona($datos[0]->empleado);
                $this->fecha_prestamo = $datos[0]->fecha_prestamo;
                $this->fecha_devolucion = $datos[0]->fecha_devolucion;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function consultarPorEmpresa($idEmpresa)
        {
            $empresa = 0;
            if(isset($GLOBALS['usuario'])){
                $empresa = $GLOBALS['usuario']->empresa->id;
            }else{
                $empresa = $idEmpresa;
            }

            $sql = "SELECT prestamos.id, personas.numero_documento, 
                personas.nombres, personas.apellidos, prestamos.fecha_prestamo, prestamos.fecha_devolucion
            FROM prestamos 
                LEFT JOIN personas
                    ON personas.id = prestamos.distribuidor
            WHERE empresa = {$empresa};";
            

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $datos
                ]);
            }

            return $respuesta;
        }

        function crear(){
            
            $sql = "INSERT INTO prestamos(
                distribuidor,
                empleado,
                fecha_prestamo,
                fecha_devolucion
            ) VALUES({$this->distribuidor->id},
            {$this->empleado->id},
            ". ModelosUtil::verificarNull($this->fecha_prestamo, false).",
            ". ModelosUtil::verificarNull($this->fecha_devolucion, false).")";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        function eliminar(){
            $sql = "DELETE FROM prestamos WHERE id = {$this->id};";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }

    }
    
?>