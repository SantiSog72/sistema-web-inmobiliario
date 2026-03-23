<?php
require_once 'Operacion.class.php';

class Venta extends Operacion{
    
    // opciones de financiacion
    const FINANCIACION_BANCO_NACION = 1;
    const FINANCIACION_BANCO_GALICIA= 2;
    const FINANCIACION_BANCO_CHUBUT= 3;
    const SIN_FINANCIACION= 4;

    
    private bool $apto_credito_hipotecario;
    private int $opcion_financiacion;

    public function __construct ($nro_operacion, $titulo_publicacion, $precio, $disponibilidad, $inmueble, $opcion_financiacion, $apto_credito_hipotecario){
        parent::__construct($nro_operacion,$titulo_publicacion, $precio, $disponibilidad, $inmueble);
        $this -> apto_credito_hipotecario = $apto_credito_hipotecario;
        $this -> opcion_financiacion = $opcion_financiacion;
    }

    public function get_apto_credito_hipotecario() { return $this->apto_credito_hipotecario; }
    public function get_opcion_financiacion() { return $this->opcion_financiacion; }
}
?>