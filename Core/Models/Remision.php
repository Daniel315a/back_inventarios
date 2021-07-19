<?php namespace Models;

    class Remision extends BaseModelo
    {
    
        public $id;
        public $factura;
        public $encargado;
        public $estado;
        public $nombre_archivo_soporte;
        public $notas;
        public $fecha_entrega;
        public $fecha_instalacion;
        public $detalles_devolucion;

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

        public function crear()
        {
            $sql = "
            INSERT INTO remisiones
            (
                factura,
                encargado,
                estado,
                notas,
                fecha_entrega,
                fecha_instalacion
            )
            VALUES
            (
                {$this->factura->id},
                {$this->encargado->id},
                0,
                '{$this->notas}',
                '{$this->fecha_entrega}',
                '{$this->fecha_instalacion}'
            );";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta($this, true, false);
        }

        public function consultarPorId()
        {
            $sql = "SELECT * 
                    FROM remisiones 
                    WHERE id = {$this->id};";

            $datos = $this->conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $this->id = $datos[0]->id;
                $this->factura = new Factura($datos[0]->factura);
                $this->encargado = new Persona($datos[0]->encargado);
                $this->estado = $datos[0]->estado;
                $this->nombre_archivo_soporte = $datos[0]->nombre_archivo_soporte;
                $this->notas = $datos[0]->notas;
                $this->fecha_entrega = $datos[0]->fecha_entrega;
                $this->fecha_instalacion = $datos[0]->fecha_instalacion;

                $respuesta_detalles = DetalleDevolucion::consultarDeRemision($this->id);

                if($respuesta_detalles->resultado)
                {
                    $this->detalles_devolucion = $respuesta_detalles->datos;
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
                        remisiones.id,
                        personas.numero_documento,
                        CASE
                            WHEN personas.razon_social IS NULL OR personas.razon_social = '' THEN CONCAT(personas.nombres, ' ', personas.apellidos)
                            ELSE personas.razon_social
                        END AS nombre_cliente,
                        encargado.numero_documento AS numero_documento_encargado,
                        CASE
                            WHEN encargado.razon_social IS NULL OR encargado.razon_social = '' THEN CONCAT(encargado.nombres, ' ', encargado.apellidos)
                            ELSE encargado.razon_social
                        END AS nombre_encargado,
                        fecha_entrega,
                        fecha_instalacion
                    FROM remisiones
                        LEFT JOIN facturas
                            ON factura = facturas.id
                        LEFT JOIN personas
                            ON facturas.cliente = personas.id
                        LEFT JOIN personas AS encargado
                            ON encargado.id = remisiones.encargado
                    WHERE personas.empresa = {$GLOBALS['usuario']->empresa->id};";

            $datos = $this->conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($this->conexion->getCantidadRegistros() > 0)
            {
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $datos
                ]);
            }

            return $respuesta;
        }

        public function actualizar()
        {
            $sql = "UPDATE remisiones
                    SET
                        encargado = {$this->encargado->id},
                        estado = {$this->estado},
                        nombre_archivo_soporte = '{$this->nombre_archivo_soporte}',
                        notas = '{$this->notas}',
                        fecha_entrega = '{$this->fecha_entrega}',
                        fecha_instalacion = '{$this->fecha_instalacion}'
                    WHERE id = {$this->id};";

            $this->conexion->execCommand($sql);

            return $this->obtenerRespuesta(null, false, true);
        }

    }
    
?>