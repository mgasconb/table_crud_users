
/*
 * @file: tables_and_user.sql
 * @author: jequeto@gmail.com
 * @since: 2012 enero
*/
drop database if exists daw2;
create database daw2;

create user daw2_user identified by 'daw2_user';
# Concedemos al usuario daw2_user todos los permisos sobre esa base de datos
grant all privileges on daw2.* to daw2_user;

use daw2;

set names utf8;

set sql_mode = 'traditional';


drop table if exists daw2_usuarios;
CREATE TABLE daw2_usuarios (
id integer unsigned NOT NULL AUTO_INCREMENT,
login varchar(30) NOT NULL,
email varchar(100) NOT NULL,
password char(32) NOT NULL,
fecha_alta timestamp not null default current_timestamp(),
fecha_confirmacion_alta datetime default null,
clave_confirmacion char(30) null,
PRIMARY KEY (id),
UNIQUE KEY login (login),
UNIQUE KEY email (email)
)
engine=innodb
character set utf8 collate utf8_general_ci
;


-- Recursos almacena la colección de funcionalidades que es posible desarrollar en la aplicación.
drop table if exists daw2_metodos;
create table daw2_metodos
( id integer unsigned auto_increment not null
, controlador varchar(50) not null comment "Si vale * equivale a todos los controladores"
, metodo varchar(50) null comment "Si vale * equivale a todos los métodos de un controlador. Si nulo equivale a una sección sin submenú." 

, primary key (id)
, unique (controlador, metodo)

)
engine=innodb
character set utf8 collate utf8_general_ci
;

/*
 * Un rol es igual que un grupo de trabajo o grupo de usuarios.
 * Todos los usuarios serán miembros del rol usuario.
 */


drop table if exists daw2_roles;
create table daw2_roles
( id integer unsigned auto_increment not null
, rol varchar(50) not null
, descripcion varchar(255) null
, primary key (id)
, unique (rol)
)
engine=innodb
character set utf8 collate utf8_general_ci
;


/* seccion y subseccion se validarán en v_negocios_permisos */
drop table if exists daw2_roles_permisos;
create table daw2_roles_permisos
( id integer unsigned auto_increment not null
, rol varchar(50) not null
, controlador varchar(50) not null comment "Si vale * equivale a todos los controladores"
, metodo varchar(50) null comment "Si vale * equivale a todos los métodos de un controlador"
, primary key (id)
, unique(rol, controlador, metodo) -- Evita que a un rol se le asinge más de una vez un mismo permiso
, foreign key (rol) references daw2_roles(rol) on delete cascade on update cascade
, foreign key (controlador, metodo) references daw2_metodos(controlador, metodo) on delete cascade on update cascade
)
engine=innodb
character set utf8 collate utf8_general_ci
;

drop table if exists daw2_usuarios_roles;
create table daw2_usuarios_roles
( id integer unsigned auto_increment not null
, login varchar(20) not null
, rol varchar(50) not null

, primary key (id)
, unique (login, rol) -- Evita que a un usuario se le asigne más de una vez el mismo rol
, foreign key ( login) references daw2_usuarios(login) on delete cascade on update cascade
, foreign key ( rol) references daw2_roles(rol) on delete cascade on update cascade
)
engine=innodb
character set utf8 collate utf8_general_ci
;


-- Algunos hosting no dan el permiso de trigger por lo que habrá que implementarlo en programación php.
drop trigger if exists daw2_t_usuarios_ai;
delimiter //
create trigger daw2_t_usuarios_ai after insert on daw2_usuarios
for each row
begin
	insert into daw2_usuarios_roles (login, rol) values ( new.login, 'usuarios');
	if (new.login != "anonimo") then
		insert into daw2_usuarios_roles (login,  rol) values ( new.login, 'usuarios_logueados');
	end if;
end;

//
delimiter ;



drop table if exists daw2_usuarios_permisos;
create table daw2_usuarios_permisos
( id integer unsigned auto_increment not null
, login varchar(20) not null
, controlador varchar(50) not null comment "Si vale * equivale a todos los controladores"
, metodo varchar(50) null comment "Si vale * equivale a todos los métodos de un controlador"

, primary key (id)
, unique(login, controlador, metodo) -- Evita que a un usuario se le asignen más de una vez un permiso
, foreign key (login) references daw2_usuarios(login) on delete cascade on update cascade
, foreign key (controlador, metodo) references daw2_metodos(controlador, metodo) on delete cascade on update cascade

)
engine=innodb
character set utf8 collate utf8_general_ci
;


drop table if exists daw2_menu;
create table daw2_menu
( id integer unsigned not null
, es_submenu_de_id integer unsigned null
, nivel integer unsigned not null comment '1 menu principal, 2 submenú, ...'
, orden integer unsigned null comment 'Orden en que aparecerán'
, texto varchar(50) not null comment 'Texto a mostrar en el item del menú'
, accion_controlador varchar(50) not null
, accion_metodo varchar(50) null comment 'null si es una entrada de nivel 1 con submenu de nivel 2'
, title varchar(255) null
, primary key (id)
, foreign key (es_submenu_de_id) references daw2_menu(id)
, unique (es_submenu_de_id, texto) -- Para evitar repeticiones de texto
, unique (accion_controlador, accion_metodo) -- Si una acción/funcionalidad solo debe aparecer una vez en el menú
)
engine=innodb
character set utf8 collate utf8_general_ci
;




/* ******************************************* */
/* Para la aplicación tienda_carrito           */
/* ******************************************* */

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


-- Carritos: se usará para guardar objetos serializados de la clase ClaseCarrito
drop table if exists daw2_carritos;
create table if not exists daw2_carritos
( id varchar(100) not null comment "Será el id del usuario o el valor de PHPSESID"
, fechaHoraInicio timestamp not null default current_timestamp comment "Fecha de apertura del pediddo"
, texto blob not null
, primary key (id)
)
engine = innodb
default charset=utf8
;



drop table if exists daw2_pedidos;
create table if not exists daw2_pedidos
( id integer unsigned auto_increment
, fecha_hora_inicio timestamp not null default current_timestamp comment "Fecha de apertura del pediddo"
, fecha_hora_compra datetime null 
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
, nombre varchar(100) not null
, unidades integer unsigned not null default 1
, precio decimal(12,2) not null
, foto varchar(50) null
, primary key (id)
, foreign key (pedido_id) references daw2_pedidos(id) on delete cascade
, foreign key (articulo_id) references daw2_articulos(id)
)
engine = innodb
default charset=utf8
;

