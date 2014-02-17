<script type='text/javascript'>
	$(".item").removeClass("selected");
	$("#item").addClass("selected");
</script>

<div>
	<h1>Listado de categorias</h1>
	
	<table border='1'>
		<thead>
			<tr>
				<th>nombre</th>
				<th>foto</th>
				<th>descripcion</th>
				<th>contador de artículos</th>
				<th>acción</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila) {
				$img = ($fila["foto"]) ? "<img src='".dirname(URL_ROOT)."/tienda_carrito/"."recursos/imagenes/categorias/".$fila["foto"]."' width='200px' />" :"";
				
				echo "
					<tr>
						<td><a class='boton' onclick='cargar_view_content(\"".\core\URL::generar(array("expositor", "categoria_ajax", $fila['nombre'], $fila['id']))."\");' >{$fila['nombre']}</a></td>
						<td>$img</td>
						<td>{$fila['descripcion']}</td>
						<td>{$fila['cuenta_articulos']}</td>
						<td>
					<a class='boton' onclick='cargar_view_content(\"".\core\URL::generar(array("expositor", "categoria_ajax", $fila['nombre'], $fila['id']))."\");' >Ver</a>
						</td>
					</tr>
					";
			}
			
			?>
		</tbody>
	</table>
	<a class='boton' onclick='cargar_view_content("<?=$datos["url_volver"]?>");' >Volver</a>
	<pre><?php // print_r($_SESSION["url"]); ?></pre>
</div>