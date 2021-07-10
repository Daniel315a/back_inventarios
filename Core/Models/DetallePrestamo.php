<?php namespace Models;

    class DetallePrestamo extends BaseModelo
    {
    
        public $id;
        public $producto;
        public $prestamo;
        public $cantidad;

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

        public function consultarPorPrestamo($idPrestamo)
        {
            $sql = "SELECT *
            FROM detalles_prestamo 
            WHERE prestamo = {$idPrestamo};";
            

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();
            $listaDetalles = array();

            if($conexion->getCantidadRegistros() > 0)
            {
                $listaDetalles = $datos;
            }

            return $listaDetalles;
        }

        function crear(){
            
            $sql = "INSERT INTO detalles_prestamo(
                producto,
                prestamo,
                cantidad
            ) VALUES({$this->producto},
            {$this->prestamo},
            {$this->cantidad})";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        function eliminar(){
            $sql = "DELETE FROM detalles_prestamo WHERE id = {$this->id};";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }
        
        function eliminarPorPrestamo($idPrestamo){
            $sql = "DELETE FROM detalles_prestamo WHERE prestamo = {$idPrestamo};";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }

    }
    
?>