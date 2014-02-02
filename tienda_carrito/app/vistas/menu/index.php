<ul id="menu" class="menu">
	<?php
		foreach ($datos ["filas"] as $categoria) {
//			echo "<li class='item'><a href='".\core\URL::generar("expositor/categoria/{$categoria["id"]}")."' title='{$categoria["nombre"]}'>{$categoria["nombre"]}</a></li>\n";
			echo "<li class='item'><a href='".\core\URL::generar("expositor/categoria/{$categoria["nombre"]}/{$categoria["id"]}")."' title='{$categoria["nombre"]}'>{$categoria["nombre"]}</a></li>\n";
			
		}
	?>
</ul>