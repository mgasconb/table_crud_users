<div>
    <h1>Listado de articulos</h1>

    <table border='1'>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido paterno</th>
                <th>Apellido materno</th>
                <th>Correo</th>
                <th>Nombre de usuario</th>
                <th>Contraseña</th>
                <th>Puntuacion</th>
                <th>Fecha registro</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($datos['filas'] as $fila) {
                echo "
					<tr>
						<td>{$fila['nombre']}</td>
						<td>{$fila['apellidoPaterno']}</td>
                                                <td>{$fila['apellidoMaterno']}</td>
                                                <td>{$fila['correo']}</td>
                                                <td>{$fila['username']}</td>
                                                <td>{$fila['password']}</td>
                                                <td>".\core\Conversiones::decimal_punto_a_coma_y_miles($fila['puntuacion'])."</td>
                                                <td>".\core\Conversiones::fecha_hora_mysql_a_es($fila['dt_registro'])."</td>
						<td>
                                                        ".\core\HTML_Tag::a_boton_onclick("boton", array("ranking", "form_modificar", $fila['id']), "modificar")."".
                                                        \core\HTML_Tag::a_boton_onclick("boton", array("ranking", "form_borrar", $fila['id']), "borrar").
						"</td>
					</tr>
					";
            }
            echo "
				<tr>
					<td colspan='8'></td>
					<td><a class='boton' href='?menu=ranking&submenu=form_insertar' >insertar</a></td>
				</tr>
			";
            ?>
        </tbody>
    </table>
</div>

<div id="pruebaDayana">
    <?php
        $filas=\modelos\Modelo_SQL::execute($consulta_sql);
        
    ?>
</div>