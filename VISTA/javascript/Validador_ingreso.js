// const formulario = document.getElementById("id_fomr_registro");//aun no cargo la pagina
function borrar (){
	formulario = document.getElementById("id_fomr_ingreso");
	Validacion.limpiar_erorres();
	formulario.reset();
}

function cancelar (){
	borrar();
	ir_index();
}


function validar_datos (){

	let dni = document.getElementById("id_dni");
	let error_dni = document.getElementById("error_dni");

	let contraseña = document.getElementById("id_contraseña");
	let error_contraseña = document.getElementById("error_contraseña");

	let valido_formulario = true;

	if (!Validacion.realizar_validacion(Validacion.contrasenaBasica, contraseña, error_contraseña)) {
		valido_formulario = false;
	}

	if (!Validacion.realizar_validacion(Validacion.dni, dni, error_dni)) {
		valido_formulario = false;
	}

	
	return valido_formulario;
}







function enviar_formulario (){
	Validacion.limpiar_erorres();
	formulario = document.getElementById("id_fomr_ingreso");
	// console.log(formulario);
	
	if (validar_datos()){
		console.log("el Usuario se valido exitosamente");
		formulario.submit();
	}
}
