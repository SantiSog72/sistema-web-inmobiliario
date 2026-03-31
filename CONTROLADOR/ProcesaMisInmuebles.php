<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'CONTROLADOR/ControladorCatalogo.class.php';

$controlador = new ControladorCatalogo();
$dni = $_SESSION['usuario']['dni'] ?? null;

if ($dni) {
    $controlador->Catalogo_de($dni);
    $datos_json = $controlador -> get_catalogo_JSON();
    echo json_encode($datos_json);
    exit;
} else {
    echo json_encode(["error" => "No autorizado"]);
    exit;
}
