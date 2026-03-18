<?php
class Contacto {
	
    private $nombre_contacto="";
	private $nro_celular="";
	private $email="";

	public function __construct ($nombre_contacto, $nro_celular, $email){
	
		$this -> nombre_contacto = $nombre_contacto;
		$this -> nro_celular = $nro_celular;
		$this -> email = $email;
	}

    public function getNombreContacto (){
		return $this -> nro_celular;
	}
	
	public function getNro_celular (){
		return $this -> nro_celular;
	}
	
	public function getEmail (){
		return $this -> email;
	}

	
	public function mostrar (){
		echo "nro contacto: ".$this -> nombre_contacto."<br>";
		echo "nro celular: ".$this -> nro_celular."<br>";
		echo "email: ".$this -> email."<br>";
	}
}
?>