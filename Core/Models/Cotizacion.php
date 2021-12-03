<?php namespace Models;

    class Cotizacion extends BaseModelo
    {
    
        public $id;
        public $fecha;
        public $cliente;
        public $notas;
        public $detalles;
        public $precio_total;
        public $total_iva;

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

        public function consultarPorId($id)
        {
            $this->id = $id;
            $sql = "SELECT * FROM cotizaciones WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->cliente = new \Models\Persona($datos[0]->cliente);
                $this->fecha = $datos[0]->fecha;
                $this->notas = $datos[0]->notas;
                $this->precio_total = $datos[0]->precio_total;
                $this->total_iva = $datos[0]->total_iva;
                $this->detalles = (new \Models\DetalleCotizacion())->consultarPorCotizacion($this->id);

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

            $sql = "SELECT 
                                cotizaciones.id, 
                                personas.numero_documento, 
                                cotizaciones.fecha,
                                (CASE 
                                    WHEN personas.razon_social IS NULL OR personas.razon_social = '' THEN CONCAT(personas.nombres, ' ', personas.apellidos)
                                    ELSE personas.razon_social
                                END) AS nombre
                    FROM cotizaciones 
                        LEFT JOIN personas
                            ON personas.id = cotizaciones.cliente
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

        public function crear()
        {
            $this->precio_total += $this->total_iva;

            $sql = "INSERT INTO cotizaciones
                    (
                        fecha,
                        cliente,
                        notas,
                        precio_total,
                        total_iva
                    )
                    VALUES
                    (
                        '{$this->fecha}',
                        {$this->cliente->id},
                        '{$this->notas}',
                        {$this->precio_total},
                        {$this->total_iva}
                    );";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        public function actualizar()
        {
            $this->precio_total += $this->total_iva;

            $sql = "UPDATE cotizaciones
                    SET 
                        cliente = {$this->cliente->id},
                        notas = '{$this->notas}',
                        precio_total = {$this->precio_total},
                        total_iva = {$this->total_iva}
                    WHERE id = {$this->id};";

            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }

        public function eliminar()
        {
            $sql = "DELETE FROM cotizaciones WHERE id = {$this->id};";
    
            $this->conexion->execCommand($sql);
    
            return $this->obtenerRespuesta($this, false, true);
        }

        public function consultarCsvConFiltro($texto){
            $sql = "SELECT fecha,
                            cliente.nombres,
                            cliente.apellidos,
                            cliente.razon_social,
                            notas,
                            precio_total,
                            total_iva
                    FROM cotizaciones
                        LEFT JOIN personas AS cliente
                            ON cliente.id = cotizaciones.cliente
                    WHERE CONCAT(cliente.nombres, ' ', cliente.apellidos) LIKE '%{$texto}%' OR
                            cliente.razon_social LIKE '%{$texto}%'
                    ORDER BY fecha ASC;";
            
            $resultado = $this->conexion->getData($sql);
            $respuesta = new \Respuesta();

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $encabezado = [
                    'fecha',
                    'nombres_cliente',
                    'apellidos_cliente',
                    'razon_social_cliente',
                    'notas',
                    'precio_total',
                    'total_iva'
                ];

                $nombre_archivo = 'informes/' . $dirName = date( 'YmdHis', time()) . '.xls';
                $archivo = \fopen($nombre_archivo, 'w');
                \fputs($archivo, chr(0xEF) . chr(0xBB) . chr(0xBF));
                \fputcsv($archivo, $encabezado, ';');

                foreach ($resultado as $cotizacion) {
                    \fputs($archivo, chr(0xEF) . chr(0xBB) . chr(0xBF));
                    \fputcsv($archivo, get_object_vars($cotizacion), ';');
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