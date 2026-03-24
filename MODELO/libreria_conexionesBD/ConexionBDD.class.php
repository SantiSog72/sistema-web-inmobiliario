<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require_once BASE_PATH.'MODELO/Inmueble.class.php';
require_once BASE_PATH.'MODELO/Foto.class.php';
require_once BASE_PATH.'MODELO/Ubicacion.class.php';
require_once BASE_PATH.'MODELO/Operacion.class.php';
require_once BASE_PATH.'MODELO/Alquiler.class.php';
require_once BASE_PATH.'MODELO/Venta.class.php';

class ConexionBDD {
    // singleton
    private $conexion = null;
    private static $instancia = null; //instancia de la clase debe ser estatica

    private function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);//para que mysql pueda lanzar excepciones
        $this->conexion = new mysqli("localhost", "root", "", "db_sistema_inmobiliaria");
        $this->conexion->set_charset("utf8mb4");
    }

    public static function getInstancia() {
        if (self::$instancia == null) {
            self::$instancia = new ConexionBDD();
        }//si esta la devuelvo
        return self::$instancia;
    }

    public function obtener_alquileres() {
        $consulta = $this->conexion->prepare("
            SELECT a.nro_operacion, a.titulo_publicacion, a.precio, a.disponibilidad, a.esta_amoblado, a.opcion_financiacion, a.plazo,
                   i.nro_inmueble, i.tipo_propiedad, i.descripcion,
                   i.con_quincho, i.con_lavadero, i.con_patio, i.con_garage,
                   i.cord_latitud, i.cord_longitud, i.direccion, i.zona
            FROM alquiler a
            JOIN inmueble i ON a.nro_inmueble = i.nro_inmueble
            WHERE a.disponibilidad = 1
        ");
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }
        $resultado->free();

        return $lista;
    }

    public function obtener_ventas() {
        $consulta = $this->conexion->prepare("
            SELECT v.nro_operacion, v.titulo_publicacion, v.precio, v.disponibilidad, v.opcion_financiacion, 
                   v.apto_credito_hipotecario,
                   i.nro_inmueble, i.tipo_propiedad, i.descripcion,
                   i.con_quincho, i.con_lavadero, i.con_patio, i.con_garage,
                   i.cord_latitud, i.cord_longitud, i.direccion, i.zona
            FROM venta v
            JOIN inmueble i ON v.nro_inmueble = i.nro_inmueble
            WHERE v.disponibilidad = 1
        ");//prepara consulta
        $consulta->execute();//ejecuta la consulta preparada
        $resultado = $consulta->get_result();//objeto MySQLi
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {//saca fila a fila del resultado tomandolo como un array asociativo
		//tambien se puede hacer con el fetch_objet
            $lista[] = $fila;
        }
        $resultado->free();
        return $lista;
    }

    public function obtener_fotos($nro_inmueble) {
        $consulta = $this->conexion->prepare("
            SELECT nro_foto, nombre_foto, path
            FROM foto
            WHERE nro_inmueble = ?
        ");
        $consulta->bind_param("i", $nro_inmueble);//relaciona $nro_inmueble con ? y le indica que es de tipo integer (i)
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }
        $resultado->free();
        return $lista;
    }

	// public function ingresarUsuario ($email, $contraseña, $nombre, $apellido, $sexo, $fecha_nacimiento, $nro_celular, $dni){		
	// 	$query = "INSERT INTO usuario (email, contraseña, nombre, apellido, sexo, fecha_nacimiento, numero_celular, dni)";
	// 	$query .= "VALUES ('".$email."','".$contraseña."','".$nombre."','".$apellido."','".$sexo."','".$fecha_nacimiento."','".$nro_celular."','".$dni."')";
		
	// 	try { 
	// 		$this -> conexion -> query($query) or die ("el usuario no se pude registrar correctamente");
	// 		echo "el usuario se registro con exito";
	// 		// echo "<script> alert (\"el usuario se registro con exito\");</script>";
	// 	}catch(mysqli_sql_exception $e){
	// 		// echo $e -> getMessage();
	// 		if (str_contains ($e -> getMessage(),"Duplicate entry")){//verificar si existe la cuenta en la BD con una excepcion
	// 			echo "<script> alert (\"No se pudo registrar, ya existe una cuenta con ese email\");</script>";
	// 		}else{
	// 			echo "<script> alert (\"surgio un error inesperado\");</script>";
	// 		}
	// 	}
	// }
	
	// //para las consultas que se hacen con datos ingresados del usuairo conviene utilizar consultas "preparadas"
	// public function estaUsuario ($email){
	// 	$consulta = $this -> conexion -> prepare ("SELECT COUNT(email) AS cantidad FROM usuario WHERE email = ?"); //prepara consulta
	// 	$consulta -> bind_param ("s", $email); //relaciona $email con ? y le indica que es de tipo string (s)
	// 	$consulta -> execute(); //ejecuta la consulta preparadas
		
	// 	$resultado = $consulta -> get_result();//obtiene el resultado de la consulta preparada
		
	// 	//resultado como array asociativo
	// 	$array_resultado = $resultado -> fetch_array (MYSQLI_ASSOC);
	// 	$resultado -> free();
	// 	// echo $resultado -> num_rows; //obtiene el numero de filas
	// 	return  ($array_resultado['cantidad'] > 0);
	// }

    public function __destruct() {
        if ($this->conexion != null) {
            $this->conexion->close();
        }
    }
}
?>
