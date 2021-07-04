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

    }
    
?>