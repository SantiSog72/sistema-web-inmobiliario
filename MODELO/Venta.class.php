<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/Operacion.class.php';
require_once BASE_PATH.'MODELO/Opcion_financiacion.class.php';

class Venta extends Operacion{
    
    private bool $apto_credito_hipotecario;
    private array $opcion_financiacion;

    public function __construct ($nro_operacion, $titulo_publicacion, $precio, $disponibilidad, $inmueble, $opcion_financiacion, $apto_credito_hipotecario){
        parent::__construct($nro_operacion,$titulo_publicacion, $precio, $disponibilidad, $inmueble);
        $this -> apto_credito_hipotecario = $apto_credito_hipotecario;
        $this -> opcion_financiacion = $opcion_financiacion;
    }

    public function get_apto_credito_hipotecario() { return $this->apto_credito_hipotecario; }
    public function get_opcion_financiacion() { return $this->opcion_financiacion; }
}
?>