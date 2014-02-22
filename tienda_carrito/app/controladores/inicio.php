<?php
namespace controladores;

class inicio extends \core\Controlador {
	

	public function index(array $datos = array()) {

		if (\core\Usuario::$login == "anonimo" and (isset($_GET["administrator"]) or isset($_GET["ADMINISTRATOR"])) ) {
			return $this->cargar_controlador("usuarios", "form_login");
		} 
		elseif (isset($_POST["is_ajax"])) {
			return $this->fordward("categorias", "recuento_articulos_ajax");
		}
		else {
			return $this->fordward("categorias", "recuento_articulos");
		}

	}
	
	
	
}
