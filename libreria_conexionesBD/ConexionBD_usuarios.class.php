<?php
	// singreton
class ConexionBD_usuarios{
	
	private $conexion = null; //conexion debe ser estatica
	private static $instacia = null; //instancia de la clase
	
	private function __construct (){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //para que mysql pueda lanzar excepciones
		$this -> conexion = new mysqli("localhost", "root", "", "db_usuarios") or die ("no es posible conectarse con el motor de BD");
		$this -> conexion->set_charset("utf8mb4");
	}
	
	public static function getInstancia (){
		if (self::$instacia == null){
			self::$instacia = new ConexionBD_usuarios();
		}//si esta la devuelvo
		return self::$instacia;
	}
	
	public function ingresarUsuario ($email, $contraseña, $nombre, $apellido, $sexo, $fecha_nacimiento, $nro_celular, $dni){		
		$query = "INSERT INTO usuario (email, contraseña, nombre, apellido, sexo, fecha_nacimiento, numero_celular, dni)";
		$query .= "VALUES ('".$email."','".$contraseña."','".$nombre."','".$apellido."','".$sexo."','".$fecha_nacimiento."','".$nro_celular."','".$dni."')";
		
		try { 
			$this -> conexion -> query($query) or die ("el usuario no se pude registrar correctamente");
			echo "el usuario se registro con exito";
			// echo "<script> alert (\"el usuario se registro con exito\");</script>";
		}catch(mysqli_sql_exception $e){
			// echo $e -> getMessage();
			if (str_contains ($e -> getMessage(),"Duplicate entry")){//verificar si existe la cuenta en la BD con una excepcion
				echo "<script> alert (\"No se pudo registrar, ya existe una cuenta con ese email\");</script>";
			}else{
				echo "<script> alert (\"surgio un error inesperado\");</script>";
			}
		}
	}
	
	//para las consultas que se hacen con datos ingresados del usuairo conviene utilizar consultas "preparadas"
	public function estaUsuario ($email){
		$consulta = $this -> conexion -> prepare ("SELECT COUNT(email) AS cantidad FROM usuario WHERE email = ?"); //prepara consulta
		$consulta -> bind_param ("s", $email); //relaciona $email con ? y le indica que es de tipo string (s)
		$consulta -> execute(); //ejecuta la consulta preparadas
		
		$resultado = $consulta -> get_result();//obtiene el resultado de la consulta preparada
		
		//resultado como array asociativo
		$array_resultado = $resultado -> fetch_array (MYSQLI_ASSOC);
		$resultado -> free();
		// echo $resultado -> num_rows; //obtiene el numero de filas
		return  ($array_resultado['cantidad'] > 0);
	}
	
	public function tieneSuscripciones (){
		
	}
	
	public function estaEvento ($nro_evento){
		$consulta = $this -> conexion -> prepare ("SELECT COUNT(nro_evento) AS cantidad FROM evento WHERE nro_evento = ?"); //prepara consulta
		$consulta -> bind_param ("s", $nro_evento); //relaciona $nro_evento con ? y le indica que es de tipo string (s)
		$consulta -> execute(); //ejecuta la consulta preparadas
		
		$resultado = $consulta -> get_result() or die ("no se puedo ejecutar la consulta");//obtiene el resultado de la consulta preparada
		
		//resultado como array asociativo
		$array_resultado = $resultado -> fetch_array (MYSQLI_ASSOC);
		$resultado -> free();
		// echo $resultado -> num_rows; //obtiene el numero de filas
		return  ($array_resultado['cantidad'] > 0);
	}
	
	
	
	public function obtenerUsuario ($email){
		if ($this -> estaUsuario($email)){
			$consulta = $this -> conexion -> prepare ("SELECT email, dni, nombre, apellido, sexo, fecha_nacimiento, numero_celular, contraseña FROM usuario WHERE email = ?");
			$consulta -> bind_param ("s", $email);
			$consulta -> execute();
			
			$resultado = $consulta -> get_result();//objeto MySQLi
			$usuario = $resultado -> fetch_object(); //objeto MySQLi_result 
			$resultado -> free();
			return $usuario;
		}
	}
	
	public function obtenerEventosUsuario ($email){
		if ($this -> estaUsuario($email)){
			$listaEventos = array();
			$consulta = $this -> conexion -> prepare ("SELECT e.nro_evento, nombre_evento, fecha_evento, lugar FROM evento e INNER JOIN suscripcion s ON e.nro_evento = s.nro_evento WHERE s.email = ?");
			$consulta -> bind_param("s", $email);
			$consulta -> execute();
			
			$resultado = $consulta -> get_result();
			
			while ($registro = $resultado -> fetch_object()){
				array_push ($listaEventos, $registro);
			}
			$resultado -> free();
			return $listaEventos;
		}
	}
	
	public function obtenerEventos (){
		$consulta = $this -> conexion -> prepare ("SELECT * FROM evento");
		$consulta -> execute();
		$resultado = $consulta -> get_result();
		
		$listaEventos = array();
		
		while ($registro = $resultado -> fetch_object()){
			array_push($listaEventos, $registro);
		}
		
		
		$resultado -> free();
		return $listaEventos;
	}
	
	public function obtenerEvento ($nro_evento){
		if ($this -> estaUsuario($nro_evento)){
			$consulta = $this -> conexion -> prepare ("SELECT * FROM evento WHERE nro_evento = ?");
			$consulta -> bind_param ("s", $nro_evento);
			$consulta -> execute();
			
			$resultado = $consulta -> get_result();
			$evento = $resultado -> fetch_object();
			$resultado -> free();
			return $evento;
			
		}
	}
	
	public function obtenerContraseña ($email){
		if ($this -> estaUsuario($email)){
			$consulta = $this -> conexion -> prepare ("SELECT contraseña FROM usuario WHERE email = ?");
			$consulta -> bind_param("s", $email);
			$consulta -> execute();
			$resultado = $consulta -> get_result(); //objeto MySQLi
			$registro = $resultado -> fetch_object(); //objeto MySQLi_result 
			
			
			//liverar objeto MySQLi
			$resultado -> free();
			return ($registro -> contraseña);
			
		}
	}
	
	public function agregar_eventoUsuario (){
	
	}
	
	public function __destruct (){
		if ($this -> conexion != null){
			$this -> conexion -> close();
			// echo "la coneccion se cerro con exito";		
		}
	}
	

}



?>