<?php

require_once 'Foto.class.php';
require_once 'Ubicacion.class.php';

class Inmueble {
	
    // // tipo propiedad
    const DEPARTAMENTO = "departamento";
    const CASA = "casa";
    const OFICINA = "oficina";
    const COCHERA= "cochera";
    const TERRENO= "terreno";

    private int $nro_inmueble;
    private string $tipo_propiedad;
    private string $descripcion;
    private array $otras_caracteristicas;
	private array $fotos;
	private Ubicacion $ubicacion;

	public function __construct ($nro_inmueble, $tipo_propiedad, $descripcion, $otras_caracteristicas, $fotos, $ubicacion){
        $this -> nro_inmueble = $nro_inmueble;
        $this -> tipo_propiedad= $tipo_propiedad;
        $this -> descripcion= $descripcion;
        $this -> otras_caracteristicas= $otras_caracteristicas;
		$this -> fotos = $fotos;
		$this -> ubicacion = $ubicacion;
	}

    public function get_nro_inmueble() {
        return $this->nro_inmueble;
    }

    public function get_tipo_propiedad() {
        return $this->tipo_propiedad;
    }

    public function get_descripcion() {
        return $this->descripcion;
    }

    public function get_otras_caracteristicas() {
        return $this->otras_caracteristicas;
    }

    public function get_fotos() {
        return $this->fotos;
    }

    public function get_ubicacion() {
        return $this->ubicacion;
    }

}
?>