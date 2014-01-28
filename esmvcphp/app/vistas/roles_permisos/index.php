<div >
	<h2>Listado de permisos del rol <?php echo $datos["rol"]; ?></h2>
	<?php include "form_and_inputs.php"; ?>
	<script type='text/javascript'>
		$(" [type=checkbox] ").attr("disabled", "disabled");
		$(" [type=submit], [type=reset] ").css("display", "none");
	</script>
</div>