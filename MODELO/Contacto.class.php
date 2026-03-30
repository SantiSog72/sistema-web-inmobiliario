<?php
class Contacto {
	
    private string $nombre="";
    private string $apellido="";
	private string $nro_celular="";
	private string $email="";

	public function __construct ($nombre, $apellido, $nro_celular, $email){
		$this -> nombre = $nombre;
		$this -> apellido = $apellido;
		$this -> nro_celular = $nro_celular;
		$this -> email = $email;
	}

    public function get_nombre()         { return $this->nombre; }
    public function get_apellido()       { return $this->apellido; }

	public function getNro_celular (){
		return $this -> nro_celular;
	}
	
	public function getEmail (){
		return $this -> email;
	}
}
?>