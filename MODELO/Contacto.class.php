<?php
class Contacto {
	
    private string $nombre_contacto="";
	private string $nro_celular="";
	private string $email="";

	public function __construct ($nombre_contacto, $nro_celular, $email){
	
		$this -> nombre_contacto = $nombre_contacto;
		$this -> nro_celular = $nro_celular;
		$this -> email = $email;
	}

    public function getNombreContacto (){
		return $this -> nombre_contacto;
	}
	
	public function getNro_celular (){
		return $this -> nro_celular;
	}
	
	public function getEmail (){
		return $this -> email;
	}
}
?>