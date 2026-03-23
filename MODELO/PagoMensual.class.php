<?php

class PagoMensual {
    
    private int $nro_pago;
    private int $monto_pago; // en meses
    private string $fecha_pago;
    private string $mes_abonado;


    public function __construct ($nro_pago, $monto_pago, $fecha_pago, $mes_abonado){
        $this -> nro_pago = $nro_pago;
        $this -> monto_pago = $monto_pago;
        $this -> fecha_pago = $fecha_pago;
        $this -> mes_abonado = $mes_abonado;
    }

    public function get_nro_pago() { return $this->nro_pago; }
    public function get_monto_pago() { return $this->monto_pago; }
    public function get_fecha_pago() { return $this->fecha_pago; }
    public function get_mes_abonado() { return $this->mes_abonado; }
}
?>