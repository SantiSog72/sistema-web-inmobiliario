function renderizarTarjetasJSON(listaInmuebles) {
    limpiar_contenedor('id_contenedor_catalogo');

    if (listaInmuebles.length === 0) {
        agregar_elemento_final("<p>No se encontraron resultados.</p>", 'id_contenedor_catalogo');
        return;
    }

    //array de objetos JSON
    listaInmuebles.forEach(item => {
        // Armar tarjeta
        const htmlTarjeta = `
            <div class="tarjeta_operacion">
                <p>
                    ${item.titulo} - 
                    <strong>${item.zona}</strong> - 
                    ${item.tipo}: $${item.precio}
                </p>
                <button class="boton" type="button">más info</button>
            </div>
        `;
        
        agregar_elemento_final(htmlTarjeta, 'id_contenedor_catalogo');
    });
}