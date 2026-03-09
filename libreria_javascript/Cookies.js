

function creo_cookie (nombreCookie, valor){
	let vigencia = 6000;
	document.cookie = nombreCookie+"="+valor+";max-age="+vigencia+";path=/;secure";		
}


function obtenerValor (nombreCookie){
	var posCookie = document.cookie.search(nombreCookie);
	let valorCookie="sin valor";
	if (posCookie != -1){
		let posIgual = document.cookie.indexOf("=", posCookie);
		let posPuntoComa = document.cookie.indexOf(";", posCookie);
			valorCookie = document.cookie.substring(posIgual+1, posPuntoComa);
			if (posPuntoComa== -1){//cookie final	
				valorCookie = document.cookie.substring(posIgual+1);
			}
	}else{
		console.log ("la cookie "+ nombreCookie+" no existe");
	}
	return valorCookie;
}


function chequeo_visita(){
	var nombreCookie = "visitas";
	var vigencia = 6000;
	
	var posCookie = document.cookie.search(nombreCookie);
	
	if (posCookie == -1){
		// no hay cookies guardadas, debo crear la primera (no se usa imnediatamente)
		document.cookie = nombreCookie+"= 1; max-age="+vigencia+"; path=/"; 		
		// path= / (para que se pueda usar en todo el siito, no solo en la pagina donde se creo)
	
	}else{
		// ya hay cookies guardadas (busca la posicion de un caracter de izq a der, empieza a buscar desde la posicion posCookie)
		var posIgual = document.cookie.indexOf ("=", posCookie);
		var contador = parseInt(document.cookie.substring(posIgual+1))+1; //suma al contador de visitas
		document.cookie = nombreCookie+"="+contador+"; max-age="+vigencia+"; path=/;secure"; 		
		
	}
}


function actualizar_ultimo_acceso(){
	let fecha_actual = new Date();
	let vigencia = 6000;
	let aux = fecha_actual.getDate()+"/"+fecha_actual.getMonth()+"/"+fecha_actual.getFullYear()+" "+fecha_actual.getHours()+":"+fecha_actual.getMinutes()+":"+fecha_actual.getSeconds();
	
	document.cookie = "fecha_acceso="+aux+"; max-age="+vigencia+"; path=/;secure";
}


function mostrarCookies (){	
	let cookies = document.cookie.split(";");//crea arreglo a partir de un string indicando la separacion
	
	if (cookies.length == -1){
		console.log ("no hay ninguna cookie");
	}else{
		console.log ("Cookies");
		cookies.forEach((cookie)=>{
			console.log(cookie);
		});
	}
}

function imprimirCookie(nombreCookie, id_lugar){
	let valor_cookie = obtenerValor(nombreCookie);	
	document.getElementById(id_lugar).textContent = valor_cookie;
}

function eliminar_cookie (nombreCookie){
	document.cookie = nombreCookie+"=; expires=Mon, 08 May 2023 23:59:59 GMT; path=/;secure";	
	
}

function vaciar_cookies (){
	let cookies = document.cookie.split(";");
	cookies.forEach((cookie)=>{
		let posIgual = cookie.indexOf("=");
		
		//trim elimina los espacios en blanco del inicio y del final
		let nombre = cookie.substring(0, posIgual).trim();
		if (existe_cookie(nombre)){
			eliminar_cookie(nombre);
		}
	});
}


function existe_cookie (nombreCookie){
	return (document.cookie.search(nombreCookie) != -1)
}

function mostrar_cookie (nombreCookie){
	let mensaje = existe_cookie(nombreCookie)?nombreCookie+": "+obtenerValor(nombreCookie):"la cookie \""+nombreCookie+"\", no existe" ;	
	console.log(mensaje);
}