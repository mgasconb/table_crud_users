/**
 * Función que gestiona la visualización dinámica del carrito.
 */
function carrito_ver() {
	/* Cargamos la sección mediante ajax */
	jQuery.get(
		"/tienda_carrito/carrito/ver" 
		,null
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
			
		}
	);
}


function carrito_ver() {
	/* Cargamos la sección mediante ajax */
	jQuery.get(
		"/tienda_carrito/carrito/ver" 
		,null
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
			
		}
	);
}


function carrito_meter(form) {
	/* Cargamos la sección mediante ajax */
	jQuery.get(
		"/tienda_carrito/carrito/meter" 
		,null
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
			
		}
	);
}


function carrito_modificar(form) {
	/* Cargamos la sección mediante ajax */
	jQuery.get(
		"/tienda_carrito/carrito/modificar" 
		,null
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);	
		}
	);
}

