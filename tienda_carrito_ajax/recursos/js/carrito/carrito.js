/**
 * Función que gestiona la visualización dinámica del carrito.
 */
function carrito_ver() {
	
	jQuery.post(
		"/tienda_carrito_ajax/carrito/ver_ajax" 
		,{is_ajax: "true"}
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);
		}
	);
	
}


function carrito_vaciar() {
	
	jQuery.post(
		"/tienda_carrito_ajax/carrito/vaciar_ajax" 
		,{is_ajax: "true"}
		,function(data, textStatus, jqXHR) {
			$("#carrito").html(data);	
		}			
	);
	
}


function carrito_meter(form, event) {
	event.preventDefault();
//	alert("carrito_meter()");
	jQuery.post(
		"/tienda_carrito_ajax/carrito/meter_ajax" 
		,{articulo_id: form.elements.namedItem("articulo_id").value, nombre: form.elements.namedItem("nombre").value, precio: form.elements.namedItem("precio").value, unidades: form.elements.namedItem("unidades").value, is_ajax: "true" }
		,function(data, textStatus, jqXHR) {
//			alert("cargar_meter: "+data);	
			$("#carrito").html(data);
		}
	);
	
}


function carrito_modificar(formId, accion) {
//	form = $("#"+formId);
	form = document.getElementById(formId);
//	alert("form: "+formId+ "accion: "+accion+" Elementos: "+form.elements.length);
//	alert("form: "+formId+ "accion: "+accion+" Elementos: ");

	jQuery.post(
		"/tienda_carrito_ajax/carrito/modificar_ajax" 
		,{articulo_id: form.elements.namedItem("articulo_id").value, unidades: form.elements.namedItem("unidades").value, "accion": accion, is_ajax: "true" }
		,function(data, textStatus, jqXHR) {
//			alert("form_modificar");
			$("#carrito").html(data);	
		}
	);
	
}



function cargar_view_content(href) {
	
//	alert("cargar_view_content: "+href);
	jQuery.post(
		href
		,{is_ajax: "true"}
		,function(data, textStatus, jqXHR) {
//			alert("cargar_view_content: "+data);
			$("#view_content").html(data);	
		}
	);
	
}