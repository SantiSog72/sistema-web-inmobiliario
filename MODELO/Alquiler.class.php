<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once 'MODELO/Operacion.class.php';

class Alquiler extends Operacion {
    
    private int $plazo; //meses
    private array $lista_registros_pago;
    private bool $esta_amoblado;

    public function __construct ($nro_operacion, $titulo_publicacion, $precio, $disponibilidad, $inmueble, $lista_registros_pago, $plazo, $esta_amoblado){
        parent::__construct ($nro_operacion, $titulo_publicacion, $precio, $disponibilidad, $inmueble);
        $this -> plazo = $plazo;
        $this -> lista_registros_pago = $lista_registros_pago;
        $this -> esta_amoblado = $esta_amoblado;
    }

    public function get_plazo() { return $this->plazo; }
    public function set_plazo($plazo) { $this->plazo = $plazo; }
    public function get_esta_amoblado() { return $this->esta_amoblado; }
    public function get_lista_registros_pago() { return $this->lista_registros_pago; }
}
?>