<?php
namespace controladores;

class menu extends \core\Controlador {

	
	
	
	public function index(array $datos=array()) {
//		exit(__METHOD__);
		$clausulas['order_by'] = 'nombre';
		//$datos["filas"] = \modelos\categorias::select($clausulas, "categorias"); // Recupera todas las filas ordenadas
		$datos["filas"] = \modelos\Modelo_SQL::tabla("categorias")->select($clausulas); // Recupera todas las filas ordenadas
		
		return(\core\Vista::generar("menu/".__FUNCTION__, $datos));
		
	}
	
	

} // Fin de la clase