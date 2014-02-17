<script type='text/javascript'>
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
				$img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/categorias/".$fila["foto"]."' width='200px' />" :"";
				
				echo "
					<tr>
						<td><a href='".\core\URL::generar(array("expositor", "categoria", $fila['nombre'], $fila['id']))."' >{$fila['nombre']}</a></td>
						<td>$img</td>
						<td>{$fila['descripcion']}</td>
						<td>{$fila['cuenta_articulos']}</td>
						<td>
					".\core\HTML_Tag::a_boton("boton", array("expositor", "categoria", $fila['nombre'], $fila['id']), "ir").							
						"</td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='4'></td>
						<td>"
			.\core\HTML_Tag::a_boton("boton", array("categorias", "form_insertar"), "insertar").
					"</td>
				</tr>
			";
			?>
		</tbody>
	</table>
	<a class='boton' href='<?=$datos["url_volver"]?>' >Volver</a>
</div>