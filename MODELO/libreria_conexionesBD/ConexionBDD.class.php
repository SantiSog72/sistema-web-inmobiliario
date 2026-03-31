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
require_once BASE_PATH.'MODELO/Contacto.class.php';
require_once BASE_PATH.'MODELO/Mensaje.class.php';
require_once BASE_PATH.'MODELO/UsuarioAdministrador.class.php';

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

    public function obtener_alquileres($dni_usuario) {
        if ($dni_usuario != null){
            $consulta = $this->conexion->prepare("
                SELECT a.nro_operacion, a.titulo_publicacion, a.precio, a.disponibilidad, a.esta_amoblado, a.plazo,
                       i.nro_inmueble, i.tipo_propiedad, i.descripcion,
                       i.con_quincho, i.con_lavadero, i.con_patio, i.con_garage,
                       i.cord_latitud, i.cord_longitud, i.direccion, i.zona
                FROM alquiler a
                JOIN inmueble i ON a.nro_inmueble = i.nro_inmueble
                WHERE i.dni_usuario = ?
            ");
            $consulta->bind_param("s", $dni_usuario);
        }else{
            $consulta = $this->conexion->prepare("
                SELECT a.nro_operacion, a.titulo_publicacion, a.precio, a.disponibilidad, a.esta_amoblado, a.plazo,
                       i.nro_inmueble, i.tipo_propiedad, i.descripcion,
                       i.con_quincho, i.con_lavadero, i.con_patio, i.con_garage,
                       i.cord_latitud, i.cord_longitud, i.direccion, i.zona
                FROM alquiler a
                JOIN inmueble i ON a.nro_inmueble = i.nro_inmueble
                WHERE a.disponibilidad = 1
            ");
        }
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }
        $resultado->free();

        return $lista;
    }

    
    public function obtener_ventas($dni_usuario) {

        if ($dni_usuario != null){
            $consulta = $this->conexion->prepare("
                SELECT v.nro_operacion, v.titulo_publicacion, v.precio, v.disponibilidad, 
                    v.apto_credito_hipotecario,
                    i.nro_inmueble, i.tipo_propiedad, i.descripcion,
                    i.con_quincho, i.con_lavadero, i.con_patio, i.con_garage,
                    i.cord_latitud, i.cord_longitud, i.direccion, i.zona
                FROM venta v
                JOIN inmueble i ON v.nro_inmueble = i.nro_inmueble
                WHERE i.dni_usuario = ?
            ");//prepara consulta
            $consulta->bind_param("s", $dni_usuario);
        }else{
            $consulta = $this->conexion->prepare("
                SELECT v.nro_operacion, v.titulo_publicacion, v.precio, v.disponibilidad, 
                       v.apto_credito_hipotecario,
                       i.nro_inmueble, i.tipo_propiedad, i.descripcion,
                       i.con_quincho, i.con_lavadero, i.con_patio, i.con_garage,
                       i.cord_latitud, i.cord_longitud, i.direccion, i.zona
                FROM venta v
                JOIN inmueble i ON v.nro_inmueble = i.nro_inmueble
                WHERE v.disponibilidad = 1
            ");//prepara consulta
        }

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

    public function obtener_opciones_financiacion($nro_operacion) {
        $consulta = $this->conexion->prepare("
            SELECT rfv.nro_operacion, o.cod_financiacion, o.titulo_opcion_financiacion
            FROM r_financiacion_venta rfv 
            NATURAL JOIN opcion_financiacion o 
            WHERE nro_operacion = ?
            ORDER BY (rfv.nro_operacion)
        ");
        $consulta->bind_param("i", $nro_operacion);//relaciona $nro_operacion con ? y le indica que es de tipo integer (i)
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = $fila;
        }
        $resultado->free();
        return $lista;
    }

    public function obtener_usuarios() {
        $consulta = $this->conexion->prepare("
            SELECT dni, contrasena, nombre, apellido, nro_celular, email 
            FROM usuario_administrador
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

    public function ingresar_usuario(UsuarioAdministrador $usuario) {
        $consulta = $this->conexion->prepare("
            INSERT INTO usuario_administrador 
            (dni, contrasena, nombre, apellido, nro_celular, email)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $dni      = $usuario->get_dni();
        $pass     = $usuario->get_contrasena();
        
        $contacto = $usuario->get_contacto();
        $apellido = $contacto->get_apellido();
        $nombre   = $contacto->get_nombre();
        $celular  = $contacto->getNro_celular();
        $email    = $contacto->getEmail();

        $consulta->bind_param("ssssss", 
            $dni, 
            $pass, 
            $nombre, 
            $apellido, 
            $celular, 
            $email
        );

        if ($consulta->execute()) {
            return true; 
        } else {
            return false;
        }
    }

    public function ingresar_inmueble($inmueble, $usr_dni) {
        $consulta = $this->conexion->prepare("
        INSERT INTO inmueble 
        (dni_usuario, tipo_propiedad, descripcion, con_quincho, con_lavadero, 
        con_patio, con_garage, cord_latitud, cord_longitud, direccion, zona)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $caract    = $inmueble->get_otras_caracteristicas();
        $tipo      = $inmueble->get_tipo_propiedad();
        $desc      = $inmueble->get_descripcion();
        $quincho   = $caract['quincho'];
        $lavadero  = $caract['lavadero'];
        $patio     = $caract['patio'];
        $garage    = $caract['garage'];
        $lat       = $inmueble->get_ubicacion()->get_coordenadas_latitud();
        $lng       = $inmueble->get_ubicacion()->get_coordenadas_longitud();
        $direccion = $inmueble->get_ubicacion()->get_direccion();
        $zona      = $inmueble->get_ubicacion()->get_zona();

        $consulta->bind_param("sssiiiissss",
            $usr_dni, $tipo, $desc, $quincho, $lavadero, $patio, $garage,
            $lat, $lng, $direccion, $zona
        );
        $consulta->execute();
        return $this->conexion->insert_id;
    }

    public function ingresar_fotos($fotos, $nro_inmueble) {
        $consulta = $this->conexion->prepare("
            INSERT INTO foto (nombre_foto, path, nro_inmueble)
            VALUES (?, ?, ?)
        ");
        foreach ($fotos as $foto) {
            $nombre = $foto->get_descripcion_foto();
            $path   = $foto->get_path_foto();
            $consulta->bind_param("ssi", $nombre, $path, $nro_inmueble);
            $consulta->execute();
        }
    }

    public function ingresar_alquiler($alquiler, $nro_inmueble) {
        $consulta = $this->conexion->prepare("
            INSERT INTO alquiler 
                (nro_inmueble, titulo_publicacion, precio, disponibilidad, 
                esta_amoblado, plazo)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $titulo     = $alquiler->get_titulo_publicacion();
        $precio     = $alquiler->get_precio();
        $disponible = 1;
        $amoblado   = $alquiler->get_esta_amoblado() ? 1 : 0;
        $plazo      = $alquiler->get_plazo();

        $consulta->bind_param("isiiii",
            $nro_inmueble, $titulo, $precio, $disponible, $amoblado, $plazo
        );
        $consulta->execute();
        return $this->conexion->insert_id;
    }

    public function ingresar_venta($venta, $nro_inmueble) {
        $consulta = $this->conexion->prepare("
            INSERT INTO venta 
                (nro_inmueble, titulo_publicacion, precio, disponibilidad, 
                apto_credito_hipotecario)
            VALUES (?, ?, ?, ?, ?)
        ");
        $titulo     = $venta->get_titulo_publicacion();
        $precio     = $venta->get_precio();
        $disponible = 1;
        $apto       = $venta->get_apto_credito_hipotecario() ? 1 : 0;

        $consulta->bind_param("isiii",
            $nro_inmueble, $titulo, $precio, $disponible, $apto
        );
        $consulta->execute();
        return $this->conexion->insert_id;
    }

    public function ingresar_opciones_financiacion($nro_operacion, $opciones) {
        $consulta = $this->conexion->prepare("
            INSERT INTO r_financiacion_venta (nro_operacion, cod_financiacion)
            VALUES (?, ?)
        ");
        foreach ($opciones as $opcion) {
            $cod = $opcion->get_cod_financiacion();
            $consulta->bind_param("is", $nro_operacion, $cod);
            $consulta->execute();
        }
    }

    public function ingresar_mensaje ($mensaje){
        $consulta = $this -> conexion -> prepare("
            INSERT INTO mensaje (nro_inmueble, fecha_hora, nombre, apellido, email, nro_celular, Cuerpo_mensaje, visto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $nro_inmueble =   $mensaje -> getNroInmueble();
        $fechaHora =      $mensaje ->getFechaHora();
        $cuerpo_mensaje = $mensaje ->getCuerpoMensaje();
        $visto =          $mensaje ->getVisto();
        
        $contacto = $mensaje -> getContacto();

        $nombre = $contacto ->get_nombre();
        $apellido = $contacto ->get_apellido();
        $email = $contacto ->getEmail();
        $nro_celular = $contacto ->getNro_celular();

        $consulta->bind_param("issssssi",
            $nro_inmueble, $fechaHora, $nombre, $apellido, $email, $nro_celular, $cuerpo_mensaje, $visto
        );
        return $consulta->execute();
    }

    public function obtener_mensajes ($dni_usuario) {
        $consulta = $this -> conexion -> prepare("
            SELECT i.nro_inmueble, i.direccion, i.dni_usuario, m.nro_mensaje, m.fecha_hora,
           m.nombre, m.apellido, m.email, m.nro_celular, m.Cuerpo_mensaje, m.visto
            FROM mensaje m 
            NATURAL JOIN inmueble i 
            WHERE i.dni_usuario = ?
        ");
        

        $consulta->bind_param("s",
            $dni_usuario
        );
        $consulta->execute();
        $resultado = $consulta -> get_result();
        $lista_mensajes = [];
        while($fila = $resultado -> fetch_assoc()){
            $lista_mensajes [] = $fila;
        }
        $resultado -> free();
        return $lista_mensajes;
    }

    public function obtener_todas_opciones_financiacion() {
        $consulta = $this->conexion->prepare("
            SELECT cod_financiacion, titulo_opcion_financiacion 
            FROM opcion_financiacion
        ");
        $consulta->execute();
        $resultado = $consulta->get_result();
        $lista = [];
        while ($fila = $resultado->fetch_assoc()) {
            $lista[] = new Opcion_financiacion(
                $fila['cod_financiacion'],
                $fila['titulo_opcion_financiacion']
            );
        }
        $resultado->free();
        return $lista;
    }
    
    public function borrar_inmueble ($nro_inmueble){
        $consulta= $this -> conexion -> prepare("
            DELETE FROM inmueble i WHERE i.nro_inmueble = ?
        ");
        $consulta -> bind_param('i',$nro_inmueble);
        $consulta -> execute();
    }

    public function obtener_usuario ($dni_usuario){
        $consulta = $this -> conexion -> prepare("
            SELECT *
            FROM usuario_administrador ua
            WHERE ua.dni = ?
        ");
        $consulta -> bind_param("s", $dni_usuario);
        $consulta -> execute();
        $resultado = $consulta -> get_result();
        $usuario = $resultado -> fetch_assoc();
        $resultado->free();
        return $usuario;
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
