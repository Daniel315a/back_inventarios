<?php namespace Models;

    class Factura extends BaseModelo
    {
        
        public $id;
        public $consecutivo;
        public $cliente;
        public $vendedor;
        public $usuario;
        public $valor_total;
        public $porcentaje_comision;
        public $valor_comision;
        public $total_descuento;
        public $anulada;

        function __construct()
        {
            parent::__construct();
            if(func_num_args() > 0)
            {   
                if(is_numeric(func_get_arg(0)))
                {
                    $this->consultarPorId(func_get_arg(0));
                }
            }
        }

        /**
         * Métodos
         */

        public function consultarPorId()
        {

        }

        public function consultarConsecutivo()
        {
            $sql = "SELECT consecutivo 
                    FROM facturas
                    ORDER BY consecutivo DESC
                    LIMIT 1;";

            $datos = $this->conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();
            $consecutivo = new \stdClass();
            $consecutivo->consecutivo = 1;

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $consecutivo->consecutivo = $datos[0]->consecutivo + 1;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $consecutivo
                ]);
            }
            else
            {
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $consecutivo
                ]);
            }

            return $respuesta;
        }

        public function crear()
        {
            $this->consecutivo = $this->consultarConsecutivo()->datos->consecutivo;
            $this->anulada = false;

            $sql = "INSERT INTO decora_transforma.facturas
            (
                consecutivo,
                cliente,
                vendedor,
                usuario,
                valor_total,
                porcentaje_comision,
                valor_comision,
                total_descuento
            )
            VALUES
            (
                {$this->consecutivo},
                {$this->cliente->id},
                {$this->vendedor->id},
                {$this->usuario->id},
                {$this->valor_total},
                {$this->porcentaje_comision},
                {$this->valor_comision},
                {$this->total_descuento}
            );";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

    }
    
?>