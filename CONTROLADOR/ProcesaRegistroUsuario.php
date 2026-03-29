<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
require_once BASE_PATH.'MODELO/UsuarioAdministrador.class.php';
require_once BASE_PATH.'MODELO/Contacto.class.php';

//se puede mejorar mucho con ajax
//verificar que dni no este repetido
$conexion = ConexionBDD::getInstancia();
$lista_usuarios= $conexion -> obtener_usuarios();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $repetido = false;
    foreach($lista_usuarios as $usuario_bdd){
        if ($_POST['dni'] === $usuario_bdd['dni']){
            $repetido = true;
            break;
        }
    }

    if (!$repetido){
        $contacto = new Contacto(
            $_POST['nombre'],//no relevante
            $_POST['nro_celular'],
            $_POST['email'],
        );
        $usuario = new UsuarioAdministrador(
            $_POST['dni'],
            $_POST['contrasena'],
            $_POST['nombre'],
            $_POST['apellido'],
            $contacto
        );


      
        if ($conexion -> ingresar_usuario($usuario)){
            echo"<script>alert('el usuario se registro con exito')</script>";
            echo"<script>window.location.href =`/sistema%20web%20inmobiliario/index.php`;</script>";
        }else{
            echo"<script>alert('el usuario no se pudo registrar')</script>";
            echo"<script>window.location.href =`../VISTA/singUp.php`;</script>";

        }
        

    }else{
        echo"<script>alert('el usuario ya estaba registrado en bdd')</script>";
        echo"<script>window.location.href =`../VISTA/singUp.php`;</script>";
    }


}



?>