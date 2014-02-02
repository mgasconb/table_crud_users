
/*
 * @file: tables_and_user.sql
 * @author: jequeto@gmail.com
 * @since: 2012 enero
*/
-- drop database if exists daw2;
-- create database daw2;
-- 
-- create user daw2_user identified by 'daw2_user';
-- # Concedemos al usuario daw2_user todos los permisos sobre esa base de datos
-- grant all privileges on daw2.* to daw2_user;

use daw2;

set names utf8;

set sql_mode = 'traditional';

drop table if exists daw2_categorias;
create table if not exists daw2_categorias
( id integer unsigned  auto_increment
, nombre varchar(100) not null comment 'Texto que aparecerá en el menú, si esta vacío se toma nombre'
, foto varchar(50) null
, descripcion varchar(500) null
, primary key (id)
, unique (nombre)
)
engine = innodb
default charset = utf8
;


drop table if exists daw2_articulos;
create table if not exists daw2_articulos
( id integer unsigned  auto_increment
, categoria_id integer unsigned  not null
, nombre varchar(100) not null
, precio decimal(12,2) null default null comment 'incluyen IVA'
, unidades_stock integer null default null
, foto varchar(50) null
, descripcion varchar(500) null
, primary key (id)
, unique (nombre)
, foreign key (categoria_id) references daw2_categorias(id) on update cascade on delete cascade
)
engine = innodb
default charset = utf8
;


drop table if exists daw2_pedidos;
create table if not exists daw2_pedidos
( id integer unsigned auto_increment
, fecha_inicio timestamp not null default current_timestamp comment "Fecha de apertura del pediddo"
, fecha_compra datetime null 
, usuario_id integer unsigned not null
, primary key (id)
, foreign key (usuario_id) references daw2_usuarios(id)
)
engine = innodb
default charset=utf8
;

drop table if exists daw2_pedidos_detalles;
create table if not exists daw2_pedidos_detalles
( id integer unsigned auto_increment
, pedido_id integer unsigned not null
, articulo_id integer unsigned not null
, unidades integer unsigned not null default 1
, primary key (id)
, foreign key (pedido_id) references daw2_pedidos(id) on delete cascade
, foreign key (articulo_id) references daw2_articulos(id)
)
engine = innodb
default charset=utf8
;

