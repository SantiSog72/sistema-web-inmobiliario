<?php
// RUTA DE SERVIDOR (File System)
// __DIR__ siempre apunta a la carpeta donde está este archivo config.php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

// RUTA WEB (URL)
// Detecta el protocolo (http/https) y el dominio
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];

// Calculamos la carpeta del proyecto basándonos en la ubicación de este archivo
// Esto elimina la necesidad de escribir manualmente el nombre de la carpeta
$project_folder = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', __DIR__));
$project_folder = trim($project_folder, '/') . '/';

if (!defined('WEB_ROOT')) {
    define('WEB_ROOT', $protocol . $host . '/' . $project_folder);
}
?>