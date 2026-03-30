<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}
_PATH.'MODELO/Mensaje.class.php';
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
        const fomrulario = document.getElementById("id_fomrulario_mensaje");
        
        fomrulario.addEventListener('submit', async function(evento) {
			evento.preventDefault(); 

			const datos = new FormData(fomrulario);
			console.log (datos);

			try {
				// El "await" espera la respuesta del servidor (es lo que permie el asincronico)
				const respuesta = await fetch('../CONTROLADOR/ProcesaEnvioMensaje.php', {
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
			<form id="id_fomrulario_mensaje" class "formulario" method="POST">

				<fieldset class = "fieldset" name="datos personales">
					<legend class = "legend" >Ingreso Datos Personales</legend>
					<span class="form_grupo">
						<label class ="label" for ="id_nombre">nombre:</label>						
						<input  onblur="" id ="id_nombre" type="text" name="nombre" maxlength="20" placeholder="ingrese su nombre" value ="santiago">
						<span id="error_nombre" class="error"></span>
					</span>
					<span class="form_grupo">
						<label class ="label" for ="id_apellido">apellido:</label>						
						<input onblur="" id ="id_apellido" type="text" name="apellido" maxlength="20" placeholder="ingrese su apellido" value="servin">
						<span id="error_apellido" class="error"></span>
					</span>
				</fieldset>

                <fieldset class = "fieldset" name="datos contacto">
                    <legend class = "legend" >Ingreso Datos de Contacto</legend>
					
					<span class="form_grupo">
                        <label class ="label" for ="id_email">email: </label>						
						<input id ="id_email"type="text" name="email" placeholder="ingrese su email" value="santiago@servin.com">
						<span id="error_email" class="error"></span>
					</span>
                    
                    <span class="form_grupo">
                        <label class ="label" for ="id_numero_cel">numero celular</label>						
                        <input id ="id_numero_cel" type="text" name="nro_celular" placeholder= "ingrese numero celular" value="12345678">
                        <span id="error_numero_cel" class="error"></span>
                    </span>
                </fieldset>

                <fieldset class = "fieldset" name="datos mensaje">
                    <legend class = "legend" >Ingrese mensaje</legend>
                    <span class="form_grupo">
                        <textarea id="id_mensaje" type="textarea" name="mensaje" maxlength="5000" cols="100" rows="4">mensaje ejemplo</textarea>                  
                        <span id="error_descripcion_inmueble" class="error"></span>
                    </span>
                </fieldset>
				
				
				<fieldset class = "fieldset field_acciones" name="acciones_botones">
					<button id="id_envio" class="boton" type ="submit">enviar</button>
					<button id="id_borrar" class="boton" type ="reset">borrar</button>
					<button id="id_registrarse" class="boton" type ="button" onclick = "">cerrar</button>
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