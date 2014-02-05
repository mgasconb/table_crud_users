<?php

namespace modelos;

/**
 * Description of ClaseCarrito
 * 
 * Los carritos se guardan en la bd y se borrarán si tienen más de 15 días.
 *
 * @author jesus
 */
class carrito_objeto extends \modelos\Modelo_SQL implements \modelos\carrito_interface {
	
	private $id = null;
	private $fechaHoraInicio = null;
	private $articulos = array();
	
	
	public function __construct($id) {
		
		$this->id = $id;
		$this->fechaHoraInicio = date("Y-m-d H:i:s");
		$this->persistir();
	}
	
	
	public static function recuperar($id) {
		
		if ($id) {
			$clausulas["where"] = " id = '$id' ";
			$filas = \modelos\Modelo_SQL::table("carritos")->select($clausulas);
			if (isset($filas[0])) {
				return(unserialize($filas[0]["texto"]));
			}
		}
		
	}
	
	
	
	
	public function persistir() {
		
		$texto = $this->escape_string((serialize($this)));
		
		$clausulas["where"] = "id = '{$this->id}' ";
		$filas = self::table("carritos")->select($clausulas);
		if (count($filas)) {
			$this->tabla("carritos")->update(array("id" => $this->id, "fechaHoraInicio" => $this->fechaHoraInicio, "texto" => $texto));
		}
		else {
			$this->tabla("carritos")->insert(array("id" => $this->id, "fechaHoraInicio" => $this->fechaHoraInicio, "texto" => $texto));
		}
		
	}
	
	public function cambiar_id($id) {
		
		$where = "  id = '{$this->id}' ";
		$this->update(array("id" => $this->id), "carritos", $where);
		$this->id = $id;
		
	}
	
	
	
	
	public function meter($articulo) {
		
		if (array_key_exists($articulo["articulo_id"], $this->articulos)) {
			$this->articulos[$articulo["articulo_id"]]["unidades"] += $articulo["unidades"];
		}
		else {
			$this->articulos[$articulo["articulo_id"]]["nombre"] = $articulo["nombre"];
			$this->articulos[$articulo["articulo_id"]]["unidades"] = $articulo["unidades"];
			$this->articulos[$articulo["articulo_id"]]["precio"] = $articulo["precio"];
		}
		if ($this->articulos[$articulo["articulo_id"]]["unidades"] == 0) {
			unset($this->articulos[$articulo["articulo_id"]]);
		}
		$this->persistir();
		
	}
	
	
	
	
	public function corregir($articulo) {
		
		if (array_key_exists($articulo["articulo_id"], $this->articulos)) {
			$this->articulos[$articulo["articulo_id"]]["unidades"] = $articulo["unidades"];
			if ($this->articulos[$articulo["articulo_id"]]["unidades"] <= 0) {
				unset($this->articulos[$articulo["articulo_id"]]);
			}
			$this->persistir();
		}
			
	}
	
	
	
	public function quitar($articulo) {
		
		unset($this->articulos[$articulo["articulo_id"]]);
		$this->persistir();
		
	}
	
	
	public function vaciar() {
		
		$this->articulos = array();
		$this->persistir();
		
	}
	
	
	
	public function contador_articulos() {
		
		return count($this->articulos);
		
	}
	
	
	
	public function get_articulos() {
		
		return $this->articulos;
		
	}
	
	
	public function get_fechaHoraInicio() {
		
		return $this->fechaHoraInicio;
		
	}
	
}