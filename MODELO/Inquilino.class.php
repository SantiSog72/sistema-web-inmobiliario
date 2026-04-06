<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/Contacto.class.php';	
class Inquilino {
	
    private $dni="";
    private Contacto $contacto;
	
	
	public function __construct ($dni, $contacto){
		$this -> dni = $dni;
		$this -> contacto= $contacto;
	}
	
	
	public function getDni (){
		return $this -> dni;
	}

	public function getContacto(){
		return $this -> contacto;
	}
}
?>