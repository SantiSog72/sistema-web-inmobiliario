if (typeof raiz === 'undefined') {
    window.raiz = (window.BASE_URL || "/sistema_web_inmobiliario/").replace(/\/$/, "") + "/";
}
function renderizarTarjetasJSON(listaInmuebles) {
    limpiar_contenedor('id_contenedor_catalogo');

    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_catalogo');
        return;
    }

    //array de objetos JSON
    listaInmuebles.forEach(item => {
        // Armar tarjeta 
        //se guarda el id del objeto y el tipo (se requieren los dos para identificar una operacion)
        const htmlTarjeta = `
            <div id="${item.id_operacion},${item.tipo}" class="tarjeta_operacion">
                <p>
                    ${item.titulo} - 
                    <strong>${item.inmueble.ubicacion.zona}</strong> - 
                    ${item.tipo}: $${item.precio}
                </p>
                <button class="boton boton_mas_info" type="button" data-id="${item.id_operacion},${item.tipo}" >más info</button>
            </div>
        `;
        
        agregar_elemento_final(htmlTarjeta, 'id_contenedor_catalogo');
    });
}



function renderizarMasInfo(item) {
    const id_contenedor = `${item.id_operacion},${item.tipo}`;
    
    const htmlMasInfo = `
        <div class="mas_info_container">
            <div class="mas_info_header">
                <h3>${item.titulo}</h3>
                <span class="badge_precio">$${item.precio}</span>
            </div>

            <div class="mas_info_grid">
                <div class="info_col">
                    <p class="info_item"><strong>📍 Ubicación:</strong> ${item.inmueble.ubicacion.zona} (${item.inmueble.ubicacion.direccion})</p>
                    <p class="info_item"><strong>🏠 Operación:</strong> ${item.tipo}</p>
                    
                    ${item.tipo === 'Venta' ? `
                        <div class="seccion_tipo_especifica venta_box">
                            <p><strong>💳 Apto Crédito:</strong> ${item.apto_credito ? '✅ Sí' : '❌ No'}</p>
                            <p><strong>Financiación:</strong></p>
                            <ul class="lista_finanzas">
                                ${(item.financiacion && item.financiacion.length > 0) ? 
                                    item.financiacion.map(op => `<li>• ${op.titulo_opcion_financiacion}</li>`).join('') 
                                    : '<li>No posee</li>'}
                            </ul>
                        </div>
                    ` : `
                        <div class="seccion_tipo_especifica alquiler_box">
                            <p><strong>⏳ Plazo:</strong> ${item.plazo} meses</p>
                            <p><strong>🛋️ Amoblado:</strong> ${item.esta_amoblado ? '✅ Sí' : '❌ No'}</p>
                        </div>
                    `}
                    
                    <div class="descripcion_texto">
                        <h4>Descripción</h4>
                        <p>${item.inmueble.descripcion}</p>
                    </div>

                    <div class="botones_accion">
                        <button class="boton_mapa" onclick="accederMapaCoordenadas(${item.inmueble.ubicacion.coordenadas_latitud}, ${item.inmueble.ubicacion.coordenadas_longitud});">
                            📍 Ver Mapa
                        </button>
                        <button class="boton_mensaje" onclick="ventana_mensaje(${item.inmueble.nro_inmueble}, '${item.titulo}')">
                            ✉️ Enviar Mensaje
                        </button>
                    </div>
                </div>

                <div class="galeria_col">
                    <h4>Fotos</h4>
                    <div class="contenedor_fotos_grid">
                        ${(item.inmueble.lista_fotos && item.inmueble.lista_fotos.length > 0) ? 
                            item.inmueble.lista_fotos.map(foto => `
                                <img class="foto_galeria_mini" src="${raiz}${foto.path}" alt="Inmueble" onclick="expandir_foto(this)">
                            `).join('') : "<p>Sin fotos disponibles</p>"}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Si ya existe un "mas_info" abierto, lo ideal sería borrarlo antes o validar
    agregar_elemento_despues_de(htmlMasInfo, id_contenedor);
}


function renderizar_tarjeta_basica(item){
    //crea las etiquetas basicas
    let div = document.createElement("div");
    div.setAttribute("id", `${item.id_operacion},${item.tipo}`);
    div.setAttribute("class", "tarjeta_operacion");

    let p = document.createElement("p");
    p.innerHTML =  `${item.titulo} - <strong>${item.inmueble.ubicacion.zona}</strong> - ${item.tipo}: $${item.precio}`;

    div.appendChild(p);
    
    return div;
}

function renderizar_misAlquileres(listaInmuebles){
    limpiar_contenedor('id_contenedor_alquileres_realizados');
    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_alquileres_realizados');
        return;
    }
    const contenedor = document.getElementById("id_contenedor_alquileres_realizados");
    listaInmuebles.forEach(item =>{
        let tarjeta = renderizar_tarjeta_basica(item);
        let boton_gestion_pagos = crear_boton("boton_gestion_pagos",item, "gestion pagos");
        tarjeta.appendChild(boton_gestion_pagos);

        boton_eliminar_publicacion = crear_boton("boton_eliminar_publicacion",item, "x");
        tarjeta.appendChild(boton_eliminar_publicacion);
        contenedor.appendChild(tarjeta);
    });
}

function renderizar_misVentas(listaInmuebles){
    limpiar_contenedor('id_contenedor_ventas_realizadas');
    const contenedor = document.getElementById("id_contenedor_ventas_realizadas");
    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_ventas_realizadas');
        return;
    }
    listaInmuebles.forEach(item =>{
        let tarjeta = renderizar_tarjeta_basica(item);

        boton_eliminar_publicacion = crear_boton("boton_eliminar_publicacion",item, "x");
        tarjeta.appendChild(boton_eliminar_publicacion);
        contenedor.appendChild(tarjeta);
    });
}

function renderizar_misVentas_disponibles(listaInmuebles){
    limpiar_contenedor('id_contenedor_ventas_disponibles');
    const contenedor = document.getElementById("id_contenedor_ventas_disponibles");
    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_ventas_disponibles');
        return;
    }
    listaInmuebles.forEach(item =>{
        let tarjeta = renderizar_tarjeta_basica(item);
        boton_disponible = crear_boton("boton_vender",item, "vender");
        tarjeta.appendChild(boton_disponible);

        boton_eliminar_publicacion = crear_boton("boton_eliminar_publicacion",item, "x");
        tarjeta.appendChild(boton_eliminar_publicacion);
        contenedor.appendChild(tarjeta);
    });
}

function renderizar_misAlquileres_disponibles(listaInmuebles){
    limpiar_contenedor('id_contenedor_alquileres_disponibles');
    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_alquileres_disponibles');
        return;
    }
    const contenedor = document.getElementById("id_contenedor_alquileres_disponibles");
    listaInmuebles.forEach(item =>{
        let tarjeta = renderizar_tarjeta_basica(item);

        let boton_disponible = crear_boton("boton_alquilar",item, "alquilar");
        boton_disponible.onclick = function (){
            //guardar el nro_operacion
            localStorage.setItem("nro_operacion", item.id_operacion);
            ir_registroInquilino();
        };
        tarjeta.appendChild(boton_disponible);
        
        boton_eliminar_publicacion = crear_boton("boton_eliminar_publicacion",item, "x");
        tarjeta.appendChild(boton_eliminar_publicacion);
        contenedor.appendChild(tarjeta);
    });
}

function renderizarMisTarjetasJSON(listaInmuebles) {
    
    
    if (listaInmuebles.length === 0) {
        limpiar_contenedor('id_contenedor_catalogo');
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_catalogo');
        return;
    }


    let lista_alquiler_disponible = listaInmuebles.filter(item => item.tipo === "Alquiler" && item.disponible);
    let lista_alquiler_realizado = listaInmuebles.filter(item => item.tipo === "Alquiler" && !item.disponible);
    let lista_venta_realizada = listaInmuebles.filter(item => item.tipo === "Venta" && !item.disponible);
    let lista_venta_disponible = listaInmuebles.filter(item => item.tipo === "Venta" && item.disponible);

    renderizar_misAlquileres(lista_alquiler_realizado);
    renderizar_misAlquileres_disponibles(lista_alquiler_disponible);
    renderizar_misVentas(lista_venta_realizada);
    renderizar_misVentas_disponibles(lista_venta_disponible);

}

function crear_boton (clase, item, texto){
    boton = document.createElement("button");
    boton.setAttribute("class",`boton ${clase}`);
    boton.setAttribute("type", "button");
    boton.setAttribute("data-id", `${item.id_operacion},${item.tipo}`);
    boton.textContent = `${texto}`;
    return boton;
}

function renderizar_mensajesJSON (lista_mensajes, id_contenedor){
    limpiar_contenedor(id_contenedor);
    const mi_catalogo_txt = localStorage.getItem("mi_catalogo");
    const lista_catalogo = JSON.parse(mi_catalogo_txt);

    if (lista_mensajes.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", id_contenedor);
        return;
    }
    
    
    lista_mensajes.forEach(item => {
        
        let operacion = lista_catalogo.find(element => element.inmueble.nro_inmueble === item.nro_inmueble)
        let titulo = operacion.titulo;
        let tipo_operacion = operacion.tipo;
        // Armar tarjeta 
        const htmlTarjeta = `
            <div id="${item.nro_mensaje}" class="tarjeta_mensaje">
                <p>Titulo Publicacion: ${titulo} </p>
                <p>Tipo Operacion: ${tipo_operacion} </p>
                <p>direccion: ${item.direccion} </p>
                <p>Mensaje de: ${item.nombre} ${item.apellido}</p>
                <p>Contacto: </p>
                <p>Numero de Telefono: ${item.nro_celular}</p>
                <p>Direccion de Correo: ${item.email}</p>
                <p class="textarea" >Mensaje: ${item.Cuerpo_mensaje}</p>
            </div>
        `;
        
        agregar_elemento_final(htmlTarjeta, id_contenedor);
    });

}