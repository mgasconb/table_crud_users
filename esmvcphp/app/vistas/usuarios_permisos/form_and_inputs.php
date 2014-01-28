
<form method='post' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' action="?menu=<?php echo \core\Distribuidor::get_controlador_instanciado(); ?>&submenu=form_modificar_validar" >
	
	<?php echo \core\HTML_Tag::form_registrar($datos["form_name"], "post"); ?>
	
	<input id='rol' name='rol' type='hidden' value='<?php echo \core\Array_Datos::contenido('rol', $datos); ?>' />
	<?php 
		$i = 0;
		foreach ($datos["filas"] as $fila) {
			$checked = ($fila["rol"]) ? " checked='cheched' " : "";
			echo "<input type='checkbox' $checked name='permiso$i' value='{$fila["controlador"]},{$fila["metodo"]}' /> {$fila["controlador"]}::{$fila["metodo"]}<br />";
			$i++;
		}
	?>
	 

	<br />
	
	
	<input type='submit' value='Enviar'/>
	<input type='reset' value='Limpiar'/>
	<button type='button' onclick='location.assign("<?php echo\core\URL::generar("roles/index"); ?>");'>Cancelar</button>
</form>
