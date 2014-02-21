<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controladores;

/**
 * Description of senderomigaspan
 *
 * @author jequeto
 */
class sendero extends \core\Controlador {
	

	public static function insert($controlador, $metodo, $url) {
		
		if ($controlador == "inicio") {
			if ($metodo == "index") {
				\modelos\sendero::iniciar("Inicio", $url);
			}
			else {
				// El método no es index
				\modelos\sendero::set_nivel_2($metodo, $url);
			}
		}
		else {
			if ($metodo == "index") {
				\modelos\sendero::set_nivel_2($controlador, $url);
			}
			else {
				// El método no es index
				\modelos\sendero::set_nivel_3($metodo, $url);
			}
		}

	}

	
	public static function ver() {
		
		$datos["sendero"] = \modelos\sendero::recuperar();
		return \core\Vista::generar("sendero/ver", $datos);
	}


}
