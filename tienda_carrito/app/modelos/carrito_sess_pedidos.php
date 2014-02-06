<?php

namespace modelos;

/**
 * Implementa el carrito a partir de las tablas pedidos y pedidos_detalles
 * 
 * Los carritos se guardan en la bd y se borrarán si tienen más de 15 días.
 *
 * @author Jesús María de Quevedo Tomé
 */
class carrito_sess_pedidos extends \modelos\Modelo_SQL implements \modelos\carrito_interface {
	
	private $id = null;
	private $fechaHoraInicio = null;
	private $articulos = array();
	
	
	public function __construct($id) {
		
		$this->id = $id;
		$this->fechaHoraInicio = date("Y-m-d H:i:s");
		$this->persistir();
	}
	
	
	public static function recuperar($id) {
		
		if ($this->id == \core\Usuario::$id) {
			// Usuario logueado
			$clausulas["where"] = "usuario_id = '{$this->id}'  and fecha_hora_compra is null ";
			$filas = self::table("pedidos")->select($clausulas);
			if ($filas) {
				// Creamos un carrito
				$carrito = new self($filas[0]["id"]);
				$carrito->fechaHoraInicio = $filas[0]["fecha_hora_inicio"];
				
				// Recuperamos detalles del pedido
				$clausulas["where"] = "pedido_id = '{$this->id}'  ";
				$detalles = self::table("pedidos_detalles")->select($clausulas);
				
				// Insertamos nuevos detalles del pedido
				foreach ($detalles as $detalle) {
					$this->articulos[$detalles["articulo_id"]]["nombre"] = $detalles["nombre"];
					$this->articulos[$detalles["articulo_id"]]["unidades"] = $detalles["unidades"];
					$this->articulos[$detalles["articulo_id"]]["foto"] = $detalles["foto"];
					$this->articulos[$detalles["articulo_id"]]["precio"] = $detalles["precio"];
				}
			}
		}
		else {
			// Usuario anónimo
			$_SESSION["carrito"]["id"] = $this->id;
			$_SESSION["carrito"]["fechaHoraInicio"] = $this->fechaHoraInicio;
			foreach ($this->articulos as $articulo_id => $articulo) {
				foreach ($articulo as $key => $value) {
					$_SESSION["carrito"][$articulo_id][$key] = $value;
				}
			}
		}
		
	}
	
	
	
	/**
	 * LLeva el pedido a las tablas pedidos y pedidos_detalles
	 */
	public function persistir() {
		
		if ($this->id == \core\Usuario::$id) {
			// Usuario logueado
			$clausulas["where"] = "usuario_id = '{$this->id}'  and fecha_hora_compra is null ";
			$filas = self::table("pedidos")->select($clausulas);
			if ($filas) {
				// Actualizamos datos del pedido
				$where = " id = {$filas[0]["id"]} ";
				self::tabla("pedidos")->update(array("fecha_hora_inicio" => $this->fechaHoraInicio));
				// Borramos detalles del pedido
				$clausulas["where"] = " pedido_id = {$filas[0]["id"]} ";
				self::tabla("pedidos_detalles")->delete($clausulas);
				// Insertamos nuevos detalles del pedido
				foreach ($this->articulos as $articulo_id => $articulo) {
						$fila["pedido_id"] = $filas[0]["id"];
						$fila["articulo_id"] = $articulo_id;
						$fila["nombre"] = $articulo["nombre"];
						$fila["unidades"] = $articulo["unidades"];
						$fila["precio"] = $articulo["precio"];
						$fila["foto"] = $articulo["foto"];
						self::tabla("pedidos_detalles")->insert($fila);
				}
			}
		}
		else {
			// Usuario anónimo
			$_SESSION["carrito"]["id"] = $this->id;
			$_SESSION["carrito"]["fechaHoraInicio"] = $this->fechaHoraInicio;
			foreach ($this->articulos as $articulo_id => $articulo) {
				foreach ($articulo as $key => $value) {
					$_SESSION["carrito"][$articulo_id][$key] = $value;
				}
			}
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
