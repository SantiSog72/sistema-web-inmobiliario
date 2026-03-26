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
    public function __construct() {
        $bd = ConexionBDD::getInstancia();

        // cargar alquileres
        foreach ($bd->obtener_alquileres() as $fila) {
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
            $inmueble = new Inmueble(
                $fila['nro_inmueble'],
                $fila['tipo_propiedad'],
                $fila['descripcion'],
                ["quincho"  => $fila['con_quincho'],
                "lavadero" => $fila['con_lavadero'],
                "patio"    => $fila['con_patio'],
                "garage"   => $fila['con_garage']],
                $fotos,
                $ubicacion
            );
            $this->lista_catalogo[] = new Alquiler(
                $fila['nro_operacion'],
                $fila['titulo_publicacion'],
                $fila['precio'],
                $fila['disponibilidad'],
                $inmueble,
                [],
                $fila['plazo'],
                $fila['esta_amoblado']
            );
        }

        // cargar ventas
        foreach ($bd->obtener_ventas() as $fila) {
            $fotos = [];
            foreach ($bd->obtener_fotos($fila['nro_inmueble']) as $f) {
                $fotos[] = new Foto($f['nro_foto'], $f['nombre_foto'], $f['path']);
            }

            $opciones_financiacion = [];
            foreach ($bd -> obtener_opciones_financiacion($fila['nro_operacion']) as $f){
                $opciones_financiacion [] = new Opcion_financiacion(
                    $f['cod_financiacion'], 
                    $f['titulo_opcion_financiacion']);
            }
            $ubicacion = new Ubicacion(
                $fila['nro_inmueble'],
                $fila['direccion'],
                $fila['zona'],
                $fila['cord_latitud'],
                $fila['cord_longitud']
            );
            $inmueble = new Inmueble(
                $fila['nro_inmueble'],
                $fila['tipo_propiedad'],
                $fila['descripcion'],
                ["quincho"  => $fila['con_quincho'],
                "lavadero" => $fila['con_lavadero'],
                "patio"    => $fila['con_patio'],
                "garage"   => $fila['con_garage']],
                $fotos,
                $ubicacion
            );
            $this->lista_catalogo[] = new Venta(
                $fila['nro_operacion'],
                $fila['titulo_publicacion'],
                $fila['precio'],
                $fila['disponibilidad'],
                $inmueble,
                $opciones_financiacion,
                $fila['apto_credito_hipotecario']
            );
        }
    }

    public function get_lista_catalogo() {
        return $this->lista_catalogo;
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

    


}



?>
