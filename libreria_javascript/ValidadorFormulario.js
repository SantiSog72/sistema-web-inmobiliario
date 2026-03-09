

class ValidadorFormulario {
	constructor(formulario) {
		this.formulario = formulario;
		this.validaciones = [];
	}
	
	// funciones predeterminadas: opciones (listas), sin_valor(campos individuales)
	agregarValidacion(idCampo, idError, funcionValidacion) {
		// polimorfismo, parametros variables (opcionales)
		if (!funcionValidacion){
			let es_lista = Array.isArray(idCampo)||(idCampo instanceof NodeList);
			funcionValidacion = (es_lista)?Validacion.opciones:Validacion.sin_valor;
		}
		this.validaciones.push({ idCampo, idError, funcionValidacion });
	}
	

	validar() {
		let esValido = true;
		this.limpiar_erorres();

		for (let {idCampo, idError, funcionValidacion } of this.validaciones) {
			//verificar si es un elemento o un id (checkbox, radio, select)
			let campo = "";
			// let campo = this.averiguarCampo(idCampo);
			
			if ((typeof idCampo) == "string"){
				campo = document.getElementById(idCampo);
			}else if (Array.isArray(idCampo)||(idCampo instanceof NodeList)){
				campo = idCampo;
			}else{
				console.log(idCampo+ "no es un tipo valido");
			}
			
			
			let error = document.getElementById(idError);

			if (!this.realizar_validacion(funcionValidacion, campo, error)) {
				esValido = false;
			}
		}

		return esValido;
	}
	
	
	averiguarCampo (idCampo){
	// pudiendo recibir en el campo el:
		// nombre (checkboxes, radio, etc)
		// id de un elemento
		// la lista de elemrntos
	}
	
	limpiar_erorres (){
		// let lista_errores_validacion = this.formulario.querySelectorAll(".error");
		let lista_errores_validacion = Array.from(document.getElementsByClassName("error"));
		
		//recorrido arreglo simple js
		lista_errores_validacion.forEach (e =>{
			e.textContent = "";
		})
		
	}

	
	mostrar_error (mensaje_error, error){
		error.textContent = mensaje_error;
	}
	
	realizar_validacion (funcionValidacion, campo, error){
		// console.log (campo);
		let validacion = funcionValidacion(campo);
		if (!validacion.valido){
			this.mostrar_error(validacion.error, error);
		}
		return validacion.valido;
	}
	
}
