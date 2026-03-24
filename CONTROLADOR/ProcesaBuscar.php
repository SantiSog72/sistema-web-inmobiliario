<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require_once BASE_PATH.'CONTROLADOR/ControladorCatalogo.class.php';
// // include_once BASE_PATH.'libreria_php/verFormulario.php';


//transformadores de entrada ( de la GIU a datos procesables por la logica)
function Convertir_tipo_operacion ($valor_ingresado){
    switch ($valor_ingresado){
        case "alquiler":
                return "Alquiler";
            break;
        case "alquiler_amoblado":
            return "AlquilerAmoblado";
            break;
        case "venta":
            return "Venta";
            break;
        default:
            return null;
            break;
    }
}

function Convertir_zona($valor_ingresado){
    switch($valor_ingresado){
        case "Zona_Norte":
            return Ubicacion::ZONA_NORTE;
            break;
        case "Zona_Sur":
            return Ubicacion::ZONA_SUR;
            break;
        case "Zona_Centro":
            return Ubicacion::ZONA_CENTRO;
            break;
        case "Rada_Tilly":
            return Ubicacion::RADA_TILLY;
            break;
        default:
            return null;
            break;
    }
}

function Convertir_otras_caracteristicas() {
    return [
        "quincho"  => isset($_GET['quincho']),
        "lavadero" => isset($_GET['lavadero']),
        "patio"    => isset($_GET['patio']),
        "garage"   => isset($_GET['garage'])
    ];
}

function Convertir_tipo_propiedad(){
    $lista_procesable = [];
    if (isset($_GET['casa'])){$lista_procesable[] = "casa";}        
    if (isset($_GET['departamento'])){$lista_procesable[] = "departamento";}
    if (isset($_GET['oficina'])){$lista_procesable[] = "oficina";}       
    if (isset($_GET['terreno'])){$lista_procesable[] = "terreno";}       
    if (isset($_GET['cochera'])){$lista_procesable[] = "cochera";}       
    
    return $lista_procesable;
}


// function catalogo_to_tarjetasHTML($catalogo) {
//     $html = "";
    
//     foreach ($catalogo as $operacion) {
//         $inmueble = $operacion->get_inmueble();
//         $html .= "<div class=\"tarjeta_operacion\">";
//         $html .= "<p>" .
//             $operacion->get_titulo_publicacion() . " " .
//             $inmueble->get_ubicacion()->get_zona_texto() . " " .
//             (($operacion instanceof Venta) ? "venta " : "alquiler ") .
//             $operacion->get_precio() . "$(arg) " .
//         "</p>";
//         $html .= "<button class=\"boton\" type=\"button\">más info</button>";
//         $html .= "</div>";
//     }
    
//     return $html;
// }


// //recibe el formulario de busqueda

$controladorCatalogo = new ControladorCatalogo ();
$catalogo_completo = $controladorCatalogo -> get_lista_catalogo();
// En lugar de: if (isset($_GET['operacion']) || isset($_GET['zona']))

// Decidimos qué catálogo usar
if (isset($_GET['operacion']) || isset($_GET['zona'])) {
    $catalogo_a_procesar = $controladorCatalogo->filtra_operaciones(
        $_GET['operacion'],//falta amoblado
        $_GET['zona'],
        Convertir_tipo_propiedad(),
        Convertir_otras_caracteristicas()
    );
} else {
    // Si no hay filtros (carga inicial vía AJAX), usamos el completo
    $catalogo_a_procesar = $catalogo_completo;
}

$datos_json = [];
if (is_array($catalogo_a_procesar)){
    foreach ($catalogo_a_procesar as $operacion) {
        $inmueble = $operacion->get_inmueble();
        $datos_json[] = [
            "titulo" => $operacion->get_titulo_publicacion(),
            "zona"   => $inmueble->get_ubicacion()->get_zona_texto(),
            "tipo"   => ($operacion instanceof Venta) ? "Venta" : "Alquiler",
            "precio" => $operacion->get_precio(),
            "id"     => $inmueble->get_nro_inmueble()
        ];
    }
}

// // ... después del bucle foreach ...

// 1. Definimos la cabecera para que el navegador sepa que es JSON
header('Content-Type: application/json');
// 2. "Echamos" (imprimimos) el JSON. 
// Si $datos_json está vacío, imprimirá "[]", que es un JSON válido.
echo json_encode($datos_json);
// 3. Importante: Terminamos la ejecución para que no se cuele 
// ningún espacio o HTML extra después.
exit;



// // mostrar_info_formulario();

?>