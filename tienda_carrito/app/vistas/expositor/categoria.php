<script type='text/javascript'>
	$("<?php echo "#item{$datos["categoria_id"]}"; ?>").addClass("selected");
</script>

<div>	
<?php if (count($datos['filas'])) :?>
	<table border='1'>
		<thead>
			<tr>
				<th>categoría</th>
				<th>nombre</th>
				<th>foto</th>
				<th>precio</th>
				<th>unidades en stock</th>
				<th>acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila) {
				$img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$fila["foto"]."' width='200px' />" :"";
				echo "
					<tr>
						<td>{$fila['categoria_nombre']}</td>
						<td>{$fila['nombre']}</td>
						<td>$img</td>
						<td>".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['precio'])."</td>
						<td>".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['unidades_stock'])."</td>
						<td>
							<a class='boton' href='".\core\URL::generar("carrito/form_anexar_articulo/{$fila["id"]}")."' >comprar</a>
							
						</td>
					</tr>
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