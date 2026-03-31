<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
$dni_usuario = $_SESSION["usuario"]["dni"];
$conexion = ConexionBDD::getInstancia();
$lista_mensajes_JSON = $conexion -> obtener_mensajes($dni_usuario);

header('Content-Type: application/json');
echo json_encode($lista_mensajes_JSON);
exit;
?>