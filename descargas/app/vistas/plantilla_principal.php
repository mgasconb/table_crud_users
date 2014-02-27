<!DOCTYPE HTML>
<html lang='es'>
	<head>
		<title>Descargas </title>
		<meta name="Description" content="Explicación de la página" /> 
		<meta name="Keywords" content="palabras en castellano e ingles separadas por comas" /> 
		<meta name="Generator" content="esmvcphp framewrok" /> 
	 	<meta name="Origen" content="esmvcphp framework" /> 
		<meta name="Author" content="Jesús María de Quevedo Tomé" /> 
		<meta name="Locality" content="Madrid, España" /> 
		<meta name="Lang" content="es" /> 
		<meta name="Viewport" content="maximum-scale=10.0" /> 
		<meta name="revisit-after" content="1 days" /> 
		<meta name="robots" content="INDEX,FOLLOW,NOODP" /> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf8" /> 
		<meta http-equiv="Content-Language" content="es"/>
		<script type='text/javascript' src="<?php echo URL_APPLICATION_ROOT."download/js/carrito.js"; ?>" ></script>
	</head>
	<body>
		<h1>Página de descargas</h1>
		<div>
		<?php echo $datos["view_content"]; ?>
		</div>
		
		<div id='globals'>
			<?php
				 print "<pre>"; 
				  //print_r($GLOBALS);
				 print("\$_GET "); print_r($_GET);
				 print("\$_POST ");print_r($_POST);
				 print("\$_COOKIE ");print_r($_COOKIE);
				 print("\$_REQUEST ");print_r($_REQUEST);
			 print("\$_SESSION ");print_r($_SESSION["usuario"]);
				 print("\$_SERVER ");print_r($_SERVER);
				 print "</pre>";
				 print("xdebug_get_code_coverage() ");
				 var_dump(xdebug_get_code_coverage());
			?>
		</div>
		
	</body>
</html>