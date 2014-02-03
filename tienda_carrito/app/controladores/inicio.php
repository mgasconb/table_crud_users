<?php
namespace controladores;

class inicio extends \core\Controlador {
	

	public function index(array $datos = array()) {

		return $this->cargar_controlador_sin_chequear("categorias", "recuento_articulos");

	}
	
	
	
}
