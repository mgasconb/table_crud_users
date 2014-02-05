<?php
namespace controladores;

interface carrito_interface {

	
	
	
	public function meter(array $datos=array()) ;
	
	
	
	
	public function modificar_articulo(array $datos = array()) ;
	
	public function borrar_articulo(array $datos = array()) ;
	
	
	public function ver(array $datos = array()) ;
	
	
	
	public function borrar(array $datos = array()) ;
	
	
	/**
	 * Recupera el carrito guardado en la base de datos.
	 * Si el usuario logueado tenía un carrito como anónimo y un carrito como usuario logueado
	 * se recupera el de fecha más reciente y el otro se destruye.
	 */
	public function recuperar() ;
	
	
} // Fin de la clase