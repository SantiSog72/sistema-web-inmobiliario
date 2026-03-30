
class Ventana_emergente{
	
	
    constructor(nombre_ventana, ancho, alto) {
        this.new_window = window.open("", nombre_ventana, `width=${ancho},height=${alto},resizable=yes`);
        
        const doc = this.new_window.document;

        this.titulo_cabecera = doc.createElement("h1");
        this.cabecera = doc.createElement("header");
        this.seccion = doc.createElement("section");
        this.articulo = doc.createElement("article");

        this.cabecera.appendChild(this.titulo_cabecera);
        this.seccion.appendChild(this.articulo);

        doc.body.appendChild(this.cabecera);
        doc.body.appendChild(this.seccion);
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
