<div>
	<h1>Listado de articulos</h1>
	<p>
		<a href='?menu=articulos&submenu=listado_js' title='Devuelve objeto json con una propiedad que contiene un array'>Listado en json</a> - 
		<a href='?menu=articulos&submenu=listado_js_array&nombre=a'  title='Devuelve un array que contiene objetos json'>Listado en json con array de articulos que contiene "a" en su nombre</a> - 
		<a href='?menu=articulos&submenu=listado_xml'>Listado en xml</a> - 
		<a href='?menu=articulos&submenu=listado_xls'>Descargar Listado en excel (.xls)</a>
		 - 
		<a href='?menu=articulos&submenu=listado_pdf'>Descargar pdf</a>
	</p>
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
							<a class='boton' href='".\core\URL::generar("articulos/form_modificar/{$fila["id"]}")."' >modificar</a>
							<a class='boton' href='".\core\URL::generar("articulos/form_borrar/{$fila["id"]}")."' >borrar</a>
						</td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='5'></td>
					<td><a class='boton' href='".\core\URL::generar("articulos/form_insertar")."' >insertar</a></td>
				</tr>
			";
			?>
		</tbody>
	</table>
	<a class='boton' href='<?=$datos["url_volver"]?>' >Volver</a>
</div>