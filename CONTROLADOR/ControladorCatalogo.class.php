<?php
// rel: (se toma desde donde se llama) a pesar de estar ubicado en controlador, toma desde donde esta el archivo index
// abs: se toma desde el inicio del direcotrio xamp
require_once __DIR__ .'/../MODELO/Inmueble.class.php';
require_once __DIR__ .'/../MODELO/Foto.class.php';
require_once __DIR__ .'/../MODELO/Ubicacion.class.php';
require_once __DIR__ .'/../MODELO/Operacion.class.php';
require_once __DIR__ .'/../MODELO/Alquiler.class.php';
require_once __DIR__ .'/../MODELO/Venta.class.php';

class ControladorCatalogo {

    private array $lista_catalogo = [];
    // el catalogo al crearse trae de la bdd la lista y se la autoasigna
    public function __construct() {
        // ── DEPARTAMENTO 1 ──────────────────────────
        $fotos_dpto1 = [
            new Foto(1, "baño",       "../imagenes/departamento1_baño.jpg"),
            new Foto(2, "cocina",     "../imagenes/departamento1_cocina.jpg"),
            new Foto(3, "comedor",    "../imagenes/departamento1_comedor.jpg"),
            new Foto(4, "dormitorio", "../imagenes/departamento1_dormitorio.jpg")
        ];
        $ubicacion_dpto1 = new Ubicacion(1, "Calle Juan 123", Ubicacion::ZONA_CENTRO, "-45.8667,-67.4833");
        $inmueble_dpto1  = new Inmueble(
            1,
            Inmueble::DEPARTAMENTO,
            "Departamento luminoso en el centro",
            ["quincho"=>false, "lavadero"=>true, "patio"=>false, "garage"=>true],
            $fotos_dpto1,
            $ubicacion_dpto1
        );

        // ── CASA 1 ───────────────────────────────────
        $fotos_casa1 = [
            new Foto(1, "frente", "../imagenes/casa1_frente.jpg"),
            new Foto(2, "patio",  "../imagenes/casa1_patio.jpg"),
            new Foto(3, "cocina", "../imagenes/casa1_cocina.jpg")
        ];
        $ubicacion_casa1 = new Ubicacion(2, "Av. Rivadavia 456", Ubicacion::ZONA_NORTE, "-45.8512,-67.4901");
        $inmueble_casa1  = new Inmueble(
            2,
            Inmueble::CASA,
            "Casa amplia con patio y quincho, ideal para familia",
            ["quincho"=>true, "lavadero"=>true, "patio"=>true, "garage"=>false],
            $fotos_casa1,
            $ubicacion_casa1
        );

        // ── OFICINA 1 ────────────────────────────────
        $fotos_oficina1 = [
            new Foto(1, "recepcion", "../imagenes/oficina1_recepcion.jpg"),
            new Foto(2, "sala",      "../imagenes/oficina1_sala.jpg")
        ];
        $ubicacion_oficina1 = new Ubicacion(3, "San Martin 789", Ubicacion::ZONA_CENTRO, "-45.8640,-67.4750");
        $inmueble_oficina1  = new Inmueble(
            3,
            Inmueble::OFICINA,
            "Oficina en pleno centro, piso 3, luminosa",
            ["quincho"=>false, "lavadero"=>false, "patio"=>false, "garage"=>true],
            $fotos_oficina1,
            $ubicacion_oficina1
        );

        // ── TERRENO 1 ────────────────────────────────
        $fotos_terreno1 = [
            new Foto(1, "frente",  "../imagenes/terreno1_frente.jpg"),
            new Foto(2, "lateral", "../imagenes/terreno1_lateral.jpg")
        ];
        $ubicacion_terreno1 = new Ubicacion(4, "Los Pinos 321", Ubicacion::RADA_TILLY, "-45.9200,-67.5100");
        $inmueble_terreno1  = new Inmueble(
            4,
            Inmueble::TERRENO,
            "Terreno en Rada Tilly con vista al mar, 500m2",
            ["quincho"=>false, "lavadero"=>false, "patio"=>false, "garage"=>false],
            $fotos_terreno1,
            $ubicacion_terreno1
        );

        // ── DEPARTAMENTO 2 AMOBLADO ──────────────────
        $fotos_dpto2 = [
            new Foto(1, "living",     "../imagenes/dpto2_living.jpg"),
            new Foto(2, "dormitorio", "../imagenes/dpto2_dormitorio.jpg"),
            new Foto(3, "baño",       "../imagenes/dpto2_baño.jpg")
        ];
        $ubicacion_dpto2 = new Ubicacion(5, "Pellegrini 654", Ubicacion::ZONA_SUR, "-45.8890,-67.4820");
        $inmueble_dpto2  = new Inmueble(
            5,
            Inmueble::DEPARTAMENTO,
            "Departamento amoblado, 2 ambientes, cerca del centro",
            ["quincho"=>false, "lavadero"=>false, "patio"=>false, "garage"=>false],
            $fotos_dpto2,
            $ubicacion_dpto2
        );
        // DEPARTAMENTO 1 — Alquiler
        $this->lista_catalogo[] = new Alquiler(
            1,              // nro_operacion
            "departamento 1",//titulo
            150000,         // precio
            true,           // disponibilidad
            $inmueble_dpto1,// inmueble
            [],             // lista_registros_pago vacía
            12              // plazo en meses
        );

        // CASA 1 — Venta
        $this->lista_catalogo[] = new Venta(
            2,
            "casa 1",//titulo
            25000000,
            true,
            $inmueble_casa1,
            Venta::FINANCIACION_BANCO_NACION,
            true            // apto credito hipotecario
        );

        // OFICINA 1 — Alquiler
        $this->lista_catalogo[] = new Alquiler(
            3,
            "oficina 1",//titulo
            200000,
            true,
            $inmueble_oficina1,
            [],
            24
        );

        // TERRENO 1 — Venta
        $this->lista_catalogo[] = new Venta(
            4,
            "terreno 1",//titulo
            15000000,
            true,
            $inmueble_terreno1,
            Venta::FINANCIACION_BANCO_CHUBUT,
            false
        );

        // DEPARTAMENTO 2 — Alquiler
        $this->lista_catalogo[] = new Alquiler(
            5,
            "departamento 2",//titulo
            180000,
            true,
            $inmueble_dpto2,
            [],
            6
        );
    }



    public function get_lista_catalogo() {
        return $this->lista_catalogo;
    }


    // public function filtra_operaciones ($tipo_operacion, $zona, $lista_tipo_propiedad, $lista_otras_caracteristicas) {
    //     $resultados = [];

    //     foreach ($this->lista_catalogo as $operacion) {
    //         $inmueble = $operacion->get_inmueble();
    //         $cumple_operacion = ($tipo_operacion instanceof $operacion);
    //         if ($cumple_operacion){
    //             $resultados[] = $operacion;
    //         }
    //     }

    //     return $resultados;
    // }

    public function filtra_operaciones($tipo_operacion, $zona, $lista_tipo_propiedad, $lista_otras_caracteristicas) {
    $resultados = [];

    foreach ($this->lista_catalogo as $operacion) {
        $inmueble = $operacion->get_inmueble();

        // true si no hay filtro, o si cumple el filtro
        $cumple_operacion = ($tipo_operacion == null || $operacion instanceof $tipo_operacion);

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
