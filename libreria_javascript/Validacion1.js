// validacion de formulario base

class Validacion {
	
	//en validacion mejor SOLO HACER VALIDACION  no mostrar los mensajes?
	
	
	
	//la lista debe venir con un nombre
	static opciones (lista_opciones){
		let hay_elegido = false;
		
		lista_opciones.forEach(opcion => {
			hay_elegido = hay_elegido || opcion.checked;
		})
		
		if (!hay_elegido){
			return {valido: false, error: "seleccione una opcion"};		
		}
		return {valido: true};
	}
	
	static sin_valor (campo){
		if (campo.value == ""){
			return {valido: false, error: "El "+campo.name+" es obligatorio"};
		}		
		return {valido: true};
	}
	
	static texto (campo_texto){
		let sin_valor = Validacion.sin_valor(campo_texto);
		
		if (!sin_valor.valido){
			return {valido: false, error: sin_valor.error};
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
	
	static fecha_pasada (campo_fecha){
		let fecha = new Date(campo_fecha.value);
		let fecha_hoy = new Date();
		
		//fecha invalida
		if (isNaN(fecha.getTime())){
			return {valido : false, error: "ingrese una fecha"};
		}
		//fecha futura
		if (fecha > fecha_hoy){
			return {valido: false, error: "La "+campo_fecha.name+ " es mayor a la actual"};
		}
		
		return {valido: true};		
	}
	
	static fecha_futura (campo_fecha){
		let fecha = new Date(campo_fecha.value);
		let fecha_hoy = new Date();
		
		//fecha invalida
		if (isNaN(fecha.getTime())){
			return {valido : false, error: "ingrese una fecha"};
		}
		//fecha futura
		if (fecha < fecha_hoy){
			return {valido: false, error: "La "+campo_fecha.name+ " es menor a la actual"};
		}
		
		return {valido: true};		
	}
	
	static numero (campo_numerico){
		let sin_valor = Validacion.sin_valor(campo_numerico);
		
		if (!sin_valor.valido){
			return {valido: false, error: sin_valor.error};
		}
		
		if (isNaN(campo_numerico.value)){
			return {valido : false, error: "El valor debe ser numerico"};
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
	
	
	static contiene_numero (campo_texto){	
	
		let sin_valor = Validacion.sin_valor(campo_texto);
		
		if (!sin_valor.valido){
			return {valido: false, error: sin_valor.error};
		}
		// expresion para saber si tiene un valor del 0-9
		if (!/\d/.test(campo_texto.value)){
			return {valido: false, error: "Debe contener al menos un número"};
		}
		return {valido: true};
	}
	
	static contiene_minuscula (campo_texto){
		let texto = campo_texto.value;
		for (let i=0; i< texto.length; i++){
			if (texto [i].match(/[a-z]/)){
				return {valido: true};
			}
		}
		return {valido: false, error: "Debe contener al menos una minuscula"};
	}
	
	static contiene_mayuscula (campo_texto){
		let texto = campo_texto.value;
		for (let i=0; i< texto.length; i++){
			if (texto [i].match(/[A-Z]/)){
				return {valido: true};
			}
		}
		return {valido: false, error: "Debe contener al menos una mayuscula"};
	}


	
	static clave (contraseña){
	
		let contiene_mayuscula = Validacion.contiene_mayuscula(contraseña);
		let contiene_minuscula = Validacion.contiene_minuscula(contraseña);
		let contiene_numero = Validacion.contiene_numero(contraseña);
		let sin_valor = Validacion.sin_valor(contraseña);
		
		if (!sin_valor.valido){
			return {valido: false, error: sin_valor.error};
		}
		if (!contiene_minuscula.valido){
			return {valido : false, error: contiene_minuscula.error};						
		}
		if (!contiene_mayuscula.valido){
			return {valido : false, error: contiene_mayuscula.error};						
		}
		if (!contiene_numero.valido){
			return {valido : false, error: contiene_numero.error};						
		}
		if (contraseña.value.length < 6){
			return {valido : false, error: "la clave debe tener minimo 6 caracteres"};				
		}
		return {valido: true};
	}
	
	static dni (campo_dni){
		let numero = Validacion.numero(campo_dni);
		
		if (!numero.valido){
			return {valido: false, error: numero.error};
		}
		if (campo_dni.value.length != 8){
			return {valido: false, error: "longitud del dni incorrecta"};
		}
		return {valido: true};
	}
	
	static email (campo_email){
		let sin_valor = Validacion.sin_valor(campo_email);
		
		if (!sin_valor.valido){
			return {valido: false, error: sin_valor.error};
		}
		if (!campo_email.value.includes("@")){
			return {valido : false, error: "no es una direccion valida: falta @"};			
		}
		return {valido: true};
	}
	
	
	
}