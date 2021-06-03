<?php
	session_start();
	session_unset(); //destruir todas las variables de sesion(arreglo)
	session_destroy(); //destruir la sesion(varibales de la sesion actual)
	header("Location: /COMBI19-main/home.php");
?>
