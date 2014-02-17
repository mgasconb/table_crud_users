<div>
	<div id="carrito_botones">
		<button id='btn_carrito' onclick='$("#carrito_detalles").css("display","block"); $("#carrito_botones").css("display","none");' >Carrito</button>
		<span id='carrito_importe'><?php echo number_format(self::ejecutar("carrito","valor"),2,",","."); ?> €</span>
	</div>

<?php

$articulos = $datos["carrito"]->get_articulos();
//var_dump($articulos);
//var_export($articulos);
?>
	<div id='carrito_detalles' >
		<b>Carrito</b><button style='background-color: red; float: right;' onclick='$("#carrito_detalles").css("display","none");  $("#carrito_botones").css("display","block");'>X</button>
<?php if ($articulos) :?>
	<form method='post' onsubmit='carrito_vaciar(); return(false);'>
		<button type='submit'>Vaciar Carrito</button>
	</form>
		
	<table border='1'>
		<thead>
			<tr>
				<th>nombre</th>
				<th>foto</th>
				<th>unidades</th>
				<th>precio</th>
				<th>total</th>
				<th>acciones</th>
			</tr>
		</thead>
		<tbody>
			<tr><td colspan='6'>
			<?php
			$total_acumulado = 0;
			foreach ($articulos as $articulo_id => $articulo) {
				$img = ($articulo["foto"]) ? "<img src='".dirname(URL_ROOT)."/tienda_carrito/"."recursos/imagenes/articulos/".$articulo["foto"]."' width='50px' />" :"";
				$total = $articulo['unidades'] * $articulo['precio'];
				$total_acumulado += $total;
				echo "
					<form id='fc$articulo_id' method='post' >
						
						<input type='hidden'  name='articulo_id' value='$articulo_id' />
					<table>
					<tr>
						<td>{$articulo['nombre']}</td>
						<td>$img</td>
						<td><input  name='unidades' size='8' value='".number_format($articulo["unidades"], 0, ",", ".")."' /></td>
						<td>"
								.number_format($articulo['precio'], 2, ",", ".").
//								.$articulo["precio"].
								"</td>
						
						<td>"
						. number_format($total,2,",",".") .
						"</td>
						<td>								
						<input name='accion' type='button' value='corregir' onclick='carrito_modificar(\"fc$articulo_id\",\"modificar\");' />
						<input name='accion' type='button' value='quitar' onclick='carrito_modificar(\"fc$articulo_id\",\"quitar\");' />
						</td>
					</tr>
					</table>
					</form>
					";
			}
			echo "<tr><td colspan='4'></td><td><b>".number_format($total_acumulado,2,",",".") ."</b></td><td></td></tr>";
			?>
			</td></tr>
		</tbody>
	</table>
	<button type='button' onclick='window.location.assign("<?php echo \core\URL::generar("carrito/comprar")?>");' >Comprar</button>
<?php else :  ?>
	<h2>Carrito vacío.</h2>
<?php endif; ?>
</div>
	
</div>