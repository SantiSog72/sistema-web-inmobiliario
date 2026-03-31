// validacion de formulario base

class Validacion {
	
	//en validacion mejor SOLO HACER VALIDACION  no mostrar los mensajes?
	
	static limpiar_erorres (){
		let lista_errores_validacion = Array.from(document.getElementsByClassName("error"));
		
		//recorrido arreglo simple js
		for (let e of lista_errores_validacion) {
			e.textContent = "";
		}
	}

	
	static mostrar_error (mensaje_error, campo_error){
		campo_error.textContent = mensaje_error;
	}
	
	static realizar_validacion (funcion_validacion, campo_elemento, campo_error){
		let validacion = funcion_validacion(campo_elemento);
		if (!validacion.valido){
			Validacion.mostrar_error(validacion.error, campo_error);
		}
		return validacion.valido;
	}
	
	
	static texto (campo_texto){
		//sin texto
		if (campo_texto.value == ""){
			return {valido: false, error: "El "+campo_texto.name+" es obligatorio"};
		}		
		return {valido: true};
	}
	
	
	//la lista debe venir con un nombre
	static opciones (lista_opciones){
	
		let hay_elegido = false;
		for (let i = 0; i< lista_opciones.length; i++){
			hay_elegido = hay_elegido || lista_opciones[i].checked;
		}
		
		if (!hay_elegido){
			return {valido: false, error: "seleccione "+lista_opciones.name};		
		}
		return {valido: true};
	}
	
	

	static fecha_nacimiento (campo_fecha){
		let fecha = new Date(campo_fecha.value);
		let fecha_hoy = new Date();
		
		//fecha invalida
		if (isNaN(fecha.getTime())){
			return {valido : false, error: "ingrese una fecha"};
		}
		//fecha futura
		if (fecha > fecha_hoy){
			return {valido: false, error: "La "+campo_fecha.name+ " mayor a la actual"};
		}
		//no es mayor de edad
		let edad_aproximada = fecha_hoy.getFullYear() - fecha.getFullYear(); 
		let mayoria_edad = 18;
		if (edad_aproximada < mayoria_edad){
			return {valido: false, error: "No se cumple la mayoria de edad"};
		}
		return {valido: true};		
	}
	
	static fecha (campo_fecha){
		let fecha = new Date(campo_fecha.value);
		let fecha_hoy = new Date();
		
		//fecha invalida
		if (isNaN(fecha.getTime())){
			return {valido : false, error: "ingrese una fecha"};
		}
		//fecha futura
		if (fecha > fecha_hoy){
			return {valido: false, error: "La "+campo_fecha.name+ " mayor a la actual"};
		}
		
		return {valido: true};		
	}
	
	static numero (campo_numerico){
		if (isNaN(campo_numerico.value)){
			return {valido : false, error: "ingrese el numero"};
		}

		return {valido: true};		
	}
	
	static numero_celular (campo_numero_celular){
		let validacion_numerica = Validacion.numero(campo_numero_celular);
		if (!validacion_numerica.valido){
			return {valido : false, error: validacion_numerica.error};		
		}
		
		if (Number (campo_numero_celular.value) < 0){
			return {valido : false, error: "Numero invalido, el numero debe ser positivo"};			
		}
		return {valido: true};		
	}
	
	static contiene_numero(campo) {
	if (!/\d/.test(campo.value)) {
		return {valido: false, error: "Debe contener al menos un número"};
	}
	return {valido: true};
	}
	
	
	static contiene_minuscula (campo_texto){	
		let texto = campo_texto.value;
		for (let i=0; i< texto.length; i++){
			if (texto [i] === texto[i].toLowerCase()){
				return {valido: true};
			}
		}
		return {valido: false, error: "Debe contener al menos una minuscula"};
	}
	
	static contiene_mayuscula (campo_texto){	
		let texto = campo_texto.value;
		for (let i=0; i< texto.length; i++){
			if (texto [i] === texto[i].toUpperCase()){
				return {valido: true};
			}
		}
		return {valido: false, error: "Debe contener al menos una mayuscula"};
	}

	static sin_numero (campo_texto){	
		return !/\d/.test(campo_texto.value);
	}
	
	static sin_minuscula (campo_texto){	
		let texto = campo_texto.value;
		for (let i=0; i< texto.length; i++){
			if (texto [i] === texto[i].toLowerCase()){
				return false;
			}
		}
		return true;
	}
	
	static sin_mayuscula (campo_texto){	
		let texto = campo_texto.value;
		for (let i=0; i< texto.length; i++){
			if (texto [i] === texto[i].toUpperCase()){
				return false;
			}
		}
		return true;
	}

	static contrasenaBasica(contraseña){
		if (contraseña.value == ""){
			return {valido : false, error: "deve ingresar clave"};		
		}
		if (contraseña.value.length < 8){
			return {valido : false, error: "la clave debe tener minimo 8 caracteres"};				
		}
		return {valido: true};
	}

	static dni(dni){
		if (dni.value == ""){
			return {valido : false, error: "deve ingresar el dni"};		
		}
		if (dni.value.length < 8){
			return {valido : false, error: "El dni tiene 8 caracteres"};				
		}
		return {valido: true};
	}



	
	static clave (contraseña){
	
		if (Validacion.contiene_numero(contraseña).valido);
		if (contraseña.value == ""){
			return {valido : false, error: "deve ingresar clave"};		
		}
		if (contraseña.value.length < 6){
			return {valido : false, error: "la clave debe tener minimo 6 caracteres"};				
		}
		if (Validacion.sin_minuscula(contraseña)){
			return {valido : false, error: "la clave debe tener alguna minuscula"};						
		}
		if (Validacion.sin_mayuscula(contraseña)){
			return {valido : false, error: "la clave debe tener alguna mayuscula"};						
		}
		if (Validacion.sin_numero(contraseña)){
			return {valido : false, error: "la clave debe tener algun numero"};						
		}
		return {valido: true};
	}
	

	
	static email (campo_email){
		if (campo_email.value == ""){
			return {valido : false, error: "debe ingresar un email"};			
		}
		if (!campo_email.value.includes("@")){
			return {valido : false, error: "no es una direccion valida: falta @"};			
		}
		return {valido: true};
	}

	static coordenada(campo_coordenada) {
		// Expresión regular: 
		// ^-?            : Puede empezar con un signo menos opcional
		// \d{1,3}        : De 1 a 3 dígitos enteros
		// (\.\d{1,7})?   : Un punto seguido de 1 a 7 dígitos decimales (opcional)
		// $              : Fin de la cadena
		const regexCoordenada = /^-?\d{1,3}(\.\d{1,7})?$/;

		if (campo_coordenada.value === "") {
			return { valido: false, error: "La coordenada es obligatoria" };
		}

		if (!regexCoordenada.test(campo_coordenada.value)) {
			return { 
				valido: false, 
				error: "Formato inválido. Use hasta 3 enteros y 7 decimales (ej: -123.4567890)" 
			};
		}
		return { valido: true };
	}
	// cada validacion:
		// onblur:			
			// realizar validacion (true/false)
			// mostrar mensaje
			// onchange:			
				// quitar mensaje
		// enviar formulario:
			// realizar validacion (true/false)
			// mostrar mensaje
		

	// static unico_checkbox (lista_checkbox){
		// for (let i = 0; i< lista_checkbox.length; i++){
			// if (checkbox.checked) {			
				// if (repetido){
					// return false;
				// }
				// unico = true;			
			// } 
		// }
		// return true;
	// }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// static checkbox_obligatorio (checkbox){	
		// if (!checkbox.checked){
			// alert ("debe seleccionar el checkbox");
		// }
	// }
		
	
	// valores_nulos = new Array ();
	
	// static validacion_checkbox_mutuamente_excluyente (lista_checkbox){
	
		// if (!min_uno(lista_checkbox)){
			// alert ("se necesita marcar uno");
		// }else if (!unico_checkbox(lista_checkbox)){		
			// alert ("solo puede haber un tipo de obra marcado");
			// limpiar_checkbox (lista_checkbox);
		// }
	// }
	
	
	// static select (texto){
		
	// }
	
	
	// static radio (radio){
		
	// }
	
	
	// valor_invalido (){
		
	// }
	
	// valor_tipo_requerido (campo, tipo_requerido){
		// tipo_correcto = campo_completo(campo);
		// if (typeof(campo.value) != tipo_requerido){
			// alert ("El valor del campo: "+campo.name+", no es de tipo "+tipo_requerido);
			// tipo_correcto = false;
		// }else{
			// tipo_correcto = tipo_correcto && true;		
		// }
		
		// return tipo_correcto;
	// }
	
	// campo_completo (campo){
		// let completo = false
		// if (campo.value == null || campo.value == "" || campo.value == -1){			
			// alert ("el campo "+campo.name+" no puede estar vacio");		
		// }else{
			// completo = true;
		// }
			// return completo;
	// }


	
	
	
	
	// function limpiar_checkbox (lista_checkbox){ //metodo privado
		// lista_checkbox.forEach ((checkbox)=>{ //foreach es ininterrumpido
			// checkbox.checked = false;
		// });
	// }
	
	
	
	// function min_uno (lista_checkbox){
		// for (let i = 0; i< lista_checkbox.length; i++){
			// if (lista_checkbox[i].checked){
				// return true;
			// }		
		// }	
	// }
	
}