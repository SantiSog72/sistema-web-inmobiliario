<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require_once BASE_PATH.'CONTROLADOR/ControladorCatalogo.class.php';
// include_once BASE_PATH.'libreria_php/verFormulario.php';

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


//recibe el formulario de busqueda
$controladorCatalogo = new ControladorCatalogo ();
$catalogo_completo = $controladorCatalogo -> get_lista_catalogo();
// En lugar de: if (isset($_GET['operacion']) || isset($_GET['zona']))

// Decidimos qué catálogo usar
if (isset($_GET['operacion']) || isset($_GET['zona'])) {
    $catalogo_a_procesar = $controladorCatalogo->filtra_operaciones(
        $_GET['operacion'],
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

        // 1. Convertir fotos a array
        $fotos_array = [];
        foreach ($inmueble->get_fotos() as $foto) {
            $fotos_array[] = [
                "nro_foto"    => $foto->get_numero_foto(),
                "descripcion" => $foto->get_descripcion_foto(),
                "path"        => $foto->get_path_foto()
            ];
        }

        // 2. Definir atributos según la instancia
        $atributos_unicos = [];
        if ($operacion instanceof Alquiler){
            $atributos_unicos = [
                "plazo"         => $operacion->get_plazo(),
                "esta_amoblado" => $operacion->get_esta_amoblado()
            ];
        } elseif ($operacion instanceof Venta){
            $opciones_financiacion =[];
            foreach($operacion -> get_opcion_financiacion() as $opcion){
                $opciones_financiacion []= [
                    "cod_financiacion"             => $opcion -> get_cod_financiacion(),
                    "titulo_opcion_financiacion"   => $opcion -> get_titulo_opcion_financiacion()
                ];
            }
            $atributos_unicos = [
                "apto_credito" => $operacion->get_apto_credito_hipotecario(),
                "financiacion" => $opciones_financiacion, 
            ];
        }

        // 3. Armamos el bloque base
        $bloque_base = [
            "titulo"       => $operacion->get_titulo_publicacion(),
            "id_operacion" => $operacion->get_nro_operacion(),
            "tipo"         => ($operacion instanceof Venta) ? "Venta" : "Alquiler",
            "precio"       => $operacion->get_precio(),
            "inmueble"     => [
                "nro_inmueble"   => $inmueble->get_nro_inmueble(),
                "tipo_propiedad" => $inmueble->get_tipo_propiedad(),
                "descripcion"    => $inmueble->get_descripcion(),
                "ubicacion"      => [
                    "coordenadas_latitud" => $inmueble->get_ubicacion()->get_coordenadas_latitud(),
                    "coordenadas_longitud" => $inmueble->get_ubicacion()->get_coordenadas_longitud(),
                    "zona"        => $inmueble->get_ubicacion()->get_zona_texto(),
                    "direccion"   => $inmueble->get_ubicacion()->get_direccion(),
                ],
                "otras_caracteristicas" => $inmueble->get_otras_caracteristicas(),
                "lista_fotos" => $fotos_array
            ]
        ];

        // 4. COMBINAMOS TODO
        // array_merge une los dos arrays en uno solo
        $datos_json[] = array_merge($bloque_base, $atributos_unicos);
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