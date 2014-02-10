<?php
namespace controladores;

class categorias extends \core\Controlador {

	
	
	/**
	 * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
	 * @param array $datos
	 */
	public function index(array $datos=array()) {
		
		$clausulas['order_by'] = 'nombre';
		//$datos["filas"] = \modelos\categorias::select($clausulas, "categorias"); // Recupera todas las filas ordenadas
		$datos["filas"] = \modelos\Modelo_SQL::tabla("categorias")->select($clausulas); // Recupera todas las filas ordenadas
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	
	public function recuento_articulos(array $datos=array()) {

		//$datos["filas"] = \modelos\categorias::select($clausulas, "categorias"); // Recupera todas las filas ordenadas
		$_SESSION["expositor_actual"] = \core\URL::actual();
		$datos["filas"] = \modelos\Modelo_SQL::tabla("categorias")->recuento_articulos(); // Recupera todas las filas ordenadas
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	public function form_insertar(array $datos=array()) {
		
		$datos["form_name"] = __FUNCTION__;
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}

	public function form_insertar_validar(array $datos=array()) {
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\categorias::$validaciones_insert, $datos))
            $datos["errores"]["errores_validacion"] = "Corrige los errores.";
		else {
			$validacion = self::is_image_valid($datos);			
			if ($validacion) {
				\modelos\Modelo_SQL::tabla("categorias")->start_transaction();
				if ( ! $validacion = \modelos\Modelo_SQL::tabla('categorias')->insert($datos["values"])) // Devuelve el id de la fila o false
					$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
				else {
					// Se ha grabado la fila sin la foto
					if ($_FILES["foto"]["size"]) {
						$datos["values"]["id"] = $validacion;
						if ($datos["values"]["foto"] = self::mover_foto($datos["values"]["id"])) {
							$validacion = \modelos\Modelo_SQL::tabla('categorias')->update($datos["values"]);
						}
					}
					
				}
				if ($validacion)
					\modelos\Modelo_SQL::tabla("categorias")->commit_transaction();
				else {
					\modelos\Modelo_SQL::tabla("categorias")->rollback_transaction();
				}
			}
		}	
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			\core\Distribuidor::cargar_controlador('categorias', 'form_insertar', $datos);
		else
		{
			// Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
			//$datos = array("alerta" => "Se han grabado correctamente los detalles");
			// Definir el controlador que responderá después de la inserción
			//\core\Distribuidor::cargar_controlador('categorias', 'index', $datos);
			$_SESSION["alerta"] = "Se han grabado correctamente los datos";
			//header("Location: ".\core\URL::generar("categorias/index"));
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("categorias/index"));
			\core\HTTP_Respuesta::enviar();
		}
	}

	
	
	public function form_modificar(array $datos = array()) {
		
		$datos["form_name"] = __FUNCTION__;
		
		if ( ! isset($datos["errores"])) { // Si no es un reenvío desde una validación fallida
			$validaciones=array(
				"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/categorias/id"
			);
			if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
				$datos['mensaje'] = 'Datos erróneos para identificar el artículo a modificar';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$clausulas['where'] = " id = {$datos['values']['id']} ";
				if ( ! $filas = \modelos\Modelo_SQL::tabla('categorias')->select($clausulas)) {
					$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
					\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
					return;
				}
				else {
					$datos['values'] = $filas[0];
					
				}
			}
		}
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	
	
	
	
	public function form_modificar_validar(array $datos=array()) {	
		
		$validaciones=array(
			 "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/categorias/id"
			, "nombre" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,nombre/categorias/nombre,id"
			, "descripcion" => "errores_texto"
			
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			
            $datos["errores"]["errores_validacion"] = "Corrige los errores.";
		}
		else {
			
			if ( ! $validacion = \modelos\Modelo_SQL::tabla('categorias')->update($datos["values"])) // Devuelve true o false
					
				$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
			else {
				// Se ha actualizado la fila sin la foto
				$validacion = self::is_image_valid($datos);
					
				if ($validacion) {
					if ($datos["values"]["foto"] = self::mover_foto($datos["values"]["id"])) {
						$validacion = \modelos\Modelo_SQL::tabla('categorias')->update($datos["values"]);
//						var_dump($_FILES); var_dump($datos); exit;

					}
				}
			}				
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			\core\Distribuidor::cargar_controlador('categorias', 'form_modificar', $datos);
		else {
			$datos = array("alerta" => "Se han modificado correctamente.");
			// Definir el controlador que responderá después de la inserción
			\core\Distribuidor::cargar_controlador('categorias', 'index', $datos);		
		}
		
	}

	
	
	public function form_borrar(array $datos=array()) {
		
		$datos["form_name"] = __FUNCTION__;
		$validaciones=array(
			"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/categorias/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
			$datos['url_continuar'] = \core\URL::http('?menu=categorias');
			\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			$clausulas['where'] = " id = {$datos['values']['id']} ";
			if ( ! $filas = \modelos\Modelo_SQL::tabla('categorias')->select($clausulas)) {
				$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$datos['values'] = $filas[0];
			}
		}
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	
	
	
	
	
	public function form_borrar_validar(array $datos=array()) {	
		
		$validaciones=array(
			 "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/categorias/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
			$datos['url_continuar'] = \core\URL::http('?menu=categorias');
			\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			$clausulas = array (
				"columnas" => "foto",
				"where" => " id = {$datos["values"]["id"]}"
			);
			$filas = \modelos\Modelo_SQL::tabla("categorias")->select($clausulas);
			if ( ! $validacion = \modelos\Modelo_SQL::tabla('categorias')->delete($datos["values"])) {// Devuelve true o false
				$datos['mensaje'] = 'Error al borrar en la bd';
				$datos['url_continuar'] = \core\URL::http('?menu=categorias');
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				self::borrar_foto($filas[0]["foto"]);
				$_SESSION["alerta"] = "Se han borradoo correctamente los datos";
			
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
			$select['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$select['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $select, 'categorias');		
		
		$datos['html_para_pdf'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		require_once(PATH_APP."lib/php/dompdf/dompdf_config.inc.php");

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
		// $http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		// \core\HTTP_Respuesta::enviar($datos, 'plantilla_pdf');
		
	}
	

	private static function is_image_valid(array &$datos) {
		
		$validacion = true;
		
		if ($_FILES["foto"]["size"]) {
				if ($_FILES["foto"]["error"] > 0 ) {
					$datos["errores"]["foto"] = $_FILES["foto"]["error"];
				}
				elseif ( ! preg_match("/image/", $_FILES["foto"]["type"])) {
					$datos["errores"]["foto"] = "El fichero {$_FILES["foto"]["name"]} no es una imagen.";
				}
				elseif ($_FILES["foto"]["size"] > 1024*1024) {
					$datos["errores"]["foto"] = "El tamaño de la foto debe ser menor que 1MB.";
				}
				if (isset($datos["errores"]["foto"])) {
					$datos["values"]["foto"] = $_FILES["foto"]["name"];
					$validacion = false;
				}
		}
		
		return $validacion;
		
	}


	
	
	/**
	 * Mueve la foto desde la carpeta temporal hasta la carpeta destino.
	 * Crea un nombre nuevo para la foto del tipo cat9999.ext
	 * Si existe en la carpeta destino un fichero con igual nombre lo borra.
	 * 
	 * @param integer $id Es el id de la fila de categorías asociada a la foto.
	 * @return false|string False si fallo o "nombre.ext" del fichero destino.
	 */
	private static function mover_foto($id) {
		
		// Ahora hay que añadir la foto
		$extension = substr($_FILES["foto"]["type"], stripos($_FILES["foto"]["type"], "/")+1);
		$nombre = (string)$id;
		$nombre = "cat".str_repeat("0", 4 - strlen($nombre)).$nombre;
		$foto_path = PATH_APPLICATION."recursos".DS."imagenes".DS."categorias".DS.$nombre.".".$extension;
//		echo __METHOD__;echo $_FILES["foto"]["tmp_name"];  echo $foto_path; exit;
		// Si existe el fichero lo borramos
		if (is_file($foto_path)) {
			unlink($foto_path);
		}
		$validacion = move_uploaded_file($_FILES["foto"]["tmp_name"],
$foto_path);

		return ($validacion ? $nombre.".".$extension : false);
			
	}
	
	
	/**
	 * 
	 * @param type $foto
	 * @return null
	 */
	private static function borrar_foto($foto) {
		
		$foto_path = PATH_APPLICATION."recursos".DS."imagenes".DS."categorias".DS.$foto;
//					echo __METHOD__;echo $_FILES["foto"]["tmp_name"];  echo $foto_path; exit;
		// Si existe el fichero lo borramos
		if (is_file($foto_path)) {
			return unlink($foto_path);
		}
		else {
			return null;
		}
			
	}
	
	
	
} // Fin de la clase