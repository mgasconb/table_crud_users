<?php
namespace controladores;

class carrito_objeto 
	extends \core\Controlador
		implements \controladores\carrito_interface {

	
	
	
	public function meter(array $datos=array()) {
		
		if ( $validacion = !\core\Validaciones::errores_validacion_request(\modelos\carrito::$validaciones_insert, $datos)) {
			
			$carrito = $this->recuperar();
			$carrito->meter($datos["values"]);
			
		}	
		
		header("Location: ".\core\URL::anterior());
		
	}
	
	
	
	
	
	public function modificar_articulo(array $datos = array()) {
		
	}
	
	public function borrar_articulo(array $datos = array()) {
		
	}
	
	
	public function ver(array $datos = array()) {
		
		$carrito = $this->recuperar();
		
		$datos["carrito"] = $carrito;
		
		return \core\Vista::generar("carrito_objeto/".__FUNCTION__, $datos);
//		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
//		\core\HTTP_Respuesta::enviar($http_body);
//		
		
	}
	
	
	
	public function borrar(array $datos = array()) {
		
	}
	
	
	/**
	 * Recupera el carrito guardado en la base de datos.
	 * Si el usuario logueado tenía un carrito como anónimo y un carrito como usuario logueado
	 * se recupera el de fecha más reciente y el otro se destruye.
	 */
	public function recuperar() {
		
		$carrito_anonimo = \modelos\carrito::recuperar(session_id());
		$carrito_usuario = \modelos\carrito::recuperar((string)\core\Usuario::$id);
		$id = (\core\Usuario::$id ? (string)\core\Usuario::$id : session_id());
		
		if ( ! $carrito_anonimo and ! $carrito_usuario ) {
			$carrito = new \modelos\carrito($id);
		}
		elseif ( $carrito_anonimo and ! $carrito_usuario) {
			$carrito = $carrito_anonimo;
			$carrito->cambiar_id($id);
		}
		elseif ( ! $carrito_anonimo and $carrito_usuario) {
			$carrito = $carrito_usuario;
		}
		elseif ( $carrito_anonimo and $carrito_usuario) {
			if ($carrito_anonimo->get_fechaHoraInicio() > $carrito_usuario->get_fechaHoraInicio()) {
				$carrito = $carrito_anonimo;
				$carrito->cambiar_id($id);
			}
			else {
				$carrito = $carrito_usuario;
			}
		}
		return $carrito;
		
	}
	
	
} // Fin de la clase