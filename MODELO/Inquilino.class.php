<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/Contacto.class.php';	
class Inquilino {
	
    private $dni="";
	private $nombre="";
	private $apellido="";
    private Contacto $contacto;
	
	
	public function __construct ($dni, $nombre, $apellido, $contacto){
		$this -> dni = $dni;
		$this -> nombre = $nombre;
		$this -> apellido = $apellido;
		$this -> contacto= $contacto;
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

	public function getContacto(){
		return $this -> contacto;
	}
}
?>