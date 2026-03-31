<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
require_once BASE_PATH.'MODELO/Inmueble.class.php';
require_once BASE_PATH.'MODELO/Foto.class.php';
require_once BASE_PATH.'MODELO/Ubicacion.class.php';
require_once BASE_PATH.'MODELO/Operacion.class.php';
require_once BASE_PATH.'MODELO/Alquiler.class.php';
require_once BASE_PATH.'MODELO/Venta.class.php';
require_once BASE_PATH.'MODELO/libreria_conexionesBD/ConexionBDD.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION["usuario"])){

    $usuario_dni = $_SESSION["usuario"]["dni"];

    $lista_objetos_fotos = [];
    $directorio_destino = BASE_PATH . 'imagenes' . DIRECTORY_SEPARATOR;

    // Verificamos que se hayan enviado fotos
    if (isset($_FILES['fotos'])) {
        $cantidad = count($_FILES['fotos']['name']);

        for ($i = 0; $i < $cantidad; $i++) {
            // Datos temporales del sistema operativo
            $nombre_original = $_FILES['fotos']['name'][$i];
            $ruta_temporal = $_FILES['fotos']['tmp_name'][$i];
            $error = $_FILES['fotos']['error'][$i];

            if ($error === UPLOAD_ERR_OK) {
                // Generamos un nombre único para evitar sobrescribir archivos en Windows
                $nombre_final = time() . "_" . $nombre_original;
                $ruta_completa = $directorio_destino . $nombre_final;

                // Movemos el archivo de la carpeta temporal a /imagenes/
                if (move_uploaded_file($ruta_temporal, $ruta_completa)) {
                    
                    // Creamos el objeto Foto (usando tu constructor)
                    // Nota: El ID (numero_foto) podrías obtenerlo después de insertar en la BD
                    $nuevaFoto = new Foto(
                        $i + 1, // ID provisorio o autoincremental
                        "Descripción de " . $nombre_original, 
                        "imagenes/" . $nombre_final // Guardamos la ruta relativa para la web
                    );

                    $lista_objetos_fotos[] = $nuevaFoto;
                }
            }
        }
    }

    $ubicacion = new Ubicacion(
        0,
        $_POST['direccion_inmueble'],
        $_POST['zona'],
        $_POST['coordenadas_longitud_inmueble'],
        $_POST['coordenadas_latitud_inmueble'],
    );
    
    $inmueble = new Inmueble(
        0,
        $_POST['tipo_propiedad'],
        $_POST['descripcion_inmueble'],
        [
            'quincho' => isset($_POST['quincho']),
            'lavadero' => isset($_POST['lavadero']),
            'patio' => isset ($_POST['patio']),
            'garage' => isset ($_POST['garage']),
        ],
        $lista_objetos_fotos,
        $ubicacion

    );

    if ($_POST['operacion'] == "alquiler" || $_POST['operacion'] == "alquiler_amoblado"){
        $operacion = new Alquiler(
            0,//este no se tiene en cuenta
            $_POST['titulo_publicacion'],
            $_POST['precio'],
            true,
            $inmueble,
            [],
            $_POST['plazo'],
            false
        );
        if ($_POST['operacion'] == "alquiler_amoblado"){
            $operacion -> set_plazo(true);
        }
    }else{
        //venta
        $operacion = new Venta(
            0, //valor que no se tiene en cuenta a la hora de subir
            $_POST['titulo_publicacion'],
            $_POST['precio'],
            true,
            $inmueble,
            [], //opcion de financiacion
            $_POST['apto_credito_hipotecario']
        );

    }
}

$conexion = ConexionBDD::getInstancia();
$nro_inmueble = $conexion -> ingresar_inmueble($operacion -> get_inmueble(), $usuario_dni);
$conexion -> ingresar_fotos($operacion -> get_inmueble() -> get_fotos(), $nro_inmueble);
if ($operacion instanceof Alquiler){
    $id_operacion = $conexion -> ingresar_alquiler($operacion, $nro_inmueble);
}elseif ($operacion instanceof Venta){
    $id_operacion = $conexion -> ingresar_venta($operacion, $nro_inmueble);
    $conexion -> ingresar_opciones_financiacion($id_operacion, $operacion -> get_opcion_financiacion());
}
echo"<script>alert('La operacion se registro con exito')</script>";
echo "<script>window.location.href = '" . WEB_ROOT . "VISTA/gestion_administrador.php';</script>";

?>