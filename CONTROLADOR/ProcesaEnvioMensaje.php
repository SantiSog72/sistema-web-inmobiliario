<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
require_once BASE_PATH.'MODELO/Mensaje.class.php';
require_once BASE_PATH.'MODELO/Contacto.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $contacto = new Contacto(
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['nro_celular'],
        $_POST['email']
    );
    
    $mensaje = new Mensaje(
        $_POST['nro_inmueble'],
        $contacto,
        $_POST['cuerpo_mensaje']
    );
    

    

    $conexion = ConexionBDD::getInstancia();
    $json_respuesta = [];
    if ($conexion -> ingresar_mensaje($mensaje)){
        $json_respuesta = [
            "exito" => true,
            "mensaje" => "Se envio el mensaje correctamente"
        ];
    }else{
        $json_respuesta = [
            "exito" => false,
            "mensaje" => "No se pudo enviar el mensaje"
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}
?>