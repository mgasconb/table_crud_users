<?php

foreach ($datos["sendero"] as $key => $pisada) {
	
	echo "<a href='{$pisada["url"]}'>{$pisada["etiqueta"]}</a>";
	if ($key < count($datos["sendero"]))
		echo " &gt;";
	
}