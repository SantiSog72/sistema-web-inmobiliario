
class ventana_basica{
	
	constructor(nombre_ventana, ancho, alto){
		this.new_window = window.open ("", nombre_ventana, "width = "+ancho+", height= "+alto+", status = yes, resizable=yes, menubar=no");
		this.cabeza_ventana = new_window.document.createElement("head");
		
		this.cabecera = new_window.document.createElement("header");
		this.titulo_cabecera = new_window.document.createElement("h1");		
		
		this.cuerpo_ventana = new_window.document.createElement("body");
		this.seccion = new_window.document.createElement("section");
		this.articulo = new_window.document.createElement("article");
		
		this.cabecera.appendChild(titulo_cabecera);
		this.cabeza_ventana.appendChild(cabecera);
		
		this.seccion.appendChild(articulo);
		this.cuerpo_ventana.appendChild(seccion);
		
		this.new_window.appendChild(cabeza_ventana);
		this.new_window.appendChild(cuerpo_ventana);
		
	}
	
	get_titulo (){
		return this.titulo_cabecera;
	}
	
	get_body (){
		return this.cuerpo_ventana;
	}
	
	get_head (){
		return this.cabeza_ventana;
	}
	
	get_section(){
		return this.seccion;
	}
	
	get_article(){
		return this.articulo;
	}
	
	
	
}
