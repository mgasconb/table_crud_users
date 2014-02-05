<?php
namespace core;

/**
 * @author Jesús María de Quevedo Tomé <jequeto@gmail.com>
 * @since 20130130
 */
class Clase_Base extends \core\Distribuidor {
	/**
	 * Contenedor de datos para cualquier clase, en especial para los controladores.
	 * @var array 
	 */
	public $datos = array(); 
	
	
	/**
	 * Devuelve el contenido de una entrada del array que se pasa por parámetro.
	 * Si la entrada no existe devuelve null.
	 * 
	 * @param string|integer $indice
	 * @param array $array
	 * @return mixed
	 */
	public static function contenido($indice, array $array) {
		
		if ( ! is_string($indice) && ! is_integer($indice))
			throw new \Exception(__METHOD__." Error: parámetro \$indice=$indice debe ser entero o string");
		
		return (array_key_exists($indice, $array) ? $array[$indice] : null);
		
	}
	
	
	
	public static function ejecutar($controlador, $metodo = "index", array $datos = array()) {
		
		$clase_controlador = "\\controladores\\$controlador";
		$objeto = new $clase_controlador();
		return $objeto->$metodo($datos);
		
	}
	
	
} // Fin de la clase

