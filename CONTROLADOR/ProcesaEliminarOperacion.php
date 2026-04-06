<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH. "MODELO/libreria_conexionesBD/ConexionBDD.class.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $conexion = ConexionBDD::getInstancia();
    $json_respuesta = [];

    if ($conexion -> borrar_inmueble($_POST['nro_inmueble'])){
        $json_respuesta = [
            "exito" => true,
            "mensaje"=> "El inmueble se elimino con exito"
        ];
    }else{
        $json_respuesta = [
            "exito" => false,
            "mensaje" => "No se pudo eliminar el inmueble"
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}

?>