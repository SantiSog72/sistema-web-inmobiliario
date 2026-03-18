<?php
require_once
require_once '../MODELO/Inmueble.class.php';
require_once '../MODELO/Foto.class.php';
require_once '../MODELO/Ubicacion.class.php';
require_once '../MODELO/.class.php';
require_once '../MODELO/Operacion.class.php';
//creacion de objetos
$foto1 = new Foto(1, "foto de la cocina", "../imagenes/departamento1_baño.jpg");
$foto2 = new Foto(1, "foto de la cocina", "../imagenes/departamento1_cocina.jpg");
$foto3 = new Foto(1, "foto de la cocina", "../imagenes/departamento1_comedor.jpg");
$foto4 = new Foto(1, "foto de la cocina", "../imagenes/departamento1_dormitorio.jpg");
$array_fotos_dpto1 = [$foto1, $foto2, $foto3, $foto4];

$ubicacion_dpto1 = new Ubicacion (1, "calle juan 123", "90.1234567");


array $lista_catalogo = [];

public function realizar_busqueda ($tipo_operacion, $tipo_propiedad, $ubicacion, $otras_caracteristicas){

}

public f

?>