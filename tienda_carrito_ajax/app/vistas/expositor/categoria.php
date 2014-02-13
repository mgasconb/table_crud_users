<script type='text/javascript'>
	$("<?php echo "#item{$datos["categoria_id"]}"; ?>").addClass("selected");
</script>

<div>	
<?php if (count($datos['filas'])) :?>
	<table border='1'>
		<thead>
			<tr>
				<th>nombre</th>
				<th>foto</th>
				<th>precio</th>
				<th>unidades</th>
				<th>acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila) {
				$img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px' />" :"";
				echo "
					<form method='post' action='".\core\URL::generar("carrito/meter")."' onsubmit='carrito_meter(this);'>
						<input type='hidden' name='articulo_id' value='{$fila["id"]}' />
					<tr>
						<td><input type='text' readonly='readonly' name='nombre' value='{$fila["nombre"]}' /></td>
						<td>$img</td>
						<td><input type='text' readonly='readonly' name='precio' value='".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio'])."' /></td>
						<td><input type='text'  name='unidades' value='1' /></td>
						<td>
							<input name='accion' type='submit' value='añadir' />
							
						</td>
					</tr>
					</form>
					";
			}
			
			?>
		</tbody>
	</table>
<?php else :  ?>
	<h2>Lo sentimos, no hay artículos disponibles en esta categoría.</h2>
<?php endif; ?>
	<a class='boton' href='<?=$datos["url_volver"]?>' >Volver</a>
</div>