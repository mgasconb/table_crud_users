<ul>
<?php
foreach ($datos["carpetas"] as $carpeta) {
	echo "<li><a href='".\core\URL::generar("carpetas/index/$carpeta")."'>$carpeta</a></li>";
}
?>
</ul>