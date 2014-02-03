<?php

namespace modelos;

/**
 * Description of clasecarrito
 *
 * @author jesus
 */
class ClaseCarrito extends \modelos\Modelo_SQL {
	
	private $id = null;
	private $fechaHoraInicio = null;
	private $articulos = array();
	
	
	
	public function recuperar($id) {
		
		$clausulas["where"] = "id = '$id' ";
		$filas = self::table("carritos")->select($clausulas);
		if (count($filas)) {
			$this = userialize($filas[0]["texto"]);
		}
		else {
			$this->id = $id;
			$this->fechaHoraInicio = date("Y-m-d H:i:s");
		}
	}
	
	
	public function persistir() {
		$texto = serialize($this);
		
		$clausulas["where"] = "id = '{$this->id}' ";
		$filas = self::table("carritos")->select($clausulas);
		if (count($filas)) {
			$this->tabla("carritos")->update(array("id" => $this->id, "fechaHoraInicio" => $this->fechaHoraInicio, "texto" => $texto));
		}
		else {
			$this->tabla("carritos")->insert(array("id" => $this->id, "fechaHoraInicio" => $this->fechaHoraInicio, "texto" => $texto));
		}
	}
	
	public function cambiar($id) {
		
		if ( ! $this->id ) {
			$this->recuperar($id);
			$this->persistir();
		}
		else {
			$where = "  id = '{$this->id}' ";
			$this->update(array("id" => $this->id), "carritos", $where);
			$this->id = $id;
		}
		
	}
	
	public function anexar_articulo($articulo) {
		
		if ( ! $this->id ) {
			$this->recuperar();
		}
		if (array_key_exists($articulo["id"], $this->articulos)) {
			$this->articulos[$id]["unidades"] += $articulo["unidades"];
		}
		else {
			$this->articulos[$id]["nombre"] = $articulo["nombre"];
			$this->articulos[$id]["unidades"] = $articulo["unidades"];
			$this->articulos[$id]["precio"] = $articulo["precio"];
		}
		if ($this->articulos[$id]["unidades"] == 0) {
			unset($this->articulos[$id]);
		}
		$this->persistir();
		
	}
	
	
	public function borrar_articulo($articulo) {
		
		if (array_key_exists($articulo["id"], $this->articulos)) {
			unset($this->articulos[$id]);
			$this->persistir();
		}
	}
}
