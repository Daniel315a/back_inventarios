<?php namespace Models;

    class Producto
    {
    
        public $id;
        public $empresa;
        public $referencia;
        public $detalle;
        public $cantidad_interna;
        public $cantidad_disponible;
        public $precio;
        public $habilitado;

        function __construct()
        {
            if(func_num_args() > 0)
            {
                if(is_numeric(func_get_arg(0)))
                {
                    $this->id = func_get_arg(0);
                    $this->consultarPorId();                    
                }                
            }
        }

        // Métodos

        public function crear()
        {
            $sql = "INSERT INTO decora_transforma.productos
            (
                empresa,
                referencia,
                detalle,
                cantidad_interna,
                cantidad_disponible,
                precio
            )
            VALUES
            (
                {$this->empresa->id},
                '{$this->referencia}',
                '{$this->detalle}',
                {$this->cantidad_interna},
                {$this->cantidad_disponible},
                {$this->precio}
            );";

            $conexion = new \Conexion();
            $conexion->execCommand($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getRegistrosAfectados())
            {
                
                $this->id = $conexion->getIdInsertado();
                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' => $this
                ]);

            }

            return $respuesta;
        }

        public function actualizar()
        {
            $sql = "UPDATE productos
                    SET
                        detalle = '{$this->detalle}',
                        cantidad_interna = {$this->cantidad_interna},
                        cantidad_disponible = {$this->cantidad_disponible},
                        precio = {$this->precio},
                        habilitado = {$this->habilitado}
                    WHERE id = {$this->id};";

            $conexion = new \Conexion();
            $conexion->execCommand($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getRegistrosAfectados())
            {   
                $respuesta = new \Respuesta([
                    'resultado' => true
                ]);
            }

            return $respuesta;
        }

        public function consultarPorId()
        {
            $sql = "SELECT * FROM productos 
                    WHERE id = {$this->id} AND habilitado = true;";

            $conexion = new \Conexion();
            $datos = $conexion->getData($sql);
            $respuesta = \Respuesta::obtenerDefault();

            if($conexion->getCantidadRegistros() > 0)
            {
                $this->empresa = new Empresa($datos[0]->empresa);
                $this->referencia = $datos[0]->referencia;
                $this->detalle = $datos[0]->detalle;
                $this->cantidad_interna = $datos[0]->cantidad_interna;
                $this->cantidad_disponible = $datos[0]->cantidad_disponible;
                $this->precio = $datos[0]->precio;
                $this->habilitado = $datos[0]->habilitado;

                $respuesta = new \Respuesta([
                    'resultado' => true,
                    'datos' =>  $this
                ]);
            }

            return $respuesta;
        }

    }
    
?>