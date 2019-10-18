<?php
	//require_once('./Models/InventariosModel.php'); Se comenta por la funcion "AutoLoad()"
	class InventariosController
	{
		private $modelo;
		public function __construct()
		{
			// Es la relacion con la Capa que relaciona Controller con Modelo.
			$this->modelo = new InventariosModel();
		}
		public function __destruct()
		{
			unset($this);
		}

		public function set($inventarios_datos=array() )		
		{
			return $this->modelo->set($inventarios_datos);
		}

		public function get($id_refaccion='')
		{
			return $this->modelo->get($id_refaccion);
		}

		/*
		public function update($equipos_datos=array())
		{
			return $this->modelo->update($equipos_datos);
		}
		*/

		public function del($id_refaccion='')
		{
			return $this->modelo->del($id_refaccion);
		}

	}
	 
?>