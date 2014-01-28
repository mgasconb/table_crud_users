<?php
namespace core;

class Configuracion {
	
	// Respuesta por defecto
	public static $controlador_por_defecto = 'inicio';
	public static $metodo_por_defecto = 'index';
	public static $plantilla_por_defecto = 'plantilla_principal';

	// Respuesta HTTP
	public static $tipo_mime_por_defecto = 'text/html';
	public static $tipos_mime_reconocidos = array(
		'text/html', 'text/xml', 'text/json', 'application/excel', 
	);
	
	
	// Gestión de inactividad
	public static $sesion_inactividad_controlada = false;
	public static $sesion_minutos_inactividad = 20; // Minutos
	public static $sesion_minutos_maxima_duracion = 120;
	
	// URL amigables
	public static $url_amigable = true;
	
	// Control acceso a recursos
	public static $control_acceso_recursos = true;
	
	// Visualización de errores
	public static $display_errors = "on"; // Valores posibles "on" "off""

	// Gestión de idiomas
	public static $idioma_por_defecto = "es";
	public static $idioma_seleccionado;
	public static $idiomas_reconocidos = "es|en|fr";
	
	// Formularios de login
	public static $https_login = false;
	public static $form_login_catcha = false;
	public static $form_insertar_externo_catcha = false;
	
	// Contactos
	public static $email_info = "info@esmvcphp.es";
	public static $email_noreply = "noreply@esmvcphp.es";
	
	
	// Base de datos
	// localhost
	public static $db = array(
		'server'   => 'localhost',
		'user'     => 'daw2_user',
		'password' => 'daw2_user',
		'db_name'  => 'daw2',
		'prefix_'  => 'daw2_'
	);

	// hostinger
//	public static $db = array(
//		'server'   => 'mysql.hostinger.es',
//		'user'     => 'u452950836_daw2',
//		'password' => 'u452950836_daw2',
//		'db_name'   => 'u452950836_daw2',
//		'prefix_'  => 'daw2_'
//	);
	
	/**
	 * Define array llamado recursos_y_usuarios con la definición de todos los permisos de acceso a los recursos de la aplicación.
	 * 
	 * * Recursos:
	 *  [*][*] define todos los recursos
	 *  [controlador][*] define todos los métodos de un controlador
	 * Usuarios:
	 *  * define todos los usuarios (anonimo más logueados)
	 *  ** define todos los usuarios logueados (anonimo no está incluido)
	 * 
	 * @var array =('controlador' => array('metodo' => ' nombres usuarios rodeados por espacios
	 */
	public static $access_control_list = array(
		'*' => array(	'*' => ' admin '),
		'inicio' => array (
						'*' => ' ** ',
						'index' => ' * ',
					),
	
		'mensajes' => array(
							'*' => ' * ',
							),
		'usuarios' => array(
							'*' => ' juan pedro ',
							'index' => ' anais ana olga ',
							'desconectar' => ' ** ',
							'form_login_email' => ' anonimo ',
							'validar_form_login_email' => ' anonimo ',
							)
	
	);
} // Fin de la clase 
