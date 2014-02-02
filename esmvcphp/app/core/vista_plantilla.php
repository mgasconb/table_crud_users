<?php
namespace core;

class Vista_Plantilla extends \core\Clase_Base {
	/**
	 * Genera el código html y si buffer es true lo captura y lo devuelve por el return.
	 * 
	 * @param string $nombre Nombre del fichero que contiene la plantilla en la carpeta .../vistas/ s
	 * @param array $datos
	 * @param boolean $buffer Opcional. Por defecto es true, que activa la captura del buffer
	 * @return string Código <html>
	 * @throws \Exception
	 */
	public static function generar($nombre , array $datos = array(), $buffer = true) {
		
		if (strtoupper($nombre) == "DEFAULT") {
			if ( isset($_GET["administrator"]) or isset($_GET["ADMINISTRATOR"])) {
				$nombre = \core\Configuracion::$plantilla_administrator;
			}
			else {
				$nombre = \core\Configuracion::$plantilla_por_defecto;
			}
		}

		$fichero_vista = strtolower(PATH_APP."vistas/$nombre.php");

		if ( ! file_exists($fichero_vista)) {
			$fichero_vista1 = $fichero_vista;
			$fichero_vista = strtolower(PATH_ESMVCPHP."app".DS."vistas/$nombre.php");
			if ( ! file_exists($fichero_vista)) {
				throw new \Exception(__METHOD__." Error: no existe la plantilla $nombre ni en $fichero_vista1 ni en $fichero_vista .");
			}
		}
		
		$datos["controlador_clase"] = \core\Distribuidor::get_controlador_instanciado();
		$datos["controlador_metodo"] = \core\Distribuidor::get_metodo_invocado();
		if (! isset($datos["url_volver"]))
				$datos["url_volver"] = $_SESSION["url"]["btn_volver"];
		if (! isset($datos["url_cancelar"]))
				$datos["url_cancelar"] = $_SESSION["url"]["btn_volver"];
		
		if ($buffer) { 
			ob_start ();
		}
		
		include $fichero_vista; // Script cuya salida se va a bufferear
		
		if ($buffer) {
			return(ob_get_clean());
		}
	}
	
	
			
}