<?php

namespace modelos;

class categorias extends \core\sgbd\bd {

	
	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
		"nombre" =>"errores_requerido && errores_texto && errores_unicidad_insertar:nombre/categorias/nombre"
		, "descripcion" => "errores_texto"
	);
	
	
	public static $validaciones_update = array(
		"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/categorias/id"
		, "nombre" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,nombre/categorias/id,nombre"
		, "descripcion" => "errores_texto"
	);
	

	public static $validaciones_delete = array(
		"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/categorias/id"
	);

	
	
	public static function recuento_articulos() {
		
		$sql = "select c.*, vcar.cuenta_articulos"
				. " from daw2_categorias c left join daw2_v_categorias_articulos_recuento vcar on c.id = vcar.categoria_id"
				. " order by c.nombre"
				. ";";
		return(self::execute($sql));
		
	}
	
	
}