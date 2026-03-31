if (typeof raiz === 'undefined') {
    window.raiz = (window.BASE_URL || "/sistema_web_inmobiliario/").replace(/\/$/, "") + "/";
}
var mapa_actual = null;
const id_contenedor_mapa = "id_mapa_div";

function iniciar_mapa_inmuebles(){
    
    var latCentro = -45.862237; 
    var lngCentro = -67.518005;
    generoMapa(latCentro, lngCentro, 12);
}

function generoMapa(lat, lng, zoom) {
    var contenedor_mapa = document.getElementById(id_contenedor_mapa);
    contenedor_mapa.style.height= "500px";
    contenedor_mapa.style.width= "100%";
    contenedor_mapa.style.borderRadius="20px";
    // 1. Inicializar el mapa
    mapa_actual = L.map(id_contenedor_mapa).setView([lat, lng], zoom);

    // 2. Cargar la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa_actual);

    crearMarcadores();
}

function crearMarcadores() {
    var miIcono = L.icon({
        iconUrl: `${raiz}imagenes/iconos/icono_casa_negro.png`,
        iconSize: [38, 38],
        iconAnchor: [19, 38],
        popupAnchor: [0, -38]
    });

    var catalogo_str = localStorage.getItem("catalogo_actual");
    
    if (catalogo_str) {
        var lista_Json_catalogo = JSON.parse(catalogo_str);
        
        lista_Json_catalogo.forEach(element => {
            let titulo = element.titulo;
            let tipo_operacion = element.tipo;
            let lat = element.inmueble.ubicacion.coordenadas_latitud;
            let lng = element.inmueble.ubicacion.coordenadas_longitud;

            if (lat && lng) {
                L.marker([lat, lng], { icon: miIcono })
                    .addTo(mapa_actual) 
                    .bindPopup(`<b>${tipo_operacion} - ${titulo}</b>`); 
            }
        });
    }
}

function ocultarMapa(){
    if (mapa_actual){
        mapa_actual.remove();
        limpiar_contenedor(id_contenedor_mapa);
        var contenedor_mapa = document.getElementById(id_contenedor_mapa);
        contenedor_mapa.style.height= "0px";
        contenedor_mapa.style.width= "0px";
    }

}

function accederMapaCoordenadas($lat_inmueble_seleccionado, $lng_inmueble_seleccionado){

    if (mapa_actual){
        mapa_actual.remove();
    }
    contenedor_mapa = document.getElementById(id_contenedor_mapa);
    if (contenedor_mapa) {
        contenedor_mapa.scrollIntoView({ 
            behavior: 'smooth', // Hace que el movimiento sea fluido y no un salto brusco
            block: 'start'      // Alinea el div en la parte superior de la pantalla
        });
    }
    generoMapa($lat_inmueble_seleccionado, $lng_inmueble_seleccionado, 18);
}

function muestraError(error) {
    console.error("Error de geolocalización:", error);
    alert("No se pudo obtener la ubicación: " + error.message);
}