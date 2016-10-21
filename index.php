<?php 

	//header("Location:instalacion.php");



	/*Incluimos el fichero de la clase Db*/
	//require 'clases/db.php';
	/*Incluimos el fichero de la clase Conf*/
	//require 'clases/conf.php';
	/*Creamos la instancia del objeto. Ya estamos conectados*/
	//$bd=Db::getInstance();


	/*

	$sql='SELECT * FROM sp_evento';

	$evento=$bd->ejecutar($sql);	

	*/

	/*
		Si GET['p']( definido en la URL pe: www.google.com.ar?p=estoes ) esta definido
		entonces cargamos la página que estamos pidiendo por GET.
		De lo contrario cargamos login por defecto.
	*/

	if (!empty($_GET['p'])) {
		
		include_once ''.$_GET['p'].'.php';

	}else{

		// Pagina para loguear
		include_once 'home.php';

	}

?>