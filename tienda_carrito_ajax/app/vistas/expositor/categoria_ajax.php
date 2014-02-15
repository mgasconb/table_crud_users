<script type='text/javascript'>
	$(".item").removeClass("selected");
	$("<?php echo "#item{$datos["categoria_id"]}"; ?>").addClass("selected");
</script>

<div>	
<br />
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
			<tr><td colspan='5'>
				
			<?php
			foreach ($datos['filas'] as $fila) {
				$img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px' />" :"";
				echo "
					<form method='post' onsubmit='carrito_meter(this, event); return(false);'>
					<table><tr>
						<td>
							<input type='hidden' name='articulo_id' value='{$fila["id"]}' />"
						. "<input type='text' readonly='readonly' name='nombre' value='{$fila["nombre"]}' />	</td>
						<td>$img</td>
						<td><input type='text' readonly='readonly' name='precio' value='".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio'])."' /></td>
						<td><input type='text'  name='unidades' value='1' /></td>
						<td>
							<input name='accion' type='submit' value='añadir' />
							
						</td>
					</tr>
					</table>
					</form>
					";
			}
			
			?>
				</td></tr>
		</tbody>
	</table>
<?php else :  ?>
	<h2>Lo sentimos, no hay artículos disponibles en esta categoría.</h2>
<?php endif; ?>
	<br />
	<a class='boton' onclick='cargar_view_content("<?=$datos["url_volver"]?>");' >Volver</a>
	<pre><?php // print_r($_SESSION["url"]); ?></pre>
</div>