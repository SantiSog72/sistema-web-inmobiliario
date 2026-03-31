<?php
// 1. RUTA DE SERVIDOR (Para require e include en PHP)
// __DIR__ nos da la ruta real en el disco (ej: C:\xampp\htdocs\sistema web inmobiliario\)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

// 2. RUTA WEB (Para el navegador: JS, CSS, Imágenes)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];

// Detectamos la carpeta del proyecto dinámicamente
// Esto convertirá "C:\xampp\htdocs\sistema web inmobiliario" en "/sistema web inmobiliario/"
$folder = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', __DIR__));
$folder = '/' . trim($folder, '/') . '/';

if (!defined('WEB_ROOT')) {
    // Usamos rawurldecode para asegurar que los espacios se traten correctamente si es necesario
    define('WEB_ROOT', $protocol . $host . $folder);
}
?>