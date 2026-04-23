<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';
require_once BASE_PATH.'MODELO/UsuarioAdministrador.class.php';
require_once BASE_PATH.'MODELO/Contacto.class.php';

$conexion = ConexionBDD::getInstancia();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $contacto = new Contacto(
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['nro_celular'],
        $_POST['email'],
    );
    $usuario = new UsuarioAdministrador(
        $_POST['dni'],
        $_POST['contrasena'],
        $contacto
    );

    try{
        if ($conexion->ingresar_usuario($usuario)){
        echo "<script>
            alert('El usuario se registró con éxito');
            window.location.href = '" . WEB_ROOT . "index.php';
        </script>";
        }else{
            echo "<script>alert('paso otra cosa');<script>";
        }

    }catch(mysqli_sql_exception $e){
        if (str_contains($e -> getMessage(), "Duplicate entry")){
            echo "<script>
            alert('El usuario ya se encuentra registrado en la base de datos');
            window.location.href = '" . WEB_ROOT . "VISTA/singUp.php';
            </script>";
        }else{
            echo "<script>
            alert('El usuario no se pudo registrar');
            window.location.href = '" . WEB_ROOT . "VISTA/singUp.php';
            </script>";
        }
    }
        

}
?>