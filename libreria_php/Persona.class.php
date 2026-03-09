<?php
	
// date () devuelve un string del sia actual, sirve para dar formato a una fecha
class Persona {
	
	private $nombre="";
	private $dni="";
	private $apellido="";
	private $sexo = "";
	private $fechaNacimiento = null;
	private $nro_celular = 0;
	private $email = "";
	
	
	public function __construct ($dni, $nombre, $apellido, $sexo, $fechaNacimiento, $nro_celular, $email){
	
		$this -> dni = $dni;
		$this -> nombre = $nombre;
		$this -> apellido = $apellido;
		$this -> sexo = $sexo;
		$this -> fechaNacimiento = new DateTime ($fechaNacimiento); //YYYY-MM-DD
		$this -> nro_celular = $nro_celular;
		$this -> email = $email;
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
	
	public function getSexo (){
		return $this -> sexo;
	}
	
	public function getFechaNacimeinto (){
		return $this -> fechaNacimiento -> format ("Y-m-d");//YYYY-MM-DD
	}
	
	public function getNro_celular (){
		return $this -> nro_celular;
	}
	
	public function getEmail (){
		return $this -> email;
	}
	
	public function getEdad (){
		// date ("Y-m-d")//devuelve un string 
		// $hoy = getdate ();//devuelve array datos actuales
		$hoy = new DateTime ();//objeto

		$fecha_diferencia = $this -> fechaNacimiento -> diff ($hoy);//intervalo de fechas
		$edad = $fecha_diferencia -> format ("%y");//la cantidad de años de diferencia en el intervalo, tieniendo en cuenta: dias, meses y años

		return $edad;
	}
	
	public function mostrar (){
		echo "dni: ".$this -> dni."<br>";
		echo "nombre: ".$this -> nombre."<br>";
		echo "apellido: ".$this -> apellido."<br>";
		echo "sexo: ".$this -> sexo."<br>";
		echo "fecha nacimiento: ".$this -> getFechaNacimeinto()."<br>";
		echo "edad: ".$this -> getEdad()."<br>";
		echo "nro celular: ".$this -> nro_celular."<br>";
		echo "email: ".$this -> email."<br>";
	}
}
?>