<?php
session_start();

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
$dni_usuario = $_SESSION["usuario"]["dni"];
$conexion = ConexionBDD::getInstancia();
$lista_mensajes_JSON = $conexion -> obtener_mensajes($dni_usuario );
$datos_JSON = [];

header('Content-Type: application/json');
echo json_encode($lista_mensajes_JSON);
exit;
?>