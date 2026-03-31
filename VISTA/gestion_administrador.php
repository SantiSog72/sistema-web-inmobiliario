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
<meta name="description" content="Pagina Gestion Administrador">

<script type="text/javascript" src ="javascript/libreria_js/ubicador_elementos.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="text/javascript" src ="javascript/ManejoMapa.js"></script>
<script type="text/javascript" src ="javascript/renderizadores.js"></script>
<script type="text/javascript" src ="javascript/libreria_js/Cookies.js"></script>
<script type="text/javascript" src ="javascript/botones_hipervinculo.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const contenedor = document.getElementById('id_contenedor_catalogo');
		cargo_cookies();

		// 1. Función para obtener y mostrar datos
		async function cargarCatalogo() {
			try {
				const url = '../CONTROLADOR/ProcesaMisInmuebles.php';
				const respuesta = await fetch(url);
				const lista_inmuebles = await respuesta.json();
				localStorage.setItem("mi_catalogo", JSON.stringify(lista_inmuebles));
				renderizarMisTarjetasJSON(lista_inmuebles);
			} catch (error) {
				console.error("Error al cargar el catálogo:", error);
				contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
			}
		}

		// async function cargarMensajes() {
		// 	try {
		// 		const respuesta = await fetch('../CONTROLADOR/ProcesaTraerMensajes.php');
		// 		const lista_mensajes = await respuesta.json();
		// 		//if hay no vistos
		// 		if (lista_mensajes){
		// 			renderizar_mensajesJSON (lista_mensajes);
		// 		}else{
		// 		}
		// 	} catch (error) {
		// 		console.error("Error al cargar los mensajes:", error);
		// 		contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
		// 	}
		// }

		async function cargarMensajes() {
			try {
				const respuesta = await fetch('../CONTROLADOR/ProcesaTraerMensajes.php');
				const lista_mensajes = await respuesta.json();
				
				const indicador = document.getElementById('mensajes_nuevos');

				let contador_mensajes_nuevos = 0;
				lista_mensajes_nuevos = lista_mensajes.filter(mensaje => !mensaje.visto);
				lista_mensajes_vistos = lista_mensajes.filter(mensaje => mensaje.visto);
				
				if (lista_mensajes_nuevos && lista_mensajes_nuevos.length > 0) {
					indicador.innerHTML = `Tienes <strong>${lista_mensajes_nuevos.length}</strong> mensajes nuevos.`;
					indicador.className = "notificacion_activa"; // Agregale estilo en CSS
					renderizar_mensajesJSON(lista_mensajes_nuevos, "id_contenedor_mensajes_nuevos");
				} else {
					indicador.textContent = "No hay mensajes nuevos.";
				}
				renderizar_mensajesJSON(lista_mensajes_vistos, "id_contenedor_mensajes_vistos");
			} catch (error) {
				console.error("Error al cargar los mensajes:", error);
			}
		}

		cargarCatalogo(); 
		cargarMensajes(); 
	});

</script>

<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="css/formulario_estilos.css">

<title>Pagina Gestion Administrador</title>
</head>
<!-- con el onload trae todo el catalogo para mostrar -->
<body> 
	<header>
	<h1>Gestion de Inmuebles</h1>
	<nav class="contenedor_mapa">
		<button class= "boton" onclick="ir_index()">Log out</button>
		<button class= "boton" onclick="ir_AltaOperacion()">Alta Operacion</button>
		<span>
		</span>
		<button class= "boton" onclick="iniciar_mapa_inmuebles()">Mapa de Mi Catalogo</button>
		<button class= "boton" onclick="ocultarMapa()">Ocultar Mapa</button>
	</nav>
	
	<p id ="mensajes_nuevos"></p>
	<p id="id_visitas"></p>
	<p id ="id_fecha_ultimo_acceso"></p>
	</header>

	<div id="id_mapa_div">


	</div>
	
	<main>
		<!-- <section id="id_filtros_busqueda">
			<form id="id_formulario_busqueda" name="formulario_busqueda" method="GET">
				<fieldset class="fieldset contenedor_formulario">
					<legend class="legend">buscar inmuebles</legend>

					<span class="form_grupo">
					<label class ="label" for ="id_tipo_operacion">Tipo Operacion</label>
					<select class="select" id="id_tipo_operacion" name="operacion" size="1">
						<option class="option" value="alquiler" selected>Alquiler</option>
						<option class="option" value="alquiler_amoblado">Alquiler Amueblado</option>
						<option class="option" value="venta">Venta</option>
					</select>
					<span id="error_tipo_operacion" class="error"></span>
					</span>	

					<span class="form_grupo">
						<label class ="label" for ="id_zona">Zona</label>
						<select class="select" id="id_zona" name="zona" size="1">
							<option class="option" value="zona_norte">Zona Norte</option>
							<option class="option" value="zona_sur">Zona Sur</option>
							<option class="option" value="zona_centro" selected>Zona Centro</option>
							<option class="option" value="rada_tilly">Rada Tilly</option>
						</select>
						<span id="error_Zona" class="error"></span>
					</span>

					<span class="contenedor_checkbox_radio">
						<p class="titulo_de_contenedor">Tipo Propiedad</p>
						<input class="checkbox" type="checkbox" name="casa" value="1">
						<label class="label">casa</label><br>
						<input class="checkbox" type="checkbox" name="departamento" value="1">
						<label class="label">departamento</label><br>
						<input class="checkbox" type="checkbox" name="oficina" value="1">
						<label class="label">oficina</label><br>
						<input class="checkbox" type="checkbox" name="terreno" value="1">
						<label class="label">terreno</label><br>
						<input class="checkbox" type="checkbox" name="cochera" value="1">
						<label class="label">cochera</label><br>
						<span id="error_tipo_propiedad" class="error"></span>
					</span>


					<span class="contenedor_checkbox_radio">
						<p class="titulo_de_contenedor">otras caracteristicas</p>
						<input class="checkbox" type="checkbox" name="quincho" value="1">
						<label class="label">quincho</label><br>
						<input class="checkbox" type="checkbox" name="garage" value="1">
						<label class="label">garage</label><br>
						<input class="checkbox" type="checkbox" name="lavadero" value="1">
						<label class="label">lavadero</label><br>
						<input class="checkbox" type="checkbox" name="patio" value="1">
						<label class="label">patio</label><br>
						<span id="error_opciones" class="error"></span>
					</span>
					
					<span class="form_grupo">
						<button type="submit" id="id_buscar">buscar</button>
						<button  type="reset" id="id_limpiar">quitar filtros</button>
					</span>
				</fieldset>

			</form> 
		</section> -->
		
		<section class="section_catalogo">
			<h2 class="titulo_de_contenedor">mis inmuebles</h2>
			<div id="id_contenedor_catalogo" class="contenedor_catalogo">
			</div>
		</section>

		<section class="seccion_mensajes">
			<div id="id_contenedor_mensajes" class="contenedor_mensajes">
				<h2 id="id_titulo_mensajes_nuevos" class="titulo_de_contenedor"> Mensajes Nuevos</h2>
				<div id="id_contenedor_mensajes_nuevos" class="contenedor_mensajes"></div>
				<h2 id="id_titulo_mensajes_vistos" class="titulo_de_contenedor">Mensajes Vistos</h2>
				<div id="id_contenedor_mensajes_vistos" class="contenedor_mensajes"></div>
			</div>
		</section>
	</main>
	<footer>
	<div id="descripcion_pagina">
		<p>autor: <span class="autor">Santiago Servin</span></p>
		<p>Final Libre 2026</p>		
	</div>
	</footer>
	
</body>

</html>