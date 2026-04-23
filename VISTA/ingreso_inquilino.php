<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina Ingresar inquilino">
<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/botones_hipervinculo.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/renderizadores.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/libreria_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/libreria_js/Validacion.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/ValidadorAltaOperacion.js"></script> 
<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const formulario = document.getElementById('id_formulario_registro_inquilino');
		const nro_operacion = localStorage.getItem("nro_operacion");
		console.log (nro_operacion);

        //guarda el nro_operacion en campo oculto
        if (nro_operacion){
            document.getElementById("id_nro_operacion").value = nro_operacion;
        }

        formulario.addEventListener('submit', async function(evento) {
			evento.preventDefault(); 

			const datos = new FormData(formulario);
			console.log (datos);

			try {
				// El "await" espera la respuesta del servidor (es lo que permie el asincronico)
				const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/ProcesaIngresoInquilino.php', {
					method: 'POST',
					body: datos
				});

				const resultado = await respuesta.json();

				if (resultado.exito) {
					alert(resultado.mensaje);
					ir_gestionAdministrador();
				} else {
					alert("Error: " + resultado.mensaje);
				}
			} catch (error) {
				console.error("Error en la conexión:", error);
			}
		});

		formulario.addEventListener('reset', async function(){
			ir_gestionAdministrador();
		})

	});

</script>

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css//index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css//index.css">

<title>Registrar de inquilino</title>
</head>

<body>
	<header>
	<h1>Ingreso de Inquilino al Alquiler</h1>
	</header>
	<section>
		<article class= "contenedor_formulario">
			<form id="id_formulario_registro_inquilino" class "formulario" name="formulario_registro_inquilino" method="POST">
				<input id="id_nro_operacion" type="hidden" name="nro_operacion" value="">
                <fieldset class = "fieldset" name="datos personales">
					<legend class = "legend" >Ingreso Datos Personales</legend>
                    <span class="form_grupo">
						<label class ="label" for ="id_dni">DNI: </label>						
						<input id ="id_dni" type="text" name="dni" placeholder="ingrese su dni" value="">
						<span id="error_dni" class="error"></span>
					</span>
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
			
				
				<fieldset class = "fieldset" name="acciones_botones">
					<legend class = "legend" >acciones</legend>		
					<button id="id_envio" class="boton" type ="submit" >Registrar inquilino</button>
					<button id="id_cancelar" class="boton" type ="reset" >cancelar</button>
				</fieldset>
				
			</form>
		
		</article>
	</section>
	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer
	
</body>

</html>