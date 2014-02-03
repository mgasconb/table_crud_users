<?php
namespace controladores;

class carrito extends \core\Controlador {

	
	
	
	public function anexar_articulo(array $datos=array()) {
		
		
		if ( $validacion = !\core\Validaciones::errores_validacion_request(\modelos\carrito::$validaciones_insert, $datos)) {
			\modelos\carrito::anexar_articulo($datos, \core\Usuario::$id);
		}	
			
		
	}
	
	
	
	
	
	public function modificar_articulo(array $datos = array()) {
		
	}
	
	public function borrar_articulo(array $datos = array()) {
		
	}
	
	
	public function contenido(array $datos = array()) {
		
	}
	
	public function borrar(array $datos = array()) {
		
	}
	
} // Fin de la clase