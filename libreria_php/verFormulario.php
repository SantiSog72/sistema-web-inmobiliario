<?php
function mostrar_info_formulario (){
	echo "<h3>datos recibidos</h3>";
	echo "<pre>";

	switch ($_SERVER ["REQUEST_METHOD"]){
		case "POST":
			print_r($_POST);
			break;
		case "GET":
			print_r($_GET);	
			break;
		default: 
			echo "no hay formulario";
	}
	echo "</pre>";	
}
?>