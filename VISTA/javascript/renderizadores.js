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
    // elemento_a_expandir = document.getElementById(item.id_operacion); //la etiqueta tiene el id de su objeto
    id_contenedor=`${item.id_operacion},${item.tipo}`;
    const htmlMasInfo = `
        <div class="mas_info">
            <h3>${item.titulo} - ${item.tipo}</h3>
            <h4>descipcion<h4>
            <p>${item.inmueble.descripcion}</p>
            <p>Zona: ${item.inmueble.ubicacion.zona} </p>
            <p>Direccion: ${item.inmueble.ubicacion.direccion}</p>
            <button id="id_boton_ver_en_el_mapa" onclick="accederMapaCoordenadas(${item.inmueble.ubicacion.coordenadas_latitud}, ${item.inmueble.ubicacion.coordenadas_longitud});">ver en el mapa</button>
            ${item.tipo === 'Venta' ? `
                <div class="seccion_venta">
                    <p>Apto crédito hipotecario: ${item.apto_credito ? 'Sí' : 'No'}</p>
                    <h4>Opciones de financiación:</h4>
                    <ul>
                        ${(item.financiacion && item.financiacion.length > 0) ? item.financiacion.map(
                            opcion => `<li>(${opcion.cod_financiacion})- ${opcion.titulo_opcion_financiacion}</li>`).join('') : '<li>No posee</li>'}
                    </ul>
                </div>
            ` : `
                <div class="seccion_alquiler">
                    <p>Plazo del contrato: ${item.plazo} meses</p>
                    <p>Amoblado: ${item.esta_amoblado ? 'Sí' : 'No'}</p>
                </div>
            `}
            <p>Precio: ${item.precio}</p>

            <h4>fotos del inmueble:</h4>
            <div class="contenedor_fotos">
                ${(item.inmueble.lista_fotos && item.inmueble.lista_fotos.length > 0) ? item.inmueble.lista_fotos.map(foto => `
                    <img class="foto_galeria" src="${foto.path}" alt="imagen de ${foto.nombre_foto}" onclick="expandir_foto(this)">
                `).join(''):"El inmueble no tiene fotos"}
            </div>
            <button class="buton envio_mensaje" type ="buton" onclick ="ventana_mensaje(${item.inmueble.nro_inmueble},\'${item.titulo}\')">enviar menasje</button>
        </div>
    `;
    agregar_elemento_despues_de(htmlMasInfo, id_contenedor);

}

function renderizarMisTarjetasJSON(listaInmuebles) {
    limpiar_contenedor('id_contenedor_catalogo');

    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_catalogo');
        return;
    }

    // $lista_venta = listaInmuebles.filter(item => item.tipo === "Venta");
    // $lista_alquiler = listaInmuebles.filter(item => item.tipo === "alquiler");

    // Armar tarjeta vendidos
    listaInmuebles.forEach(item => {

        //contenedor de todo el catalogo
        let contenedor_catalogo = document.getElementById("id_contenedor_catalogo");

        //crea las etiquetas basicas
        let div = document.createElement("div");
        div.setAttribute("id", `${item.id_operacion},${item.tipo}`);
        div.setAttribute("class", "tarjeta_operacion");

        let p = document.createElement("p");
        p.innerHTML =  `${item.titulo} - <strong>${item.inmueble.ubicacion.zona}</strong> - ${item.tipo}: $${item.precio}`;

        div.appendChild(p);

        // let boton_mas_info = document.createElement("button");
        // boton_mas_info.setAttribute("class", "boton boton_mas_info");
        // boton_mas_info.setAttribute("type", "button");
        // boton_mas_info.setAttribute("data-id", `${item.id_operacion},${item.tipo}`);
        // boton_mas_info.textContent = "más info";
        
        // div.appendChild(boton_mas_info);

        

        //crea etiquetaas unicas
        if (item.disponible){
            if (item.tipo === "Alquiler"){
                boton_disponible = crear_boton("boton_alquilar",item, "alquilar");
            }else{
                boton_disponible = crear_boton("boton_vender",item, "vender");
            }
            div.appendChild(boton_disponible);
        }else{
            if (item.tipo === "Alquiler"){
                boton_gestion_pagos = crear_boton("boton_gestion_pagos",item, "gestion pagos");
                div.appendChild(boton_gestion_pagos);
            }
        }

        boton_eliminar_publicacion = crear_boton("boton_eliminar_publicacion",item, "x");
        div.appendChild(boton_eliminar_publicacion);
        
        
        contenedor_catalogo.appendChild(div);

    });
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