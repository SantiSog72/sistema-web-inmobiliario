<?php
// Define la ruta base del proyecto
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

require_once BASE_PATH.'CONTROLADOR/ControladorCatalogo.class.php';
// $ControladorCatalogo = new ControladorCatalogo();
// $catalogo = $ControladorCatalogo -> get_lista_catalogo();
// echo "<pre>";
// var_dump($catalogo);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina principal">

<script type="text/javascript" src ="VISTA/javascript/libreria_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="VISTA/javascript/libreria_js/Ventana_emergente.js"></script>
<script type="text/javascript" src ="VISTA/javascript/manejoVentanasEmergentes.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="text/javascript" src ="VISTA/javascript/ManejoMapa.js"></script>
<script type="text/javascript" src ="VISTA/javascript/renderizadores.js"></script>
<script type="text/javascript" src ="VISTA/javascript/libreria_js/Cookies.js"></script>
<script type="text/javascript" src ="VISTA/javascript/botones_hipervinculo.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const formulario = document.getElementById('id_formulario_busqueda');
		const contenedor = document.getElementById('id_contenedor_catalogo');

		// cargo_cookies();

		// 1. Función para obtener y mostrar datos
		async function cargarCatalogo(parametros = "") {
			try {
				// Si hay parámetros agregamos el ?, si no, llamamos al archivo pelado
				//la URL de un archivo del servidor que procesa los datos
				const url = 'CONTROLADOR/ProcesaBuscar.php' + (parametros ? '?' + parametros : '');
				//se realiza el pedido al servidor
				const respuesta = await fetch(url);
				// console.log (respuesta);
				//se recibe la respuesta y se la castea objeto json
				const lista_inmuebles = await respuesta.json();
				// console.log (lista_inmuebles);

				//combierte el json en string, luego guarda catalogo en local storage
				localStorage.setItem("catalogo_actual", JSON.stringify(lista_inmuebles));

				
				renderizarTarjetasJSON(lista_inmuebles);
			} catch (error) {
				console.error("Error al cargar el catálogo:", error);
				contenedor.innerHTML = "<p>Error al cargar los datos.</p>";
			}
		}

		// 2. CARGA INICIAL: Se ejecuta apenas abre la página
		cargarCatalogo(); 

		// 3. CARGA POR BÚSQUEDA: Se ejecuta al enviar el formulario
		formulario.addEventListener('submit', async function(evento) {
			evento.preventDefault(); //evita que se recargue la pagina (que se envie el formulario)
			const datos = new FormData(formulario);//recolecta la informacion del formulario que se estaba por enviar
			const params = new URLSearchParams(datos).toString();//transforma la info del formualrio a un string para el servidor
			//en un formato que el servidor entiede
			
			cargarCatalogo(params);
		});

		formulario.addEventListener('reset', async function(){
			localStorage.removeItem("catalogo_actual");
			cargarCatalogo();
		})

		//evento del mas-info
		contenedor.addEventListener("click", function(evento) {
			if (evento.target.classList.contains('boton_mas_info')) {
				// 1. Obtenemos los datos del botón
				const idOperacion_tipoOperacion = evento.target.getAttribute('data-id');
				const [idOperacion, tipoOperacion] = idOperacion_tipoOperacion.split(",");

				// 2. Buscamos en localStorage
				const lista_catalogo_str = localStorage.getItem("catalogo_actual");
				
				if (lista_catalogo_str) {
					const lista_catalogo = JSON.parse(lista_catalogo_str);

					// 3. Usamos .find() para recuperar el objeto directamente
					// Importante: Asegúrate de que idOperacion sea del mismo tipo (número o string)
					const operacion_seleccionada = lista_catalogo.find(item => 
						item.tipo === tipoOperacion && item.id_operacion == idOperacion
					);

					if (operacion_seleccionada) {
						console.log("Operación encontrada:", operacion_seleccionada);
						renderizarMasInfo(operacion_seleccionada);
					} else {
						console.warn("No se encontró la operación con ID:", idOperacion);
					}
				} else {
					console.error("No se encontró catálogo en local storage");
				}
			}
		});


	});

</script>

<link rel="stylesheet" href="VISTA/css/index.css">
<link rel="stylesheet" href="VISTA/css/formulario_estilos.css">
<!-- <link rel="stylesheet" href="VISTA/css//mapas.css"> -->

<title>Sistema Informacion Inmoviliaria</title>
</head>
<!-- con el onload trae todo el catalogo para mostrar -->
<body> 
	<header>
	<h1>Sistema Informacion Inmoviliaria</h1>
	<nav class="contenedor_mapa">
		<button class= "boton" onclick="ir_singIn();">Iniciar sesion</button>
		<button class= "boton" onclick="ir_singUp();">registrarse</button>
		<button class= "boton" onclick="iniciar_mapa_inmuebles()">Mapa Catalogo Completo</button>
		<button class= "boton" onclick="ocultarMapa()">Ocultar Mapa</button>
	</nav>

	<!-- <p id="id_visitas"></p>
	<p id ="id_fecha_ultimo_acceso"></p> -->
	</header>

	<div id="id_mapa_div">


	</div>
	
	<main>
		<section id="id_filtros_busqueda">
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
		</section>
		
		<section class="section_catalogo">
			<h2 class="titulo_de_contenedor">catálogo</h2>
			<div id="id_contenedor_catalogo" class="contenedor_catalogo">
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