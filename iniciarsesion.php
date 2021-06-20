<?php
	include "BD.php";
	$link = conectar();
	include "validarLogin.php";
	$usuario= new usuario();
	try {
		$usuario -> validar_usuario($link);
		if ($_SESSION['tipo_usuario']=='chofer') {
		 	 header("Location: /COMBI19-main/proximoViaje.php");
		 }else{
		     header("Location: /COMBI19-main/home.php"); //si los datos del usuario son correctos lo dirige a la pag principal
		 }
	} catch (Exception $e){
		$mensaje= $e->getMessage(); //obtiene todas las excepciones que se pudieon haber producido y las guarda en una variable
		header("Location: /COMBI19-main/inicioSesion.php?mensaje=$mensaje");//redirige a la pag inicioSesion con el/los mensajes pasador en la url (metodo GET)
	}
?>

