
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina ingreso">

<script type="text/javascript" src ="VISTA/javascript/libreria_js/ubicador_elementos.js"></script>


<link rel="stylesheet" href="VISTA/css//index.css">
<link rel="stylesheet" href="VISTA/css/formulario_estilos.css">

<title>Sing In</title>
</head>

<body>
	<header>
	<h1>Ingreso</h1>
	</header>
	<section>
		<article class= "contenedor_formulario">
			<form id="id_fomr_ingreso" class "formulario" method="POST" action ="">
				<fieldset class = "fieldset" name="Singin">
					
					<span class="form_grupo">
						<label class ="label" for ="id_dni">DNI: </label>						
						<input id ="id_dni" type="text" name="dni" placeholder="ingrese su dni" value="12345678">
						<span id="error_dni" class="error"></span>
					</span>
				
					<span class="form_grupo">
						<label class ="label" for ="id_contraseña">Contraseña: </label>
						<input onblur ="" id ="id_contraseña"type="text" name="contraseña" maxlength="20" placeholder="ingrese su contraseña" value="Escude123">
						<input name="contraseña_encriptada" type="hidden" value="">
						<span id="error_contraseña" class="error"></span>
					</span>
				</fieldset>
				
				
				<fieldset class = "fieldset field_acciones" name="acciones_botones">
					<!-- <a  id="id_envio" class="boton" type ="button" onclick = "enviar_formulario();" href = "pagina_ingreso.html">enviar</a> -->
					<button id="id_envio" class="boton" type ="button" onclick = "enviar_formulario ();" href = "pagina_ingreso.html">ingresar</button>
					<button id="id_borrar" class="boton" type ="button" onclick = "borrar();">borrar</button>
					<button id="id_registrarse" class="boton" type ="button" onclick = "ir_registro();">registrarse</a></button>
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