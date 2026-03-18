<?php
	
// date () devuelve un string del sia actual, sirve para dar formato a una fecha
class Inquilino {
	
    private $dni="";
	private $nombre="";
	private $apellido="";
    
	
	
	public function __construct ($dni, $nombre, $apellido){
		$this -> dni = $dni;
		$this -> nombre = $nombre;
		$this -> apellido = $apellido;
	}
	
	
	public function getDni (){
		return $this -> dni;
	}
	
	public function getNombre (){
		return $this -> nombre;
	}
	
	public function getApellido (){
		return $this -> apellido;
	}
	
	public function mostrar (){
		echo "dni: ".$this -> dni."<br>";
		echo "nombre: ".$this -> nombre."<br>";
		echo "apellido: ".$this -> apellido."<br>";
	}
}
?>