<?php
require_once 'Contacto.class.php';

class UsuarioAdministrador {

    private string $dni;
    private string $contrasena;
    private Contacto $contacto;

    public function __construct($dni, $contrasena, $contacto) {
        $this->dni           = $dni;
        $this->contrasena    = $contrasena;
        $this->contacto      = $contacto;
        // $this->ultimo_acceso = $ultimo_acceso;
    }

    public function get_dni()            { return $this->dni; }
    public function get_contrasena()     { return $this->contrasena; }
    public function get_contacto()       { return $this->contacto; }
    // public function get_ultimo_acceso()  { return $this->ultimo_acceso; }
}
?>