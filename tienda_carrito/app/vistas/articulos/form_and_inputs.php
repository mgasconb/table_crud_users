
<form method='post' action="<?php echo \core\URL::generar(array(\core\Distribuidor::get_controlador_instanciado(), \core\Distribuidor::get_metodo_invocado()."_validar"))?>" enctype='multipart/form-data'  >

	<input id='id' name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />
	Categoría: <select id='categoria_id' name='categoria_id' />
		<?php 
			if (\core\Distribuidor::get_metodo_invocado() == "form_insertar") {
				echo "<option >Elige una categría</option>\n";
			}
			foreach ($datos['categorias'] as $categoria) {
				$selected = (\core\Array_Datos::values('categoria_id', $datos) == $categoria['id']) ? " selected='selected' " : "";
				echo "<option $selected value='{$categoria['id']}'>{$categoria['nombre']}</option>\n";
			}
		?>
	</select>
	<?php echo \core\HTML_Tag::span_error('categoria_nombre', $datos); ?>
	<br />
	Nombre: <input id='nombre' name='nombre' type='text' size='100'  maxlength='100' value='<?php echo \core\Array_Datos::values('nombre', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('nombre', $datos); ?>
	<br />
	Precio: <input id='precio' name='precio' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('precio', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('precio', $datos); ?>
	<br />
	Unidades en Stock: <input id='unidades_stock' name='unidades_stock' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('unidades_stock', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('unidades_stock', $datos); ?>
	<br />
	Descripcion:<br />
	<textarea id='descripcion' name='descripcion' type='textarea' cols='100'  rows='10' ><?php echo \core\Array_Datos::values('descripcion', $datos); ?></textarea>
	<?php echo \core\HTML_Tag::span_error('descripcion', $datos); ?>
	<br />
	Foto: <input id='foto' name='foto' type='file' size='100'  maxlength='100' value='<?php echo \core\Array_Datos::values('foto', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('foto', $datos); ?>
	<br />
	
	<?php echo \core\HTML_Tag::span_error('errores_validacion', $datos); ?>
	
	<input type='submit' value='Enviar'>
	<input type='reset' value='Limpiar'>
	<button type='button' onclick='location.assign("<?php echo \core\URL::generar(\core\Distribuidor::get_controlador_instanciado()); ?>");'>Cancelar</button>
</form>
