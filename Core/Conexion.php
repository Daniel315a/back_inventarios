<?php

	/**
	 * Contiene los métodos, atributos y propiedades relacionados 
	 * con la administración de la base de datos y las transacciones
	 */
	class Conexion
	{
		
		// Objeto de tipo mysqli
		private $conexion;
		private $codigo_error;
		private $error;
		public $sql;
		private $cantidad_registros;
		private $registros_afectados;
		private $id_insertado;

		/*
		 * Encapsulamiento
		 */

		public function getError() 
		{
			return $this->error;
		}

		public function getCantidadRegistros() 
		{
			return $this->cantidad_registros;
		}

		public function getRegistrosAfectados() 
		{
			return $this->registros_afectados;
		}

		public function getIdInsertado() 
		{
			return $this->id_insertado;
		}

		function __construct()
		{

		}

		/**
		 * Retorna un objeto mysqli, con los valores
		 * actuales de los atributos de esta clase
		 */
		private function initConexion()
		{
			$this->conexion = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			$this->conexion->set_charset("utf8");
		}

		public function getData($sql)
		{
			$this->initConexion();
			$this->sql = $sql;

			$resultado = $this->conexion->query($sql);
			$this->error = isset($this->conexion->error) ? $this->conexion->error : false;
			$this->cantidad_registros = isset($resultado->num_rows) ? $resultado->num_rows : 0;
			$this->conexion->close();

			if($this->cantidad_registros > 0)
			{
				$objetos = array();

				while($arr_objeto = $resultado->fetch_assoc())
				{	
					$objeto = (object) $arr_objeto;

					array_push($objetos, $objeto);
				}

				return $objetos;
			}
			else
			{
				if($this->error != false)
				{
					throw new Exception($this->error, 1);
				}

				return false;
			}
		}

		public function execCommand($sql)
		{
			$this->initConexion();
			$this->sql = $sql;

			$resultado = $this->conexion->query($sql);
			$this->error = isset($this->conexion->error) ? $this->conexion->error : false;
			$this->registros_afectados = isset($this->conexion->affected_rows) ? $this->conexion->affected_rows : false;
			$this->id_insertado = isset($this->conexion->insert_id) ? $this->conexion->insert_id : 0;
			$this->conexion->close();

			if($this->registros_afectados > 0)
			{
				return true;
			}
			else
			{
				if($this->error != false)
				{
					throw new Exception($this->error, 1);
				}

				return false;
			}
		}

	}

?>