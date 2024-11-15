<?php namespace Models;

    class DetalleCotizacion extends BaseModelo
    {
    
        public $id;
        public $cotizacion;
        public $producto;
        public $cantidad;
        public $descripcion;
        public $precio_unitario;
        public $porcentaje_iva;
        public $valor_iva;
        public $precio_total;

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
            $sql = "SELECT * FROM detalles_cotizacion WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->cotizacion = new \Models\Cotizacion($datos[0]->cotizacion);
                $this->producto = new \Models\Producto($datos[0]->producto);
                $this->cantidad = $datos[0]->cantidad;
                $this->descripcion = $datos[0]->descripcion;
                $this->precio_total = $datos[0]->precio_total;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;
        }

        public function consultarPorCotizacion($idCotizacion)
        {
            $sql = "SELECT *
                    FROM detalles_cotizacion 
                    WHERE cotizacion = {$idCotizacion};";
            

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();
            $listaDetalles = array();

            if($conexion->getCantidadRegistros() > 0)
            {
                foreach ($datos as $detalle) {
                    $detalle->producto = new \Models\Producto($detalle->producto);
                    array_push($listaDetalles, $detalle);
                }
            }

            return $listaDetalles;
        }

        function crear(){
            
            $this->precio_total = $this->precio_unitario * $this->cantidad;
            $this->valor_iva = round($this->precio_total * ($this->porcentaje_iva / 100), 2);
            $this->precio_total += $this->valor_iva;

            $sql = "INSERT INTO detalles_cotizacion(
                        cotizacion,
                        producto,
                        cantidad,
                        descripcion,
                        precio_unitario,
                        porcentaje_iva,
                        valor_iva,
                        precio_total
                    ) 
                    VALUES
                    (
                        {$this->cotizacion},
                        {$this->producto->id},
                        {$this->cantidad},
                        '{$this->descripcion}',
                        {$this->precio_unitario},
                        {$this->porcentaje_iva},
                        {$this->valor_iva},
                        {$this->precio_total}
                    )";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        function eliminar(){
            $sql = "DELETE FROM detalles_cotizacion WHERE id = {$this->id};";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }
        
        function eliminarPorCotizacion($idCotizacion){
            $sql = "DELETE FROM detalles_cotizacion WHERE cotizacion = {$idCotizacion};";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }

    }
    
?>