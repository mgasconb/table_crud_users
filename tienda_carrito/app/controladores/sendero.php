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
		
		if (isset($_GET["administrator"])) {
			// /tienda_carrito/administrator/
			
			if ($controlador == "inicio") {
			if ($metodo == "index") {
				\modelos\sendero::iniciar("Inicio", $url);
			}
			else {
				// El método no es index
				if ( ! \modelos\sendero::get_nivel(1)) {
					\modelos\sendero::iniciar("Inicio", \core\URL::generar(""));
				}
				\modelos\sendero::set_nivel_2($metodo, $url);
			}
		}
		else {
			// El controlador no es inicio
			if ($metodo == "index") {
				if ( ! \modelos\sendero::get_nivel(1)) {
					\modelos\sendero::iniciar("Inicio", \core\URL::generar(""));
				}
				\modelos\sendero::set_nivel_2($controlador, $url);
			}
			else {
				// El método no es index
				if ( ! \modelos\sendero::get_nivel(1)) {
					\modelos\sendero::iniciar("Inicio", \core\URL::generar(""));
				}
				$paso2 = \modelos\sendero::get_nivel(2);
				if ( ! $paso2 ) {
					\modelos\sendero::set_nivel_2($metodo, \core\URL::generar("$controlador/$metodo"));
				}
				elseif ( $paso2["etiqueta"] == $controlador ) {
					\modelos\sendero::set_nivel_3($metodo, $url);
				}
				elseif ( $paso2["etiqueta"] != $controlador ) {
					\modelos\sendero::set_nivel_2($controlador, \core\URL::generar($controlador));
					\modelos\sendero::set_nivel_3($metodo, $url);
				}
				
			}
		}
			
		}
		else {
			// /tienda_carrito/
			if ($controlador == "inicio") {
				
				\modelos\sendero::iniciar("Inicio", $url);
				
			}
			elseif ($controlador == "expositor") {
				\modelos\sendero::set_nivel_2($controlador, \core\URL::generar($controlador));
				if ($metodo == "categoria") {
					\modelos\sendero::set_nivel_3(\core\HTTP_Requerimiento::get("p3"), $url);
				}
			}
			elseif ($controlador == "mensajes") {
				\modelos\sendero::iniciar("Inicio", \core\URL::generar("inicio"));
			}
			else {
				\modelos\sendero::set_nivel_2($controlador, \core\URL::generar($controlador));
				if ($metodo !== "index") {
					\modelos\sendero::set_nivel_3($metodo, $url);
				}
				
				
			}
			
		}

	}

	
	public static function ver() {
		
		$datos["sendero"] = \modelos\sendero::recuperar();
		return \core\Vista::generar("sendero/ver", $datos);
	}


}
