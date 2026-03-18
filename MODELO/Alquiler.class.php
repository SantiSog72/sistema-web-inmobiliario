<?php
include_once 'Operacion.class.php'

class Alquiler extends Operacion {
    
    private int $plazo; //meses
    private array $lista_registros_pago;

    public function __construct ($nro_operacion, $precio, $disponibilidad){
        parent::_construct ($nro_operacion, $precio, $disponibilidad)
        $this -> plazo = $plazo;
        $this -> lista_registros_pago = $lista_registros_pago;
    }

    public function get_plazo() { return $this->plazo; }
    public function get_lista_registros_pago() { return $this->lista_registros_pago; }
}
?>