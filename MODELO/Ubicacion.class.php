<?php

class Ubicacion {
    // zonas
    const ZONA_NORTE = 1;
    const ZONA_SUR = 2;
    const ZONA_CENTRO = 3;
    const RADA_TILLY= 4;

    public function __construct ($nro_ubicacion, $direccion, $zona, $coordenadas){
        $this -> nro_ubicacion = $nro_ubicacion;
        $this -> direccion = $direccion;
        $this -> zona = $zona;
        $this -> coordenadas = $coordenadas;
    }

    public function get_nro_ubicacion() { 
        return $this->nro_ubicacion;
    }
    public function get_direccion() { 
        return $this->direccion;
    }
    public function get_zona() { 
        return $this->zona;
    }
    public function get_coordenadas() { 
        return $this->coordenadas;
    }
}
?>