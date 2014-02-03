<?php
namespace controladores;

class carrito extends \core\Controlador {

	
	
	
	public function form_anexar_articulo_validar(array $datos=array()) {
		
		$validaciones = array(
			"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",
			"unidades" => "errores_requerido && errores_numero_entero_positivo",
			"precio" => "errores_requerido && errores_numero_decimal_positivo"
		);
		if ( $validacion = !\core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			
			if (\core\Usuario::$login == "anonimo") {
				$this->anexar_a_session($datos);
			}
			else {
				$this->anexar_a_bd($datos);
			}
		}	
			
		
	}
	
	
	
	private function anexar_a_session($datos) {
		
		if ( ! isset($_SESSION["carrito"])) {
			$_SESSION["carrito"]["fechaHoraInicio"] = date("Y-m-d H:i:s");
		}
		if ( ! isset($_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]])) {
			$_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]] = array("unidades" => $datos["values"]["unidades"], "precio" => $datos["values"]["precio"]);
		}
		else {
			$_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]]["unidades"] += $datos["values"]["unidades"];
		}		
		
	}
	
	
	
	
} // Fin de la clase