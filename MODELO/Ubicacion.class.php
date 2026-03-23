<?php

class Ubicacion {
    // zonas
    const ZONA_NORTE = 1;
    const ZONA_SUR = 2;
    const ZONA_CENTRO = 3;
    const RADA_TILLY= 4;

    private int $nro_ubicacion;
    private string $direccion;
    private int $zona;
    private string $coordenadas;

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

    public function get_zona_texto() { 
        $nombre_zona;
        switch($this -> zona){
            case'1':
                $nombre_zona = "Zona Norte";
                break;
            case'2':
                $nombre_zona = "Zona Sur";
                break;
            case'3':
                $nombre_zona = "Zona Centro";
                break;
            case'4':
                $nombre_zona = "Rada Tylli";
                break;
        }
        return $nombre_zona;
    }
}
?>