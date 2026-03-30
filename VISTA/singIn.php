<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina ingreso">

<script type="text/javascript" src ="javascript/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="javascript/libreria_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="javascript/libreria_js/Validacion.js"></script>
<script type="text/javascript" src ="javascript/Validador_ingreso.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function (){
        const formulario_registro = document.getElementById("id_fomr_ingreso");
        
        formulario_registro.addEventListener('submit', async function(evento) {
			evento.preventDefault(); 

			const datos = new FormData(formulario_registro);
			console.log (datos);

			try {
				// El "await" espera la respuesta del servidor (es lo que permie el asincronico)
				const respuesta = await fetch('../CONTROLADOR/ProcesaingresoUsuario.php', {
					method: 'POST',
					body: datos
				});

				const resultado = await respuesta.json();

				if (resultado.exito) {
					console.log(resultado);
					ir_gestionAdministrador();
				} else {
					alert("Error: " + resultado.mensaje);
				}
			} catch (error) {
				console.error("Error en la conexión:", error);
			}
		});
    })
</script>

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/formulario_estilos.css">

<title>Sing In</title>
</head>

<body>
	<header>
	<h1>Ingreso Usuario Administrador</h1>
	</header>
	<section>
		<article class= "contenedor_formulario">
			<form id="id_fomr_ingreso" class "formulario" method="POST">
				<fieldset class = "fieldset" name="Singin">
					
					<span class="form_grupo">
						<label class ="label" for ="id_dni">DNI: </label>						
						<input id ="id_dni" type="text" name="dni" placeholder="ingrese su dni" value="12345678">
						<span id="error_dni" class="error"></span>
					</span>
				
					<span class="form_grupo">
						<label class ="label" for ="id_contraseña">Contraseña: </label>
						<input onblur ="" id ="id_contraseña"type="text" name="contrasena" maxlength="20" placeholder="ingrese su contraseña" value="12345678">
						<input name="contraseña_encriptada" type="hidden" value="">
						<span id="error_contraseña" class="error"></span>
					</span>
				</fieldset>
				
				
				<fieldset class = "fieldset field_acciones" name="acciones_botones">
					<button id="id_envio" class="boton" type ="submit">ingresar</button>
					<button id="id_borrar" class="boton" type ="reset">borrar</button>
					<button id="id_registrarse" class="boton" type ="button" onclick = "ir_singUp();">registrarse</button>
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