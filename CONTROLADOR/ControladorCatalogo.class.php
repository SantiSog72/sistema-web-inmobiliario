<?php
// rel: (se toma desde donde se llama) a pesar de estar ubicado en controlador, toma desde donde esta el archivo index
// abs: se toma desde el inicio del direcotrio xamp
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
require_once BASE_PATH.'MODELO/Inmueble.class.php';
require_once BASE_PATH.'MODELO/Foto.class.php';
require_once BASE_PATH.'MODELO/Ubicacion.class.php';
require_once BASE_PATH.'MODELO/Operacion.class.php';
require_once BASE_PATH.'MODELO/Alquiler.class.php';
require_once BASE_PATH.'MODELO/Venta.class.php';
require_once BASE_PATH.'MODELO/Opcion_financiacion.class.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

class ControladorCatalogo {

    private array $lista_catalogo = [];
    // el catalogo al crearse trae de la bdd la lista y se la autoasigna
    public function __construct(){
        $this->cargar_datos_desde_bd();
    }

    public function get_lista_catalogo() {
        return $this->lista_catalogo;
    }

    public function get_catalogo_JSON(){
        $datos_json = [];
        $catalogo = $this -> get_lista_catalogo();
        if (is_array($catalogo)){
            foreach ($catalogo as $operacion) {
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
                    "disponible"=> $operacion -> get_disponibilidad(),
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
        return $datos_json;
    }


    public function filtra_operaciones($tipo_operacion, $zona, $lista_tipo_propiedad, $lista_otras_caracteristicas) {
        $resultados = [];

        foreach ($this->lista_catalogo as $operacion) {
            $inmueble = $operacion->get_inmueble();

            // true si no hay filtro, o si cumple el filtro
            // $cumple_operacion = ($tipo_operacion == null || $operacion instanceof $tipo_operacion);
            $cumple_operacion = (
                $tipo_operacion == null ||
                $tipo_operacion == "alquiler" && $operacion instanceof Alquiler ||
                $tipo_operacion == "alquiler_amoblado" && $operacion instanceof Alquiler && $operacion -> get_esta_amoblado() ||
                $tipo_operacion == "venta" && $operacion instanceof Venta
            );
            
            $cumple_zona = ($zona == null || $inmueble->get_ubicacion()->get_zona() == $zona);

            $cumple_propiedad = (empty($lista_tipo_propiedad) || 
                                in_array($inmueble->get_tipo_propiedad(), $lista_tipo_propiedad));

            // verifica que tenga TODAS las caracteristicas requeridas
            $cumple_caracteristicas = true;
            $caracteristicas_inmueble = $inmueble->get_otras_caracteristicas();
            foreach ($lista_otras_caracteristicas as $caracteristica => $requerida) {
                if ($requerida && !$caracteristicas_inmueble[$caracteristica]) {
                    $cumple_caracteristicas = false;
                    break;
                }
            }

            // solo agrega si cumple todos los filtros
            if ($cumple_operacion) {
                if ($cumple_zona) {
                    if ($cumple_propiedad) {
                        if ($cumple_caracteristicas) {
                            $resultados[] = $operacion;
                        }
                    }
                }
            }
        }
        return $resultados;
    }


    public function Catalogo_de($dni_usuario = null) {
        if ($dni_usuario === null) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $dni_usuario = $_SESSION['usuario']['dni'] ?? null;
        }

        if ($dni_usuario) {
            $this->cargar_datos_desde_bd($dni_usuario);
        }
    }

    private function cargar_datos_desde_bd($dni_especifico = null) {
        $bd = ConexionBDD::getInstancia();
        $this->lista_catalogo = []; 

        //ALQUILERES
        foreach ($bd->obtener_alquileres($dni_especifico) as $fila) {
            $inmueble = $this->crear_objeto_inmueble($fila, $bd);
            
            $this->lista_catalogo[] = new Alquiler(
                $fila['nro_operacion'],
                $fila['titulo_publicacion'],
                $fila['precio'],
                $fila['disponibilidad'],
                $inmueble,
                [], // Opciones financiación (vacío para alquiler)
                $fila['plazo'],
                $fila['esta_amoblado']
            );
        }

        // VENTAS
        foreach ($bd->obtener_ventas($dni_especifico) as $fila) {
            $inmueble = $this->crear_objeto_inmueble($fila, $bd);
            
            $opciones = [];
            foreach ($bd->obtener_opciones_financiacion($fila['nro_operacion']) as $f) {
                $opciones[] = new Opcion_financiacion($f['cod_financiacion'], $f['titulo_opcion_financiacion']);
            }

            $this->lista_catalogo[] = new Venta(
                $fila['nro_operacion'],
                $fila['titulo_publicacion'],
                $fila['precio'],
                $fila['disponibilidad'],
                $inmueble,
                $opciones,
                $fila['apto_credito_hipotecario']
            );
        }
    }

    private function crear_objeto_inmueble($fila, $bd) {
        $fotos = [];
        foreach ($bd->obtener_fotos($fila['nro_inmueble']) as $f) {
            $fotos[] = new Foto($f['nro_foto'], $f['nombre_foto'], $f['path']);
        }

        $ubicacion = new Ubicacion(
            $fila['nro_inmueble'],
            $fila['direccion'],
            $fila['zona'],
            $fila['cord_latitud'],
            $fila['cord_longitud']
        );

        return new Inmueble(
            $fila['nro_inmueble'],
            $fila['tipo_propiedad'],
            $fila['descripcion'],
            [
                "quincho"  => $fila['con_quincho'],
                "lavadero" => $fila['con_lavadero'],
                "patio"    => $fila['con_patio'],
                "garage"   => $fila['con_garage']
            ],
            $fotos,
            $ubicacion
        );
    }

}



?>
