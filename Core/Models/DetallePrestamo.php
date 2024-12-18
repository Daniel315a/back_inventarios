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
            $sql = "SELECT * FROM detalles_prestamo WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->producto = new \Models\Producto($datos[0]->producto);
                $this->prestamo = new \Models\Prestamo($datos[0]->prestamo);
                $this->cantidad = $datos[0]->cantidad;

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
            
            if($conexion->getCantidadRegistros() > 0)
            {
                foreach ($datos as $detalle) {
                    $detalle->producto = new Producto($detalle->producto);
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $datos 
                ]);
            }

            return $respuesta;
        }

        function crear(){
            
            $sql = "INSERT INTO detalles_prestamo
                    (
                        producto,
                        prestamo,
                        cantidad
                    ) 
                    VALUES
                    (
                        {$this->producto->id},
                        {$this->prestamo},
                        {$this->cantidad}
                    );";

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