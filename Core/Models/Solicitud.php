<?php namespace Models;

    class Solicitud extends BaseModelo
    {
        
        public $id;
        public $nombre;
        public $nombre_visible;
        private $elemento; // Se establece como privado para que no aparezca al consultar el listado de permisos, pero es necesario para crear solicitudes

        function __construct()
        {

        }

        /**
         * Métodos
         */

    }
    
?>