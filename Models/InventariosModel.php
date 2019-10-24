<?php
	// Antes este archivo se encontraba en la carpeta de "Marcas", ahora estan en el mismo nivel
	// require_once('./Models/Model.php');
	// require_once('Model.php'); Se comenta por la funcion "AutoLoad()"
	class InventariosModel extends Model
	{
		//public $id_epo;
    //public $num_serie; 
    // ........ 


		public function __construct()
		{
			// Si se conectaran a mas de una base de datos, es aqui donde se define.
			$this->db_name = 'ordenservicios';			
		}

		public function __destruct()
		{
			//unset($this);
		}

		// Recibe un arreglo la funcion.
		//public function create($equipos_datos=array() )		
		public function set($inventarios_datos=array() )		
		{
			foreach ($inventarios_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "REPLACE INTO t_Refaccion (id_refaccion,descripcion,num_parte,existencia,fecha,id_marca,id_modelo,observaciones) VALUES ($id_refaccion,'$descripcion','$num_parte',$existencia,'$fecha',$id_marca,$id_modelo,'$observaciones')";
			
			// Insertando el valor nuevo.
			$this->set_query(); 
		}
		// Si "$id_epo" esta vacio, le asigna espacio en blanco
		public function get($id_refaccion='')
		{				
			// Se coloca en comillas para que tome el valor de la variable "$id_epo"
			$this->query = ($id_refaccion != '')
			?"SELECT inv.id_refaccion,inv.descripcion,inv.num_parte,inv.existencia,inv.fecha,inv.id_marca,marca.descripcion AS marca,inv.id_modelo,modelo.descripcion AS modelo,inv.observaciones FROM t_Refaccion AS inv 
      INNER JOIN t_Marca AS marca ON inv.id_marca = marca.id_marca
      INNER JOIN t_Modelo AS modelo ON inv.id_modelo = modelo.id_modelo      
      WHERE inv.id_refaccion = $id_refaccion"
      :"SELECT inv.id_refaccion,inv.descripcion,inv.num_parte,inv.existencia,inv.fecha,inv.id_marca,marca.descripcion AS marca,inv.id_modelo,modelo.descripcion AS modelo,inv.observaciones FROM t_Refaccion AS inv 
      INNER JOIN t_Marca AS marca ON inv.id_marca = marca.id_marca
      INNER JOIN t_Modelo AS modelo ON inv.id_modelo = modelo.id_modelo";

/*
				if ($id_epo != '')
				{
					$sql = "SELECT * FROM t_Equipo WHERE id_epo = $id_epo";
				}
				else
				{
					$sql = "SELECT * FROM t_Equipo";
				}
			*/ 
			//Ejecuta la consulta y la retorna en un arreglo.
			$this->get_query();
			// var_dump() = Convertir a cadena de texto el contenido de un objeto
			//var_dump($this->rows);
			
			// Se agrega código para mostrar en pantalla en forma de tabla la información que se obtuvo.
			// Obteniendo el numero de elementos del arreglo
			// $num_renglones = count($this->rows);
			$datos = array();
			// Permite recorrer el arreglo de una forma optimizada.
			// $this->rows = Es el arreglo a recorrer.
			//https://www.php.net/manual/es/control-structures.foreach.php
			// Arreglo Asociativo es "$this->rows"
			foreach ($this->rows as $Campo => $Valor)
			{
				// Agrega al final del arreglo el valor de la interacción
				array_push($datos,$Valor);
				//$datos[$Campo] = $Valor;
			}			
			
			return $datos;
		}

/* Se desactiva por la instrucción REPLACE (funcion set)

	public function update($marca_datos=array())
		{
			foreach ($marca_datos as $Campo => $Valor)
			{
				// Se crea dinamicamente una palabra, se convierta una variable "$Campo"
				// $$Campo = Variable Variable, se convierte en variable dinámica.
				//https://www.php.net/manual/es/language.variables.variable.php
				// El nombre de la posicion, del arreglo la convierte a una variable para utilizar para  generar la consulta.
				$$Campo = $Valor;
 
			}			

			// Se utiliza comillas, porque se utilizaran las comillas.
			$this->query= "UPDATE t_Marca SET id_marca = $id_marca,descripcion = '$descripcion' WHERE id_marca = $id_marca";
			
			$this->set_query(); 

		}
	*/

		// Si no se manda parámetro, le asigna en blanco
		public function del($id_refaccion='')
		{
			$this->query= "DELETE FROM t_Refaccion WHERE id_refaccion = $id_refaccion";
			$this->set_query();
		}

	}
?>