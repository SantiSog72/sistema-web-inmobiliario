<?php

class Ubicacion {
    // zonas
    const ZONA_NORTE = 1;
    const ZONA_SUR = 2;
    const ZONA_CENTRO = 3;
    const RADA_TILLY= 4;

    private int $nro_ubicacion;
    private string $direccion;
    private string $zona;
    private string $coordenadas_latitud;
    private string $coordenadas_longitud;
        
    

    public function __construct ($nro_ubicacion, $direccion, $zona, $coordenadas_latitud, $coordenadas_longitud){
        $this -> nro_ubicacion = $nro_ubicacion;
        $this -> direccion = $direccion;
        $this -> zona = $zona;
        $this -> coordenadas_latitud = $coordenadas_latitud;
        $this -> coordenadas_longitud = $coordenadas_longitud;
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
    public function get_coordenadas_latitud() { 
        return $this->coordenadas_latitud;
    }
    public function get_coordenadas_longitud() { 
        return $this->coordenadas_longitud;
    }

    public function get_zona_texto() {
    switch($this->zona) {
        // números — cuando se crea desde el controlador hardcodeado
        case 1: return "Zona Norte";
        case 2: return "Zona Sur";
        case 3: return "Zona Centro";
        case 4: return "Rada Tilly";
        // strings — cuando viene de la BD
        case 'zona_norte':  return "Zona Norte";
        case 'zona_sur':    return "Zona Sur";
        case 'zona_centro': return "Zona Centro";
        case 'rada_tilly':  return "Rada Tilly";
        default: return $this->zona;
    }
}
}
?>