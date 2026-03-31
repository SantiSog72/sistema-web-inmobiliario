// Usamos la variable global definida en el PHP. 
const raiz = window.BASE_URL || "/sistema_web_inmobiliario/";

function ir_index(){
    window.location.href = `${raiz}index.php`;  
}

function ir_singIn(){
    window.location.href = `${raiz}VISTA/singIn.php`;   
}

function ir_singUp(){
    window.location.href = `${raiz}VISTA/singUp.php`;   
}

function ir_AltaOperacion(){
    window.location.href = `${raiz}VISTA/Alta_operacion.php`;   
}

function ir_gestionAdministrador(){
    window.location.href = `${raiz}VISTA/gestion_administrador.php`;    
}