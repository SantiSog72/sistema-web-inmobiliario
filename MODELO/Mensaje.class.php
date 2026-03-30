<?php
class Mensaje {
    private $nro_mensaje;
    private $nro_inmueble;
    private $fecha_hora;
    private $contacto; // Objeto de tipo Contacto (nombre, apellido, email, cel)
    private $cuerpo_mensaje;
    private $visto;

    public function __construct($nro_inmueble, Contacto $contacto, $cuerpo_mensaje, $nro_mensaje = null, $fecha_hora = null, $visto = 0) {
        $this->nro_inmueble = $nro_inmueble;
        $this->contacto = $contacto;
        $this->cuerpo_mensaje = $cuerpo_mensaje;
        $this->nro_mensaje = $nro_mensaje;
        $this->fecha_hora = $fecha_hora ?? date('Y-m-d H:i:s');
        $this->visto = $visto;
    }

    public function getNroInmueble() { return $this->nro_inmueble; }
    public function getContacto() { return $this->contacto; }
    public function getCuerpoMensaje() { return $this->cuerpo_mensaje; }
    public function getFechaHora() { return $this->fecha_hora; }
    public function getVisto() { return $this->visto; }
    public function getNroMensaje() { return $this->nro_mensaje; }

}
?>