<?php
include_once 'Operacion.class.php'

class Venta extends Operacion{
    
    private bool $apto_credito_hipotecario;

    public function __construct ($nro_operacion, $precio, $disponibilidad, $opcion_financiacion, $apto_credito_hipotecario){
        parent::__construct($nro_operacion, $precio, $disponibilidad);
        $this -> apto_credito_hipotecario = $apto_credito_hipotecario;
    }

    public function get_apto_credito_hipotecario() { return $this->apto_credito_hipotecario; }
}
?>