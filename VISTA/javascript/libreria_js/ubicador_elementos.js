// este es el ubicador_elemento.js

//limpia todo el contenedor o un elemento dentro de este
function limpiar_contenedor (id_contenedor, id_elemento){//sobrecarga de parametros en js
	let contenedor = document.getElementById(id_contenedor);
	if (id_elemento != undefined && document.getElementById(id_elemento)){
        contenedor.removeChild(document.getElementById(id_elemento)); 		
	}else{
	contenedor.innerHTML="";
	}
}


function agregar_elemento_final(html, id_contenedor){
	campoContenedor = document.getElementById(id_contenedor);
	if (campoContenedor){
		campoContenedor.insertAdjacentHTML("beforeend", html);
	}
}

function agregar_elemento_inicio(html, id_contenedor){
	campoContenedor = document.getElementById(id_contenedor);
	if (campoContenedor){
		campoContenedor.insertAdjacentHTML("beforebegin", html);
		
	}
}
function agregar_elemento_despues_de(html, id_elemento) {
    let elementoReferencia = document.getElementById(id_elemento);
    if (elementoReferencia) {
        // ingresa como siguiente
        elementoReferencia.insertAdjacentHTML("afterend", html);
    }
}

function agregar_elemento_antes_de(html, id_elemento) {
    let elementoReferencia = document.getElementById(id_elemento);
    if (elementoReferencia) {
        // ingresa como anterior
        elementoReferencia.insertAdjacentHTML("beforebegin", html);
    }
}

function eliminar_elementos_de(class_elementos_a_eliminar, id_contenedor) {
    let contenedor = document.getElementById(id_contenedor);
    if (contenedor) {
        // Buscamos todos los elementos con esa clase SOLO dentro del contenedor
        let elementos = contenedor.querySelectorAll("." + class_elementos_a_eliminar);
        
        elementos.forEach(elemento => {
            elemento.remove(); // Borra cada uno del DOM
        });
    }
}

function eliminar_elementos_global(clase) {
    document.querySelectorAll("." + clase).forEach(el => el.remove());
}

