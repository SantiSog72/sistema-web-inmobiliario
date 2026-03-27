<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require_once BASE_PATH . 'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
require_once BASE_PATH . 'MODELO/Opcion_financiacion.class.php';

header('Content-Type: application/json');

$bd = ConexionBDD::getInstancia();
$opciones = $bd->obtener_todas_opciones_financiacion();

$datos = [];
foreach ($opciones as $opcion) {
    $datos[] = [
        "cod"    => $opcion->get_cod_financiacion(),
        "titulo" => $opcion->get_titulo_opcion_financiacion()
    ];
}

echo json_encode($datos);
?>