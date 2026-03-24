<?php
require_once 'Inmueble.class.php';
abstract class Operacion {

    private int $nro_operacion;
    private string $titulo_publicacion;
    private int $precio;
    private bool $disponibilidad;
    private Inmueble $inmueble;


    public function __construct ($nro_operacion, $titulo_publicacion, $precio, $disponibilidad, $inmueble){
        $this -> nro_operacion = $nro_operacion;
        $this -> titulo_publicacion = $titulo_publicacion;
        $this -> precio = $precio;
        $this -> disponibilidad = $disponibilidad;
        $this -> inmueble = $inmueble;
    }

    public function get_nro_operacion() { return $this->nro_operacion; }
    public function get_titulo_publicacion() { return $this->titulo_publicacion; }
    public function get_precio() { return $this->precio; }
    public function get_disponibilidad() { return $this->disponibilidad; }
    public function get_inmueble() { return $this->inmueble; }
    }
?>