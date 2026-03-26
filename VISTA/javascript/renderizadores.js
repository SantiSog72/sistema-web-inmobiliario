function renderizarTarjetasJSON(listaInmuebles) {
    limpiar_contenedor('id_contenedor_catalogo');

    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_catalogo');
        return;
    }

    //array de objetos JSON
    listaInmuebles.forEach(item => {
        // Armar tarjeta 
        //se guarda el id del objeto
        const htmlTarjeta = `
            <div id="${item.id_operacion}" class="tarjeta_operacion">
                <p>
                    ${item.titulo} - 
                    <strong>${item.inmueble.ubicacion.zona}</strong> - 
                    ${item.tipo}: $${item.precio}
                </p>
                <button class="boton boton_mas_info" type="button" data-id="${item.id_operacion}" >más info</button>
            </div>
        `;
        
        agregar_elemento_final(htmlTarjeta, 'id_contenedor_catalogo');
    });
}


function renderizarMasInfo(item) {
    elemento_a_expandir = document.getElementById(item.id); //la etiqueta tiene el id de su objeto
    const htmlMasInfo = `
        <div class="mas_info">
            <h3>${item.titulo} - ${item.tipo}</h3>
            <h4>descipcion<h4>
            <p>${item.inmueble.descripcion}</p>
            <p>Zona: ${item.inmueble.ubicacion.zona} </p>
            <p>Direccion: ${item.inmueble.ubicacion.direccion}</p>
            <button id="id_boton_ver_en_el_mapa" action="">ver en el mapa</button>
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
                    <img class="foto_galeria" src="${foto.path}" alt="imagen de ${foto.descripcion}" onclick="">
                `).join(''):"El inmueble no tiene fotos"}
            </div>
        </div>
    `;
    agregar_elemento_despues_de(htmlMasInfo, item.id_operacion);
}
