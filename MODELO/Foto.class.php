<?php
class Foto{
    private int $numero_foto;
    private string $descripcion_foto;
    private string $path;

    public function __construct ($numero_foto, $descripcion_foto, $path){
        $this -> numero_foto = $numero_foto;
        $this -> descripcion_foto = $descripcion_foto;
        $this -> path = $path;
    }

    public function get_numero_foto (){
        return $this -> numero_foto;
    }

    public function get_path_foto (){
        return $this -> path;
    }

    public function get_descripcion_foto (){
        return $this -> descripcion_foto;
    }
}
?>