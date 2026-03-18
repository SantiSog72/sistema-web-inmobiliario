<?php
require_once 'Inmueble.class.php';
abstract class Operacion {
    
    // opciones de financiacion
    const FINANCIACION_BANCO_NACION = 1;
    const FINANCIACION_BANCO_GALICIA= 2;
    const FINANCIACION_BANCO_CHUBUT= 3;
    const SIN_FINANCIACION= 4;

    private int $nro_operacion;
    private int $precio;
    private bool $disponibilidad;
    private int $opcion_financiacion;
    private Inmueble $inmueble;

    public function __construct ($nro_operacion, $precio, $disponibilidad, $opcion_financiacion, $inmueble){
        $this -> nro_operacion = $nro_operacion;
        $this -> precio = $precio;
        $this -> disponibilidad = $disponibilidad;
        $this -> opcion_financiacion = $opcion_financiacion;
        $this -> inmueble = $inmueble;
    }

    public function get_nro_operacion() { return $this->nro_operacion; }
    public function get_precio() { return $this->precio; }
    public function get_disponibilidad() { return $this->disponibilidad; }
    public function get_opcion_financiacion() { return $this->opcion_financiacion; }
    public function get_inmueble() { return $this->inmueble; }
    }
?>