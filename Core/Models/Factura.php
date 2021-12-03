<?php namespace Models;

    class Factura extends BaseModelo
    {
        
        public $id;
        public $consecutivo;
        public $fecha;
        public $cliente;
        public $vendedor;
        public $usuario;
        public $valor_total;
        public $porcentaje_comision;
        public $valor_comision;
        public $total_descuento;
        public $total_iva;
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
                $this->fecha = $datos[0]->fecha;
                $this->cliente = new Persona($datos[0]->cliente);
                $this->vendedor = new Persona($datos[0]->vendedor);
                $this->usuario = $GLOBALS['usuario'];
                $this->valor_total = $datos[0]->valor_total;
                $this->porcentaje_comision = $datos[0]->porcentaje_comision;
                $this->valor_comision = $datos[0]->valor_comision;
                $this->total_descuento = $datos[0]->total_descuento;
                $this->total_iva = $datos[0]->total_iva;
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
                        CONCAT(vendedor.nombres, ' ', vendedor.apellidos) AS nombre_completo_vendedor,
                        CASE
                            WHEN personas.razon_social IS NULL OR personas.razon_social = '' THEN CONCAT(personas.nombres, ' ', personas.apellidos)
                            ELSE personas.razon_social
                        END AS nombre_cliente,
                        valor_total
                    FROM facturas
                        LEFT JOIN personas
                            ON facturas.cliente = personas.id
                        LEFT JOIN personas AS vendedor
                            ON facturas.vendedor = vendedor.id
                    WHERE personas.empresa = {$GLOBALS['usuario']->empresa->id} AND anulada = 0
                    ORDER BY fecha, consecutivo ASC;";

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
                total_descuento,
                total_iva
            )
            VALUES
            (
                {$this->consecutivo},
                '{$this->fecha}',
                {$this->cliente->id},
                {$this->vendedor->id},
                {$this->usuario->id},
                {$this->valor_total},
                {$this->porcentaje_comision},
                {$this->valor_comision},
                {$this->total_descuento},
                {$this->total_iva}
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

        public function consultarConFiltro($fecha_inicial, $fecha_final, $texto)
        {
            $fecha_inicial = empty($fecha_inicial) ? '2000-01-01' : $fecha_inicial;
            $fecha_final = empty($fecha_final) ? '2050-01-01' : $fecha_final;

            $sql = "SELECT consecutivo,
                            fecha,
                            usuarios.nombre AS usuario,
                            cliente.nombres AS nombres_cliente,
                            cliente.apellidos AS apellidos_cliente,
                            cliente.razon_social AS razon_social_cliente,
                            vendedor.nombres AS nombres_vendedor,
                            vendedor.apellidos AS apellidos_vendedor,
                            valor_total,
                            porcentaje_comision,
                            valor_comision,
                            total_descuento,
                            total_iva,
                            CASE 
                                WHEN anulada IS TRUE THEN 'SÍ'
                                ELSE 'NO'
                            END AS anulada
                    FROM facturas
                        LEFT JOIN personas AS cliente
                            ON cliente.id = facturas.cliente
                        LEFT JOIN personas AS vendedor
                            ON vendedor.id = facturas.vendedor
                        LEFT JOIN usuarios
                            ON usuarios.id = facturas.usuario
                    WHERE (fecha BETWEEN '{$fecha_inicial}' AND '{$fecha_final}') AND
                            (CONCAT(cliente.nombres, cliente.apellidos) LIKE '%{$texto}%' OR
                            CONCAT(cliente.razon_social) LIKE '%{$texto}%' OR
                            CONCAT(vendedor.nombres, vendedor.apellidos) LIKE '%{$texto}%')
                    ORDER BY consecutivo ASC;";

            $resultado = $this->conexion->getData($sql);
            $respuesta = new \Respuesta();

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $encabezado = [
                    'consecutivo',
                    'fecha',
                    'usuario',
                    'nombres_cliente',
                    'apellidos_cliente',
                    'razon_social_cliente',
                    'nombres_vendedor',
                    'apellidos_vendedor',
                    'valor_total',
                    'porcentaje_comision',
                    'valor_comision',
                    'total_descuento',
                    'total_iva',
                    'anulada'
                ];

                $nombre_archivo = 'informes/' . $dirName = date( 'YmdHis', time()) . '.xls';
                $archivo = \fopen($nombre_archivo, 'w');
                \fputs($archivo, chr(0xEF) . chr(0xBB) . chr(0xBF));
                \fputcsv($archivo, $encabezado, ';');

                foreach ($resultado as $factura) {
                    \fputs($archivo, chr(0xEF) . chr(0xBB) . chr(0xBF));
                    \fputcsv($archivo, get_object_vars($factura), ';');
                }

                \fclose($archivo);

                $pdf = new \stdClass();
                $pdf->ruta = 'http://' . $_SERVER['HTTP_HOST'] . '/decora_transforma/' . $nombre_archivo;
                $respuesta->resultado = true;
                $respuesta->datos = $pdf;
            }

            return $respuesta;
        }

    }
    
?>