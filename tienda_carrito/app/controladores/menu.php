<?php
namespace controladores;

class menu extends \core\Controlador {

	
	
	
	public function index(array $datos=array()) {

		
		$clausulas['order_by'] = 'nombre';
		$datos["filas"] = \modelos\Modelo_SQL::table("categorias")->select($clausulas); // Recupera todas las filas ordenadas

		return(\core\Vista::generar("menu/".__FUNCTION__, $datos));
		
	}
	
	

} // Fin de la clase