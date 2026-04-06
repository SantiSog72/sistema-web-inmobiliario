<?php
// Esto busca el archivo desde la raíz de tu htdocs/www
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema_web_inmobiliario/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina Gestion Administrador">
<script>
    window.BASE_URL = "<?= WEB_ROOT ?>";
</script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/libreria_js/ubicador_elementos.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/ManejoMapa.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/renderizadores.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/libreria_js/Cookies.js"></script>
<script type="text/javascript" src ="<?= WEB_ROOT ?>VISTA/javascript/botones_hipervinculo.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const contenedor = document.getElementById('id_contenedor_catalogos');
		cargo_cookies();

		// 1. Función para obtener y mostrar datos
		async function cargarCatalogo() {
			try {
				const url = '<?= WEB_ROOT ?>CONTROLADOR/ProcesaMisInmuebles.php';
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
				const respuesta = await fetch('<?= WEB_ROOT ?>CONTROLADOR/ProcesaTraerMensajes.php');
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

<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/index.css">
<link rel="stylesheet" href="<?= WEB_ROOT ?>VISTA/css/formulario_estilos.css">

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
		
		<h2 class="titulo_de_contenedor">mis inmuebles</h2>
		<section class="section_catalogo">
			<div id="id_contenedor_catalogos">
				<h2 id="id_titulo_alquileres_realizados" class="titulo_de_contenedor"> Alquileres Realizados</h2>
				<div id="id_contenedor_alquileres_realizados" class="contenedor_catalogo"></div>
				<h2 id="id_titulo_alquileres_disponibles" class="titulo_de_contenedor"> Alquileres Disponibles</h2>
				<div id="id_contenedor_alquileres_disponibles" class="contenedor_catalogo"></div>
				<h2 id="id_titulo_ventas_disponibles" class="titulo_de_contenedor"> Ventas Disponibles</h2>
				<div id="id_contenedor_ventas_disponibles" class="contenedor_catalogo"></div>
				<h2 id="id_titulo_ventas_realizadas" class="titulo_de_contenedor"> Ventas Realizadas</h2>
				<div id="id_contenedor_ventas_realizadas" class="contenedor_catalogo"></div>
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