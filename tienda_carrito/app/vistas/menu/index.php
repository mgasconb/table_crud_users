<ul id="menu" class="menu">
	<li class='item'><a href='<?php echo \core\URL::generar("inicio"); ?>' title='Inicio'>Inicio</a></li>
	<?php
		foreach ($datos ["filas"] as $categoria) {
//			echo "<li class='item'><a href='".\core\URL::generar("expositor/categoria/{$categoria["id"]}")."' title='{$categoria["nombre"]}'>{$categoria["nombre"]}</a></li>\n";
			echo "<li id='item{$categoria["id"]}' class='item'><a href='".\core\URL::generar("expositor/categoria/{$categoria["nombre"]}/{$categoria["id"]}")."' title='{$categoria["nombre"]}'>{$categoria["nombre"]}</a></li>\n";			
		}
	?>
</ul>