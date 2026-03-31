// const formulario = document.getElementById("id_fomr_registro");//aun no cargo la pagina, mejorable con ajax
function borrar (){
	formulario = document.getElementById("id_formulario_registro_operacion");
	Validacion.limpiar_erorres();
	formulario.reset();
}

function cancelar (){
	borrar();
	ir_gestionAdministrador();
}


function validar_datos (){

	let titulo_publicacion = document.getElementById("id_titulo_publicacion");
	let error_titulo_publicacion = document.getElementById("error_titulo_publicacion");

	let precio = document.getElementById("id_precio");
	let error_precio = document.getElementById("error_precio");
	
	let plazo = document.getElementById("id_plazo");
	let error_plazo = document.getElementById("error_plazo");
	
	let descripcion_inmueble = document.getElementById("id_descripcion_inmueble");
	let error_descripcion_inmueble = document.getElementById("error_descripcion_inmueble");
	
	let direccion = document.getElementById("id_direccion");
	let error_direccion_inmueble = document.getElementById("error_direccion_inmueble");

	
	let coordenadas_longitud = document.getElementById("id_coordenadas_longitud");
	let coordenadas_latitud = document.getElementById("id_coordenadas_latitud");
	let error_coordenadas_inmueble = document.getElementById("error_coordenadas_inmueble");
	
	
	let valido_formulario = true;

	
	if (!Validacion.realizar_validacion(Validacion.texto, titulo_publicacion, error_titulo_publicacion)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.numero, precio, error_precio)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.numero, plazo, error_plazo)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.texto, descripcion_inmueble, error_descripcion_inmueble)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.texto, direccion, error_direccion_inmueble)) {
		valido_formulario = false;
	}
	if (!Validacion.realizar_validacion(Validacion.coordenada, coordenadas_longitud, error_coordenadas_inmueble)) {
		valido_formulario = false;
	}
    if (!Validacion.realizar_validacion(Validacion.coordenada, coordenadas_latitud, error_coordenadas_inmueble)) {
		valido_formulario = false;
	}

	
	return valido_formulario;
}







function enviar_formulario (){
	Validacion.limpiar_erorres();
	formulario = document.getElementById("id_formulario_registro_operacion");
	// console.log(formulario);
	
	if (validar_datos()){
		// alert("el Usuario se valido exitosamente");
		formulario.submit();
	}
}
