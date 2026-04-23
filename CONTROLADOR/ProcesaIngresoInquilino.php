<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/Contacto.class.php';	
require_once BASE_PATH.'MODELO/Inquilino.class.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';


if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $conexion = ConexionBDD::getInstancia();
    $nro_operacion = $_POST['nro_operacion'];

    $contacto = new Contacto(
        $_POST['nombre'], 
        $_POST['apellido'], 
        $_POST['nro_celular'], 
        $_POST['email']
    );

    $inquilino = new Inquilino(
        $_POST['dni'],
        $contacto
    );

    $json_respuesta = [];
    try {
        if ($conexion -> ingresar_inquilino($nro_operacion, $inquilino)){
            $json_respuesta = [
                "exito" => true,
                "mensaje" => "El inquilino se registro correctamente"
            ];
        }else{
            $json_respuesta = [
                "exito" => false,
                "mensaje" => "No se pudo registrar el inquilino"
            ];
        }

    }catch(PDOException $e){

        $json_respuesta = [
            "exito" => false,
            "mensaje" => "El dni del inquilino ya estaba registrado"
        ];
        header('Content-Type: application/json');
        echo json_encode($json_respuesta);
        exit;

    }

    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}

?>