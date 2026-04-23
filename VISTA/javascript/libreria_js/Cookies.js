function setValorCookie(nombreCookie, valor, vigencia = 6000) {
    // Usamos un parámetro por defecto para la vigencia
    document.cookie = `${nombreCookie}=${valor};max-age=${vigencia};path=/;secure;samesite=strict`;
}

function getValorCookie(nombreCookie) {
    let nombre = nombreCookie + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim(); // Eliminamos espacios en blanco
        if (c.indexOf(nombre) == 0) {
            return c.substring(nombre.length, c.length);
        }
    }
    return null;
}

function existeCookie(nombreCookie) {
    return getValorCookie(nombreCookie) !== null;
}

function actualizarCookieVisita() {
    var nombreCookie = "visitas";
    let contador = 1;

    if (existeCookie(nombreCookie)) {
        let valor_actual = getValorCookie(nombreCookie);
        contador = parseInt(valor_actual) + 1;
    }
    setValorCookie(nombreCookie, contador);
}

function actualizarCookieUltimoAcceso() {
    let fecha = new Date();
    let nombreCookie = "ultimo_acceso";
    //(mes +1 porque inicia en 0)
    let aux = `${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()} ${fecha.getHours()}:${fecha.getMinutes()}:${fecha.getSeconds()}`;
    
    setValorCookie(nombreCookie, aux);
}

function eliminarCookie(nombreCookie) {
    document.cookie = nombreCookie + "=; max-age=0; path=/;secure";
}

function cargo_cookies() {
    let nombreVistas = "visitas";
    let nombreAcceso = "ultimo_acceso";

    if (existeCookie(nombreAcceso)) {
        document.getElementById("id_fecha_ultimo_acceso").textContent = "Último acceso: " + getValorCookie(nombreAcceso);
    } else {
        document.getElementById("id_fecha_ultimo_acceso").textContent = "Es su primera visita";
    }

    actualizarCookieVisita();
    actualizarCookieUltimoAcceso();
    
    document.getElementById("id_visitas").textContent = "Visitas: " + getValorCookie(nombreVistas);
}