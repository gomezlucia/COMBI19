<?php
	include "BD.php";
	$link = conectar();
	include "validarLogin.php";
	$usuario= new usuario();
	try {
		$usuario -> validar_usuario($link); 
		header("Location: /home.php"); //si los datos del usuario son correctos lo dirige a la pag principal
	} catch (Exception $e){
		$mensaje= $e->getMessage(); //obtiene todas las excepciones que se pudieon haber producido y las guarda en una variable
		header("Location: /inicioSesion.php?mensaje=$mensaje");//redirige a la pag inicioSesion con el/los mensajes pasador en la url (metodo GET)
	}
?>