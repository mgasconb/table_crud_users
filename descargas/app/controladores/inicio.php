<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controladores;

/**
 * Description of inicio
 *
 * @author jesus
 */
class inicio extends \core\Controlador {
	
	
	public function index(array $datos = array()) {
//		echo __METHOD__;
		
		$datos["carpetas"] = \modelos\ficheros::get_carpetas();
		$datos["view_content"] = \core\Vista::generar(__FUNCTION__, $datos);

		$http_body_content = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body_content);
//		echo("Fin de ".__METHOD__);
		
	}
}
