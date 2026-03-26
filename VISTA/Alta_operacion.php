<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="autor" content="Santiago Servin">
<meta name="description" content="Pagina Alta Operacion inmobiliaria">

<script type="text/javascript" src ="javascript/libreria_js/ubicador_elementos.js"></script>
<script type="text/javascript" src ="javascript/renderizadores.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {//DOMContentLoaded: evento que se produce al cargar la pagina
		const formulario = document.getElementById('id_formulario_registro_operacion');
		const fotos = document.getElementById('id_fotos');

		fotos.addEventListener('change', function(e) {
            const listaUl = document.getElementById('lista_nombres');
            listaUl.innerHTML = ''; // Limpiar la lista previa

            const archivos = e.target.files;

            if (archivos.length > 0) {
                for (let i = 0; i < archivos.length; i++) {
                    const li = document.createElement('li');
                    // Enumeramos (i + 1) y mostramos el nombre del archivo
                    li.textContent = `${i + 1}. ${archivos[i].name}`;
                    li.style.fontSize = "14px";
                    li.style.color = "#333";
                    listaUl.appendChild(li);
                }
            } else {
                listaUl.innerHTML = '<li>No hay archivos seleccionados.</li>';
            }
        });

		//CARGA POR BÚSQUEDA: Se ejecuta al enviar el formulario
		formulario.addEventListener('submit', async function(evento) {
            evento.preventDefault(); // Evita la recarga de la página

            // 1. Recolectamos TODOS los datos (incluye archivos)
            const datos = new FormData(formulario);

            try {
                // 2. Enviamos los datos al servidor mediante fetch
                const respuesta = await fetch('ProcesaAltaOperacion.php', {
                    method: 'POST',
                    body: datos // Enviamos el FormData directamente
                });

                // 3. Verificamos la respuesta
                if (respuesta.ok) {
                    const resultado = await respuesta.text(); // O .json() si tu PHP devuelve JSON
                    console.log("Servidor dice:", resultado);
                    alert("Operación procesada con éxito");
                    
                    // Opcional: limpiar el formulario tras el éxito
                    // formulario.reset();
                    // document.getElementById('lista_nombres').innerHTML = '<li>Aun no hay archivos seleccionados.</li>';
                } else {
                    console.error("Error en el servidor:", respuesta.status);
                    alert("Hubo un error al procesar el formulario.");
                }
            } catch (error) {
                console.error("Error de red o conexión:", error);
                alert("No se pudo conectar con el servidor.");
            }
        });

		formulario.addEventListener('reset', async function(){
			// localStorage.removeItem("catalogo_actual");
			// cargarCatalogo();
		})

		// //evento del mas-info
		// contenedor.addEventListener("click", function(evento){
		// 	if (evento.target.classList.contains('boton_mas_info')) {
        //         const idOperacion = evento.target.getAttribute('data-id'); //id del objeto que se guardo en el boton
		// 		//busca en local storage
		// 		const lista_catalogo_str = localStorage.getItem("catalogo_actual");
		// 		if (lista_catalogo_str){
		// 			const lista_catalogo = JSON.parse(lista_catalogo_str);
		// 			//busca el objeto a expandir
		// 			const operacion_selecionada = lista_catalogo.find(item =>item.id_operacion == idOperacion);
		// 			if (operacion_selecionada){
		// 				// console.log(idOperacion);
		// 				console.log(JSON.stringify(operacion_selecionada, null, 2));
		// 				renderizarMasInfo(operacion_selecionada);
		// 			}else{
		// 				console.log("no se encontro la operacion");
		// 			}
		// 		}else{
		// 			console.log("no se encontro catalogo en local storage");
		// 		}
                
        //     }
		// })


	});

</script>

<link rel="stylesheet" href="css//index.css">
<link rel="stylesheet" href="css/formulario_estilos.css">
<link rel="stylesheet" href="css//index.css">

<title>Alta Operacion inmobiliaria</title>
</head>

<body>
	<header>
	<h1>Registrar una Nueva Publicacion Inmobiliaria</h1>
	</header>
	<section>
		<article class= "contenedor_formulario">
			<form id="id_formulario_registro_operacion" class "formulario" name="formulario_registro_operacion" method="POST" enctype="multipart/form-data">

                <fieldset class = "fieldset" name="datos de la operacion">
                    <legend class = "legend" >Datos de la Operacion</legend>

                    <span class="form_grupo">
                        <label class="label" for="id_titulo_publicacion">Título Publicación: </label>                   
                        <input id="id_titulo_publicacion" type="text" name="titulo_publicacion" placeholder="Ingrese el título de la publicación">
                        <span id="error_titulo_publicacion" class="error"></span>
                    </span>

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
                        <label class="label" for="id_precio">Precio: </label>                   
                        <input id="id_precio" type="number" name="precio" placeholder="Ingrese el precio">
                        <span id="error_precio" class="error"></span>
                    </span>

                    <!-- unicos de Alquiler -->
                    <span class="form_grupo">
                        <label class="label" for="id_plazo">Plazo (en meses): </label>                   
                        <input id="id_plazo" type="number" name="plazo" placeholder="Ingrese el plazo en meses">
                        <span id="error_plazo" class="error"></span>
                    </span>

                    <!-- unicos de Venta -->
                    <span class="contenedor_checkbox_radio">
						<p class="titulo_de_contenedor">Opciones Financiacion</p>
						<!-- carga las opciones de financiacion disponibles en BDD -->
						<span id="error_tipo_propiedad" class="error"></span>
					</span>

                    <span class="contenedor_checkbox_radio">
						<!-- <p class="titulo_de_contenedor">Apto para credito hipotecario</p> -->
						<input class="checkbox" type="checkbox" name="apto_credito_hipotecario" value="1">
						<label class="label">Apto para credito hipotecario</label><br>
                    </span>
                    
				</fieldset>
				
                <fieldset class = "fieldset" name="datos del inmueble">
                    <legend class = "legend" >Datos del Inmueble</legend>
                    
                    <span class="form_grupo">
					<label class ="label" for ="id_tipo_propiedad">Tipo Propiedad</label>
					<select class="select" id="id_tipo_propiedad" name="tipo_propiedad" size="1">
						<option class="option" value="departamento" selected>Departamento</option>
						<option class="option" value="casa">Casa</option>
						<option class="option" value="terreno">Terreno</option>
						<option class="option" value="oficina">Oficina</option>
						<option class="option" value="cochera">Cochera</option>
					</select>
					<span id="error_tipo_inmueble" class="error"></span>
					</span>	

                    <span class="form_grupo">
                        <label class="label" for="id_descripcion_inmueble">Descripción: </label> 
                        <textarea id="id_descripcion_inmueble" type="textarea" name="descripcion_inmueble" maxlength="500" cols="100" rows="4"></textarea>                  
                        <!-- <input id="id_descripcion_inmueble" type="text-area" name="descripcion_inmueble" maxlength="500" placeholder="Ingrese la descripción del inmueble"> -->
                        <span id="error_descripcion_inmueble" class="error"></span>
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

                    
                </fieldset>
                
                <fieldset class = "fieldset" name="datos de ubicacion">
                    <legend class = "legend" >Datos de la Ubicacion</legend>
                    
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

                    <span class="form_grupo">
                        <label class="label" for="id_direccion">Direccion: </label>                   
                        <input id="id_direccion" type="text" name="direccion_inmueble" placeholder="Ingrese la direccion del inmueble">
                    <span id="error_direccion_inmueble" class="error"></span>

                    <span class="form_grupo">
                        <label class="label" for="id_coordenadas_longitud">coordenadas longitud: </label>                   
                        <input id="id_coordenadas_longitud" type="text" name="coordenadas_longitud_inmueble" placeholder="Ingrese la coordenadas_longitud del inmueble">
                        <label class="label" for="id_coordenadas_longitud">coordenadas latitud: </label>                   
                        <input id="id_coordenadas_latitud" type="text" name="coordenadas_latitud_inmueble" placeholder="Ingrese la coordenadas_latitud del inmueble">
                    <span id="error_coordenadas_inmueble" class="error"></span>

                </fieldset>

                <fieldset class = "fieldset" name="fotos del inmueble">
                    <legend class = "legend" >Subir las fotos del inmueble</legend>
                    <span class="form_grupo">
                        <label class="label" for="id_fotos">Fotos del Inmueble: </label>                   
                        <input id="id_fotos" type="file" name="fotos[]" accept="image/*" multiple>
                        <span id="error_fotos" class="error"></span>
                    </span>

                    <div id="lista_archivos_subida" style="margin-top: 10px; font-family: sans-serif;">
                        <p class="titulo_de_contenedor">Lista de Archivos seleccionados</p>
                        <ul id="lista_nombres">
                            <li>Aun no hay archivos seleccionados.</li>
                        </ul>
                    </div>

                </fieldset>
			
				
				<fieldset class = "fieldset" name="acciones_botones">
					<legend class = "legend" >acciones</legend>		
					<button id="id_envio" class="boton" type ="submit" onclick = "validar_formulario();">crear publicacion</button>
					<button id="id_cancelar" class="boton" type ="reset">cancelar</button>
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