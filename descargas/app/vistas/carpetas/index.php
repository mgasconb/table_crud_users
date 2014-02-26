<h1>Descargas disponibles en <?=$datos["carpeta"]?></h1>
<ul>
<?php
foreach ($datos["ficheros"] as $fichero => $contador_descargas) {
	echo "<li><a href='".\core\URL::generar("download/file/{$datos["carpeta"]}/$fichero")."'>$fichero</a> Descargas: $contador_descargas</li>";
}
?>
</ul>