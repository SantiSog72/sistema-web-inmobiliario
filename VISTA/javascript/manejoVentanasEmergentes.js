function expandir_foto (img){
    const ventana = new Ventana_emergente("ventana_foto", 800, 800);

    const articulo = ventana.get_article();
    articulo.style = "position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); display:flex; justify-content:center; align-items:center; z-index:1000;";
    articulo.onclick = () => modal.remove(); // Cerrar al hacer clic fuera

    let imagenGrande = document.createElement("img");
    imagenGrande.setAttribute("src", `${img.src}`);
    imagenGrande.setAttribute("style", "max-width:90%; max-height:90%; border:5px solid white;");

    articulo.appendChild(imagenGrande);
}