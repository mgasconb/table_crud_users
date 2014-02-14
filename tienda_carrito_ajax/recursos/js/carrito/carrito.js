/**
 * Función que gestiona la visualización dinámica del carrito.
 */
function carrito_ver() {
	
	jQuery.post(
		"/tienda_carrito/carrito/ver_ajax" 
		,""
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
			
		}
	);
}


function carrito_vaciar() {
	
	jQuery.post(
		"/tienda_carrito/carrito/vaciar" 
		,""
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
			
		}
	);
}


function carrito_meter(form) {
	
	jQuery.post(
		"/tienda_carrito/carrito/meter" 
		,{articulo_id: form.articulo_id.value, nombre: form.nombre.value, precio: form.precio.value, unidades: form.unidades.value }
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
		}
	);
}


function carrito_modificar(form) {
	
	jQuery.post(
		"/tienda_carrito/carrito/modificar" 
		,{articulo_id: form.articulo_id.value, nombre: form.nombre.value, precio: form.precio.value, unidades: form.unidades.value, accion: form.accion.value }
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);	
		}
	);
}

function cargar_view_content(href) {
//	alert(href);
	jQuery.post(
		href
		,{is_ajax: "true"}
		,function(data, textStatus, jqXHR) {
			$("#view_content").html(data);	
		}
	);
}