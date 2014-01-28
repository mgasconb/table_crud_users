
<form method='post' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' action="?menu=<?php echo \core\Distribuidor::get_controlador_instanciado(); ?>&submenu=form_modificar_validar" >
	
	<input id='rol' name='login' type='hidden' value='<?php echo \core\Array_Datos::contenido('login', $datos); ?>' />
	<table class='resultados'>
		<tr><th>asignado</th><th>Permisos</th><th>Heredado de</th></tr>
	<?php 
		$i = 0;
		foreach ($datos["filas"] as $fila) {
			if ($fila["login"] && $fila["rol"]) {
				$checked = " checked='checked' disabled='disabled' origen='heredado' ";
			}
			elseif ($fila["login"] && ! $fila["rol"]) {
				$checked = " checked='checked' disabled='disabled' origen='directo' ";
			}
			else {
				$checked = " origen='directo'";
			}
			echo "<tr><td><input type='checkbox' $checked name='permiso$i' value='{$fila["controlador"]},{$fila["metodo"]}' /></td><td>{$fila["controlador"]}::{$fila["metodo"]}</td><td>{$fila["rol"]}</td></tr>";
			$i++;
		}
	?>
	</table> 

	<br />
	
	
	<input type='submit' value='Enviar'/>
	<input type='reset' value='Limpiar'/>
	<button type='button' onclick='location.assign("<?php echo\core\URL::generar("roles/index"); ?>");'>Cancelar</button>
</form>
