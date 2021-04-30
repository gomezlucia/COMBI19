<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
    include "validarLogin.php";
	$usuario= new usuario();
	$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
?>
<html>
	<head>
		<title> COMBI-19</title>
     </head>
     <?php try {
    	     $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?> 
	 <body>	
				<h1>Bienvenid@  <?php echo " ".$nombreUsuario;  ?></h1>
				<a href="COMBI19/cerrarSesion.php"> Cerrar Sesion </a>  	
	 </body>
	 <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
           	     $mensaje=$e->getMessage(); 
                 header ("Location: /inicioSesion.php?mensaje=$mensaje");	//redirige a la pagina inicioSesion con el mensaje de error por url
     }?>
</html>
