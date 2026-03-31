<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conexion = ConexionBDD::getInstancia();
    $usuario_bdd = $conexion->obtener_usuario($_POST['dni']);
    
    $json_respuesta = [
        "exito" => false,
        "mensaje" => "El usuario o la contraseña es incorrecta"
    ];

    if ($usuario_bdd){
        if ($usuario_bdd['contrasena'] === $_POST['contrasena']){

            $json_usuario = [
                "dni" => $usuario_bdd['dni'],
                "nombre" => $usuario_bdd['nombre'],
                "apellido" => $usuario_bdd['apellido']
            ];

            $json_respuesta = [
                "exito" => true,
                "usuario" => $json_usuario,
                "mensaje" => "Ingreso exitoso"//para el console.log
            ];

            $_SESSION["usuario"] = $json_usuario;
        }
    }
    // Enviamos la respuesta
    header('Content-Type: application/json');
    echo json_encode($json_respuesta);
    exit;
}
?>