
<form method='post' action="?menu=<?php echo $datos['controlador_clase']; ?>&submenu=validar_<?php echo $datos['controlador_metodo']; ?>" >
    

	<input id='id' name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />
	Nombre: <input id='nombre' name='nombre' type='text' size='100'  maxlength='100' value='<?php echo \core\Array_Datos::values('nombre', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('nombre', $datos); ?>
	<br />
	Apellido paterno: <input id='apellidoPaterno' name='apellidoPaterno' type='text' size='100'  maxlength='100' value='<?php echo \core\Array_Datos::values('apellidoPaterno', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('apellidoPaterno', $datos); ?>
	<br />
	Apellido materno: <input id='apellidoMaterno' name='apellidoMaterno' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('apellidoMaterno', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('apellidoMaterno', $datos); ?>
	<br />
	Correo: <input id='correo' name='correo' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('correo', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('correo', $datos); ?>
	<br />        
        Nombre de usuario: <input id='username' name='username' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('username', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('username', $datos); ?>
	<br />
        Contraseña: <input id='password' name='password' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('password', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('password', $datos); ?>
	<br />
        Puntuación: <input id='puntuacion' name='puntuacion' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('puntuacion', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('puntuacion', $datos); ?>
	<br />
        Fecha registro: <input id='dt_registro' name='dt_registro' type='text' size='20'  maxlength='20' value='<?php echo \core\Array_Datos::values('dt_registro', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('dt_registro', $datos); ?>
	<br />
	<?php echo \core\HTML_Tag::span_error('errores_validacion', $datos); ?>
	
        <input class="boton" type='submit' value='Enviar'>
	<input class="boton" type='reset' value='Limpiar'>
	<button class="boton" type='button' onclick='location.assign("<?php echo \core\URL::generar($datos['controlador_clase'].'/index')?>");'>Cancelar</button>
</form>
