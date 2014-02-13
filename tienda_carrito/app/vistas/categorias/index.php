<div>
	<h1>Listado de categorias</h1>
	
	<table border='1'>
		<thead>
			<tr>
				<th>nombre</th>
				<th>foto</th>
				<th>descripcion</th>
				<th>acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila) {
				$img = ($fila["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/categorias/".$fila["foto"]."' width='200px' />" :"";
				
				echo "
					<tr>
						<td>{$fila['nombre']}</td>
						<td>$img</td>
						<td>{$fila['descripcion']}</td>
						<td>
					".\core\HTML_Tag::a_boton("boton", array("categorias", "form_modificar", $fila['id']), "modificar")
//							<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_modificar&id={$fila['id']}' >modificar</a>
					.\core\HTML_Tag::a_boton("boton", array("categorias", "form_borrar", $fila['id']), "borrar").
//							<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_borrar&id={$fila['id']}' >borrar</a>
						"</td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='3'></td>
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