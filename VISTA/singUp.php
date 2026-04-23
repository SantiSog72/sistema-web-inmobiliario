<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina registro">
<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/libreria_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/libreria_js/Validacion.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/Validador_registro.js"></script> 

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">

<!-- <script>
    document.addEventListener('DOMContentLoaded', function (){
        const fomrulario_registro = document.getElementById("id_fomr_registro");
        
        fomrulario_registro.addEventListener('submit', async function(evento){
            evento.preventDefault();
            
            const datos = new FormData(fomrulario_registro);
            const url = 'CONTROLADOR/ProcesaRegistroUsuario.php';
            


            //realizar validacion
        })
    })
</script> -->

<title>Sing Up</title>
</head>

<body>
	<header>
	<h1>Registro</h1>
	</header>
	<section>
		<article class= "contenedor_formulario">
			<form id="id_fomr_registro" class "formulario" method="post" action="<?= WEB_ROOT ?>CONTROLADOR/ProcesaRegistroUsuario.php">
				<fieldset class = "fieldset" name="datos sesion">
					<legend class = "legend" >Ingreso Datos de Sesion</legend>
					
					<span class="form_grupo">
						<label class ="label" for ="id_dni">DNI: </label>						
						<input id ="id_dni" type="text" name="dni" placeholder="ingrese su dni" value="">
						<span id="error_dni" class="error"></span>
					</span>

					<span class="form_grupo">
						<label class ="label" for ="id_contraseña">Nueva Contraseña: </label>
						<input onblur ="" id ="id_contraseña" type="password" name="contrasena" maxlength="20" placeholder="ingrese su contraseña" value="">
						<span id="error_contraseña" class="error"></span>
					</span>
				</fieldset>

				<fieldset class = "fieldset" name="datos personales">
					<legend class = "legend" >Ingreso Datos Personales</legend>
					<span class="form_grupo">
						<label class ="label" for ="id_nombre">nombre:</label>						
						<input  onblur="" id ="id_nombre" type="text" name="nombre" maxlength="20" placeholder="ingrese su nombre" value ="">
						<span id="error_nombre" class="error"></span>
					</span>
					<span class="form_grupo">
						<label class ="label" for ="id_apellido">apellido:</label>						
						<input onblur="" id ="id_apellido" type="text" name="apellido" maxlength="20" placeholder="ingrese su apellido" value="">
						<span id="error_apellido" class="error"></span>
					</span>
				</fieldset>


				<fieldset class = "fieldset" name="datos contacto">
                    <legend class = "legend" >Ingreso Datos de Contacto</legend>
					
					<span class="form_grupo">
                        <label class ="label" for ="id_email">email: </label>						
						<input id ="id_email"type="text" name="email" placeholder="ingrese su email" value="">
						<span id="error_email" class="error"></span>
					</span>
                    
                    <span class="form_grupo">
                        <label class ="label" for ="id_numero_cel">numero celular</label>						
                        <input id ="id_numero_cel" type="text" name="nro_celular" placeholder= "ingrese numero celular" value="">
                        <span id="error_numero_cel" class="error"></span>
                    </span>
                </fieldset>
				
				<fieldset class = "fieldset field_acciones" name="acciones_botones">
					<legend class = "legend" >acciones</legend>
					<button id="id_envio" class="boton" type ="button" onclick = "enviar_formulario();">Registrase</button>
					<button id="id_borrar" class="boton" type ="button" onclick = "borrar();">borrar</button>
					<button id="id_cancelar" class="boton" type ="button" onclick = "cancelar();">cancelar</button>
				</fieldset>
				
			</form>
		
		</article>
	</section>
	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>