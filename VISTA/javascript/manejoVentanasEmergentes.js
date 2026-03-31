if (typeof raiz === 'undefined') {
    window.raiz = (window.BASE_URL || "/sistema_web_inmobiliario/").replace(/\/$/, "") + "/";
}
function expandir_foto (img){
    const ventana = new Ventana_emergente("ventana_foto", 800, 800);

    const articulo = ventana.get_article();
    articulo.style = "position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); display:flex; justify-content:center; align-items:center; z-index:1000;";
    articulo.onclick = () => modal.remove(); // Cerrar al hacer clic fuera

    let imagenGrande = document.createElement("img");
    imagenGrande.setAttribute("src", `${img.src}`);
    imagenGrande.setAttribute("style", "max-width:90%; max-height:90%; border:5px solid white;");

    articulo.appendChild(imagenGrande);
}

function ventana_mensaje(nro_inmueble, titulo) {
    const ventana = new Ventana_emergente("ventana_contacto", 600, 700);
    const nuevaVentana = ventana.new_window;
    const doc = nuevaVentana.document;


    const html_head = `
        <meta charset="UTF-8">
        <link rel="stylesheet" href="${raiz}VISTA/css/index.css">
        <link rel="stylesheet" href="${raiz}VISTA/css/formulario_estilos.css">
        <title>Contacto por: ${titulo}</title>
    `;

    //paso el nro_de inmueble por hidden
    const html_formulario = `
    <h2>Consulta por: ${titulo}</h2>
    <form id="id_formulario_mensaje" method="POST">
        <input type="hidden" name="nro_inmueble" value="${nro_inmueble}">

        <fieldset class="fieldset">
            <legend class="legend">Datos Personales</legend>
            <span class="form_grupo">
                <label class="label">Nombre:</label>
                <input id="id_nombre" type="text" name="nombre" required value="Santiago">
            </span>
            <span class="form_grupo">
                <label class="label">Apellido:</label>
                <input id="id_apellido" type="text" name="apellido" required value="Servin">
            </span>
        </fieldset>

        <fieldset class="fieldset">
            <legend class="legend">Contacto</legend>
            <span class="form_grupo">
                <label class="label">Email:</label>
                <input id="id_email" type="email" name="email" required value="santiago@servin.com">
            </span>
            <span class="form_grupo">
                <label class="label">Celular:</label>
                <input id="id_numero_cel" type="text" name="nro_celular" value="12345678">
            </span>
        </fieldset>

        <fieldset class="fieldset">
            <legend class="legend">Mensaje</legend>
            <textarea id="id_mensaje" name="cuerpo_mensaje" class="textarea" rows="5" placeholder="Escriba su consulta..."></textarea>
        </fieldset>

        <fieldset class="fieldset field_acciones">
            <button id="id_envio" class="boton" type="submit">Enviar Consulta</button>
            <button class="boton" type="button" onclick="window.close()">Cerrar</button>
        </fieldset>
    </form>
    `;

    doc.head.innerHTML = html_head;
    ventana.get_article().innerHTML = html_formulario;

    // no me lo lee directamente en el html head para evitar líos de rutas
    const scriptEnvio = doc.createElement("script");
    scriptEnvio.text = `
        document.getElementById("id_formulario_mensaje").addEventListener('submit', async function(evento) {
            evento.preventDefault();
            const datos = new FormData(this);
            
            try {
                const respuesta = await fetch('${raiz}CONTROLADOR/ProcesaEnvioMensaje.php', {
                    method: 'POST',
                    body: datos
                });
                const resultado = await respuesta.json();

                if (resultado.exito) {
                    alert("¡Mensaje enviado con éxito!");
                    window.close();
                } else {
                    alert("Error: " + resultado.mensaje);
                }
            } catch (error) {
                console.error("Error:", error);
                alert("No se pudo conectar con el servidor.");
            }
        });
    `;
    doc.body.appendChild(scriptEnvio);
}