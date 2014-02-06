<?php
namespace controladores;

class inicio extends \core\Controlador {
	

	public function index(array $datos = array()) {

		if (\core\Usuario::$login == "anonimo" and (isset($_GET["administrator"]) or isset($_GET["ADMINISTRATOR"])) ) {
			return $this->cargar_controlador("usuarios", "form_login");
		} 
		else {
			return $this->cargar_controlador_sin_chequear("categorias", "recuento_articulos");
		}

	}
	
	
	
}
