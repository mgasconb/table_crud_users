<div>	
<?php

$articulos = $datos["carrito"]->get_articulos();
//var_dump($articulos); exit(__FILE__);
?>
<?php if ($articulos) :?>
	<table border='1'>
		<thead>
			<tr>
				<th>nombre</th>
				<th>foto</th>
				<th>unidades</th>
				<th>precio</th>
				<th>acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($articulos as $articulo) {
//				$img = ($articulo["foto"]) ? "<img src='".URL_ROOT."recursos/imagenes/articulos/".$articulo["foto"]."' width='100px' />" :"";
				echo "
					<form>
						<input type='hidden' name='articulo_id'
					<tr>
						<td>{$articulo['nombre']}</td>
						<td></td>
						<td>".\core\Conversiones::decimal_punto_a_coma_y_miles($articulo['unidades'])."</td>
						<td>".\core\Conversiones::decimal_punto_a_coma_y_miles($articulo['precio'])."</td>
						
						<td>
														
						</td>
					</tr>
					</form>
					";
			}
			
			?>
		</tbody>
	</table>
<?php else :  ?>
	<h2>Carrito vacío.</h2>
<?php endif; ?>
	<a class='boton' href='<?=$datos["url_volver"]?>' >Volver</a>
</div>