<?php
namespace controladores;

class inicio extends \core\Controlador {
	

	public function index(array $datos = array()) {

		if (\core\Usuario::$login == "anonimo" and (isset($_GET["administrator"]) or isset($_GET["ADMINISTRATOR"])) ) {
			return $this->cargar_controlador("usuarios", "form_login");
		} 
		elseif (isset($_POST["is_ajax"])) {
			// Si el controlador se pide desde ajax se devuelve la vista.
			return $this->cargar_controlador_sin_chequear("categorias", "recuento_articulos_ajax");
		}
		else {
			// Aprovechamos para borrar en la base de datos los carritos de hace más de
			// una hora.
			$where = "timestampdiff(minute, fechaHoraInicio, now()) > 60";
			\modelos\Modelo_SQL::table("carritos")->delete(null, null, $where);
			// Si el controlador no se pide desde ajax se devuelve el documento html completo.
			$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
			\core\HTTP_Respuesta::enviar($http_body);
		}

	}
	
	
	
}
