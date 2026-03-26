<?php

class Opcion_financiacion {
    
    private string $cod_financiacion; //meses
    private string $titulo_opcion_financiacion;

    public function __construct ($cod_financiacion, $titulo_opcion_financiacion){
        $this -> cod_financiacion = $cod_financiacion;
        $this -> titulo_opcion_financiacion = $titulo_opcion_financiacion;
    }

    public function get_cod_financiacion() { return $this->cod_financiacion; }
    public function get_titulo_opcion_financiacion() { return $this->titulo_opcion_financiacion; }
}
?>