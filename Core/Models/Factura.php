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

        // Métodos

        public function consultarPorId()
        {
            
        }

    }
    
?>