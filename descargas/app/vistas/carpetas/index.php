<h1>Descargas disponibles en <?=$datos["carpeta"]?></h1>
<ul>
<?php
$metodo = ($datos["carpeta"] == "js") ? "js" : "file";
foreach ($datos["ficheros"] as $fichero => $contador_descargas) {
	echo "<li><a href='".\core\URL::generar("download/$metodo/{$datos["carpeta"]}/$fichero")."'>$fichero</a> Descargas: $contador_descargas</li>";
}
?>
</ul>