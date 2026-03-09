let mensaje_error = "localStorage no es soportado por el navegador";

function imprimir_elemento (item, id_lugar){
	let aux = "";
	
	if (!localStorage != undefined){
		aux = "sin valor almacenado";
	}else{
		aux = localStorage.getItem (item)
	}
	document.getElementById(id_lugar).textContent = aux;	
}

function vaciar_local_storage (){
	if (typeof localStorage != "undefined"){
		localStorage.clear();
		console.log("se vacio el local storage");
	}else{
		console.log (mensaje_error);
	}
}


function guardar_item (clave, valor){
	if (typeof localStorage != undefined){
		localStorage.setItem(clave, valor);
	}else{
		console.log (mensaje_error);		
	}	
}

function eliminar_item (clave){
	if (typeof localStorage != undefined){
		localStorage.removeItem(clave);
	}else{
		console.log (mensaje_error);		
	}
}

function obtener_valor (clave){
	if (typeof localStorage != undefined){
		return localStorage.getItem(clave);
	}else{
		console.log (mensaje_error);		
	}
}

function hay_elementos (){
	return localStorage.length !=0;
}

function esta_item (clave){
	return (localStorage.getItem(clave) != null);
}

function guardar_objeto (clave, objeto){
	if (typeof localStorage != undefined){
		localStorage.setItem(clave, JSON.stringify(objeto));
	}else{
		console.log (mensaje_error);		
	}
}

function obtener_objeto (clave){
	if (typeof localStorage != undefined){
		let objeto = localStorage.getItem(clave);
		if (objeto){
			return JSON.parse(objeto);
		}
		return objeto;
	}else{
		console.log (mensaje_error);		
	}
}