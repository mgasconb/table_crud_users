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

	
}