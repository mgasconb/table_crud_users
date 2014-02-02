/*
 * @file: views.sql
 * @author: jequeto@gmail.com
 * @since: 2014 enero
*/

use daw2;

create or replace view daw2_v_articulos
as
select a.*, c.nombre as categoria_nombre
from daw2_articulos a inner join daw2_categorias c on a.categoria_id = c.id
;
