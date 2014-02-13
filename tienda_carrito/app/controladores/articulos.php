<?php
namespace controladores;

class articulos extends \core\Controlador {

	
	
	/**
	 * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
	 * @param array $datos
	 */
	public function index(array $datos=array()) {
		
		$clausulas['order_by'] = 'categoria_nombre, nombre';
		$datos["filas"] = \modelos\Datos_SQL::table("v_articulos")->select( $clausulas ); // Recupera todas las filas ordenadas
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	public function form_insertar(array $datos=array()) {
		
		$clausulas['order_by'] = " nombre ";
		$datos['categorias'] = \modelos\Datos_SQL::table("categorias")->select($clausulas);
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}

	public function form_insertar_validar(array $datos=array())	{	
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\articulos::$validaciones_insert, $datos))
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
		else {
			
			if ($_FILES["foto"]["size"]) {
				if ($_FILES["foto"]["error"] > 0 ) {
					$datos["errores"]["foto"] = $_FILES["foto"]["error"];
				}
				elseif ( ! preg_match("/image/", $_FILES["foto"]["type"])) {
					$datos["errores"]["foto"] = "El fichero no es una imagen.";
				}
				elseif ($_FILES["foto"]["size"] > 1024*1024) {
					$datos["errores"]["foto"] = "El tamaño de la foto debe ser menor que 1MB.";
				}
				if (isset($datos["errores"]["foto"])) {
					$validacion = false;
				}
			}
			
			if ($validacion) {
				$datos['values']['precio'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['precio']);
				$datos['values']['unidades_stock'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['unidades_stock']);
						
				if ( ! $validacion = \modelos\Datos_SQL::table("articulos")->insert($datos["values"])) // Devuelve true o false
					$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
				else {
					if ($_FILES["foto"]["size"]) {
						$datos["values"]["id"] = $validacion;
						if ($datos["values"]["foto"] = self::mover_foto($datos["values"]["id"])) {
							$validacion = \modelos\Modelo_SQL::tabla('articulos')->update($datos["values"]);
						}
					}
				}
			}
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			$this->cargar_controlador('articulos', 'form_insertar',$datos);
		else
		{
			// Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
			$_SESSION["alerta"] = "Se han grabado correctamente los datos";
			//header("Location: ".\core\URL::generar("categorias/index"));
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(\core\Distribuidor::get_controlador_instanciado()));
			\core\HTTP_Respuesta::enviar();
		}
	}

	
	
	public function form_modificar(array $datos=array()) {
		
		if ( ! count($datos)) { // Si no es un reenvío desde una validación fallida
			$validaciones=array(
				"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/articulos/id"
			);
			if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
				$datos['mensaje'] = 'Datos erróneos para identificar el artículo a modificar';
				$this->cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$clausulas['where'] = " id = {$datos['values']['id']} ";
				if ( ! $filas = \modelos\Datos_SQL::table("articulos")->select($clausulas)) {
					$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
					$this->cargar_controlador('mensajes', 'mensaje', $datos);
					return;
				}
				else {
					$datos['values'] = $filas[0];
					$datos['values']['precio'] = \core\Conversiones::decimal_punto_a_coma_y_miles($datos['values']['precio']);
					$datos['values']['unidades_stock'] = \core\Conversiones::decimal_punto_a_coma_y_miles($datos['values']['unidades_stock']);
					
					$clausulas = array('order_by' => " nombre ");
					$datos['categorias'] = \modelos\Datos_SQL::table("categorias")->select( $clausulas);
				}
			}
		}
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	public function form_modificar_validar(array $datos=array()) {	
		
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\articulos::$validaciones_update, $datos)) {
			//print_r($datos);
            $datos["errores"]["errores_validacion"] = "Corrige los errores.";
		}
		else {
			if ($_FILES["foto"]["size"]) {
				if ($_FILES["foto"]["error"] > 0 ) {
					$datos["errores"]["foto"] = $_FILES["foto"]["error"];
				}
				elseif ( ! preg_match("/image/", $_FILES["foto"]["type"])) {
					$datos["errores"]["foto"] = "El fichero no es una imagen.";
				}
				elseif ($_FILES["foto"]["size"] > 1024*1024) {
					$datos["errores"]["foto"] = "El tamaño de la foto debe ser menor que 1MB.";
				}
				if (isset($datos["errores"]["foto"])) {
					$validacion = false;
				}
			}
			
			if ($validacion) {
				$datos['values']['precio'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['precio']);
				$datos['values']['unidades_stock'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['unidades_stock']);
				if ( ! $validacion = \modelos\Datos_SQL::table("articulos")->update($datos["values"])) // Devuelve true o false
					$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
				else {
					if ($_FILES["foto"]["size"]) {
						$datos["values"]["id"] = $validacion;
						if ($datos["values"]["foto"] = self::mover_foto($datos["values"]["id"])) {
							$validacion = \modelos\Modelo_SQL::tabla('articulos')->update($datos["values"]);
						}
					}
				}
			}
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			$this->cargar_controlador('articulos', 'form_modificar',$datos);
		else 		{
			$_SESSION["alerta"] = "Se han modificado correctamente los datos";
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(\core\Distribuidor::get_controlador_instanciado()));
			\core\HTTP_Respuesta::enviar();
		}
	}

	
	
	public function form_borrar(array $datos=array()) {
		
		$validaciones=array(
			"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/articulos/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
			$this->cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			$clausulas['where'] = " id = {$datos['values']['id']} ";
			if ( ! $filas = \modelos\Datos_SQL::table("articulos")->select( $clausulas)) {
				$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
				$this->cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$datos['values'] = $filas[0];
				$datos['values']['precio'] = \core\Conversiones::decimal_punto_a_coma_y_miles($datos['values']['precio']);
				$datos['values']['unidades_stock'] = \core\Conversiones::decimal_punto_a_coma_y_miles($datos['values']['unidades_stock']);
				$clausulas = array('order_by' => " nombre ");
				$datos['categorias'] = \modelos\Datos_SQL::select( $clausulas, 'categorias');
			}
		}
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	
	
	
	
	
	
	
	
	
	
	public function form_borrar_validar(array $datos=array()) {	
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\articulos::$validaciones_delete, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
			$this->cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else
		{
			if ( ! $validacion = \modelos\Datos_SQL::delete($datos["values"], 'articulos')) {// Devuelve true o false
				$datos['mensaje'] = 'Error al borrar en la bd';

				$this->cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				self::borrar_foto($filas[0]["foto"]);
				$_SESSION["alerta"] = "Se han borrado correctamente los datos";
				//header("Location: ".\core\URL::generar("categorias/index"));
				\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar(\core\Distribuidor::get_controlador_instanciado()));
				\core\HTTP_Respuesta::enviar();
			}
		}
	}
	
	
	public function listado_pdf(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $clausulas , 'articulos');		
		
		$datos['html_para_pdf'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		require_once(PATH_ESMVCPHP."app".DS."lib".DS."php".DS."dompdf".DS."dompdf_config.inc.php");

		$html =
		  '<html><body>'.
		  '<p>Put your html here, or generate it with your favourite '.
		  'templating system.</p>'.
		  '</body></html>';

		$dompdf = new \DOMPDF();
		$dompdf->load_html($datos['html_para_pdf']);
		$dompdf->render();
		$dompdf->stream("sample.pdf", array("Attachment" => 0));
		
		// \core\HTTP_Respuesta::set_mime_type('application/pdf');
		// \core\HTTP_Respuesta::enviar($datos, 'plantilla_pdf');
		
	}
	

	/**
	 * Genera una respuesta json con un array que contiene objetos, siendo cada objeto una fila.
	 * @param array $datos
	 */
	public function listado_js(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select($clausulas, 'articulos');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('text/json');
//		$http_body = \core\Vista_Plantilla::generar('plantilla_json', $datos);
//		\core\HTTP_Respuesta::enviar($http_body);
		\core\HTTP_Respuesta::enviar($datos['contenido_principal']);

	}
	
	/**
	 * Genera una respuesta json con un array que contiene objetos, siendo cada objeto una fila.
	 * @param array $datos
	 */
	public function listado_js_array(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $clausulas, 'articulos');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('text/json');
		$http_body = \core\Vista_Plantilla::generar('plantilla_json', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	/**
	 * Genera una respuesta xml.
	 * 
	 * @param array $datos
	 */
	public function listado_xml(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($_datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$_datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $clausulas, 'articulos');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('text/xml');
		$http_body = \core\Vista_Plantilla::generar('plantilla_xml', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
		
	}
	
	
	
	
	/**
	 * Genera una respuesta excel.
	 * @param array $datos
	 */
	public function listado_xls(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($_datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$_datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select($clausulas, 'articulos');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('application/excel');
		$http_body = \core\Vista_Plantilla::generar('plantilla_xls', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	
	
	private static function mover_foto($id) {
		
		// Ahora hay que añadir la foto
		$extension = substr($_FILES["foto"]["type"], stripos($_FILES["foto"]["type"], "/")+1);
		$nombre = (string)$id;
		$nombre = "art".str_repeat("0", 4 - strlen($nombre)).$nombre;
		$foto_path = PATH_APPLICATION."recursos".DS."imagenes".DS."articulos".DS.$nombre.".".$extension;
//					echo __METHOD__;echo $_FILES["foto"]["tmp_name"];  echo $foto_path; exit;
		// Si existe el fichero lo borramos
		if (is_file($foto_path)) {
			unlink($foto_path);
		}
		$validacion = move_uploaded_file($_FILES["foto"]["tmp_name"],
$foto_path);

		return ($validacion ? $nombre.".".$extension : false);
			
	}
	
	
	private static function borrar_foto($foto) {
		
		$foto_path = PATH_APPLICATION."recursos".DS."imagenes".DS."articulos".DS.$foto;
		// Si existe el fichero lo borramos
		if (is_file($foto_path)) {
			return unlink($foto_path);
		}
		else {
			return null;
		}
			
	}
	
	
} // Fin de la clase