<?php

namespace modelos;

class carrito extends \core\sgbd\bd {

	private static $id = null;
	
	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
		"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",
		"unidades" => "errores_requerido && errores_numero_entero_positivo",
		"precio" => "errores_requerido && errores_numero_decimal_positivo",
		"nombre" => "errores_requerido && errores_texto"
	);
	
	
	public static $validaciones_update = array(
		"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",		
		"unidades" => "errores_requerido && errores_numero_entero_positivo",
		"precio" => "errores_requerido && errores_numero_decimal_positivo",
		"nombre" => "errores_requerido && errores_texto"
	);
	

	public static $validaciones_delete = array(
		"articulo_id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:articulo_id/articulos/id",
	);

	
	/**
	 * Anexa o modifica un artículo existente en el carrito.
	 * 
	 * @param type $datos
	 * @param type $login_id
	 */
	public static function anexar_articulo($datos, $login_id) {
	
		if (\core\Usuario::$id) {
			self::anexar_articulo_a_bd($datos, $login_id);
		}
		else {
			self::anexar_de_session($datos, $login_id);
		}
		
	}
	
	
	
	private function anexar_articulo_a_session($datos) {
		
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
	
	
	private function borrar_articulo_de_session($datos) {
		
		unset($_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]]));
		
	}
	
	
	
	private function modificar_articulo_de_session($datos) {
		
		if ( ! isset($_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]])) {
			$_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]]["unidades"] -= $datos["values"]["unidades"];
			
			if ($_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]]["unidades"] == 0 ) {
				unset($_SESSION["carrito"]["articulos"][$datos["values"]["articulo_id"]]);
			} 
			
		}	
		
	}
	
	
	
	
	public static function borrar_articulo($datos, $login_id) {
		if (\core\Usuario::$id) {
			self::borrar_en_bd($datos, $login_id);
		}
		else {
			self::borrar_en_session($datos, $login_id);
		}
	}
	
	
	
	public static function borrar($login_id) {
		
	}
	
	public static function recuperar($login_id) {
		
		
		
	}
	

	
	private function anexar_articulo_a_bd($datos, $login_id) {
		
		$clausulas["where"] = " usuario_id = '$login_id' and fecha_hora_compra is null ";
		if ( !\modelos\Modelo_SQL::table("pedidos")->select($clausulas)) {
			$pedido_id = \modelos\Modelo_SQL::table("pedidos")->insert("usuario_id" => $login_id);
			
			
		} 
		
	}
	
	
	private function borrar_articulo_de_bd($datos) {
		
	}
	
	
	private function modificar_articulo_en_bd($datos) {
		
	}
	
}