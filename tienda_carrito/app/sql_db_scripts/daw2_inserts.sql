/*
 * @file: dables_and_user.sql
 * @author: jequeto@gmail.com
 * @since: 2012 enero
*/

use daw2;

set names utf8;
set sql_mode = 'traditional';


insert into daw2_metodos
  (controlador,		metodo) values
  ('expositor'		,'*')
, ('expositor'		,'categoria')
, ('carrito'		,'*')
, ('carrito'		,'index')
, ('carrito'		,'form_borrar_articulo')
, ('carrito'		,'form_anexar_articulo')
, ('carrito'		,'form_borrar_carrito')
, ('carrito'		,'form_comprar_carrito')
;


insert into daw2_roles_permisos
  (rol					,controlador		,metodo) values
  ('usuarios'			,'expositor'		,'*')
, ('usuarios'			,'carrito'			,'*')
;

insert into daw2_categorias
  ( nombre, descripcion ) values
  ('lacteos', null)
, ('frutas', null)
, ('legumbres', null)
, ('refrescos', null)
;


insert into daw2_articulos
  ( categoria_id, nombre,precio,unidades_stock ) values
  (1,'leche', 1,500)
, (1,'mantequilla', 0.5, 300)
, (3, 'garbanzos', 0.90, 500)
, (4, 'limonada', 1, 333)
;

