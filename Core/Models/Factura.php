<?php namespace Models;

    class Factura extends BaseModelo
    {
        
        public $id;
        public $consecutivo;
        public $factura;
        public $cliente;
        public $vendedor;
        public $usuario;
        public $valor_total;
        public $porcentaje_comision;
        public $valor_comision;
        public $total_descuento;
        public $detalles;
        public $anulada;

        function __construct()
        {
            parent::__construct();
            if(func_num_args() > 0)
            {   
                if(is_numeric(func_get_arg(0)))
                {
                    $this->id = func_get_arg(0);
                    $this->consultarPorId();
                }
            }
        }

        /**
         * Métodos
         */

        public function consultarPorId()
        {
            $sql = "SELECT * 
                    FROM facturas 
                    WHERE id = {$this->id};";

            $datos = $this->conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $this->id = $datos[0]->id;
                $this->consecutivo = $datos[0]->consecutivo;
                $this->factura = $datos[0]->factura;
                $this->cliente = new Persona($datos[0]->cliente);
                $this->vendedor = new Persona($datos[0]->vendedor);
                $this->usuario = $GLOBALS['usuario'];
                $this->valor_total = $datos[0]->valor_total;
                $this->porcentaje_comision = $datos[0]->porcentaje_comision;
                $this->valor_comision = $datos[0]->valor_comision;
                $this->total_descuento = $datos[0]->total_descuento;
                $this->anulada = $datos[0]->anulada;

                $respuesta_detalles = DetalleFactura::consultarDeFactura($this->id);
                
                if($respuesta_detalles->resultado)
                {
                    $this->detalles = $respuesta_detalles->datos;    
                }

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);
            }

            return $respuesta;            
        }

        public function consultarListado()
        {
            $sql = "SELECT
                        facturas.id,
                        consecutivo,
                        fecha,
                        CASE
                            WHEN personas.razon_social IS NULL OR personas.razon_social = '' THEN CONCAT(personas.nombres, ' ', personas.apellidos)
                            ELSE personas.razon_social
                        END AS nombre_cliente,
                        valor_total
                    FROM facturas
                        LEFT JOIN personas
                            ON facturas.cliente = personas.id
                    WHERE personas.empresa = {$GLOBALS['usuario']->empresa->id};";

            $datos = $this->conexion->getData($sql);

            return $this->obtenerRespuesta($datos, false, false);
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

        public function crear($detalles)
        {
            $this->consecutivo = $this->consultarConsecutivo()->datos->consecutivo;
            $this->anulada = false;

            $sql = "INSERT INTO decora_transforma.facturas
            (
                consecutivo,
                fecha,
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
                {$this->fecha},
                {$this->cliente->id},
                {$this->vendedor->id},
                {$this->usuario->id},
                {$this->valor_total},
                {$this->porcentaje_comision},
                {$this->valor_comision},
                {$this->total_descuento}
            );";

            $this->conexion->execCommand($sql);

            $respuesta = $this->obtenerRespuesta($this, true, false);

            if($respuesta->resultado)
            {
                $respuesta_detalles = \Models\DetalleFactura::crearDeFactura($detalles, $this->id);

                if($respuesta_detalles->resultado)
                {
                    $this->detalles = $respuesta_detalles->datos;
                }
            }

            $respuesta = $this->obtenerRespuesta($this, true, false);

            return $respuesta;
        }

        public function anular()
        {
            $sql = "UPDATE facturas SET anulada = true WHERE id = {$this->id};";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta(null, false, true);
        }

    }
    
?>