// este es el ubicador_elemento.js

//limpia todo el contenedor o un elemento dentro de este
function limpiar_contenedor (id_contenedor, id_elemento){//polimorfismo en js
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

