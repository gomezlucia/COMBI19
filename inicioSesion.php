<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
	include "validarLogin.php";
	$usuario= new usuario(); //se crea la clase usuario
	$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (parametro por referencia), sirve por si escribe la url para ir a inicio de sesion pero ya tiene una sesion iniciada, como el valor tiene un nombre de usuario correcto va a entrar a la parte del catch (noIniciada va a tirar una excepcion)
?>
<!DOCTYPE html>
<html>
<head>
	<title>COMBI-19</title>
</head>
<body>
	 <?php try {
		     $usuario -> noIniciada($nombreUsuario);/*si no tiene una sesion iniciada y es su primer intento de completar el formulario
             pone en vacio las variables*/
		     $nombre='';
		     $contraseña='';
		     if (isset($_GET['mensaje'])){ /* si tuvo algun error al completar el formulario la variable GET va a tener el mensaje, no va a estar vacia, por eso entra al if. Seteo las variables para que en el formulario muestre los datos incorrectos que habia escrito para que los modifique*/
			     $nombre=$_SESSION['nombre_login'];
			     $contraseña=$_SESSION['cont_login'];
		     }
	?>
         <center>
			<form action="iniciarsesion.php" name="iniciarsesion" method="post" >
				 <h2> Inciar Sesi&oacuten </h2>       
				     <input type="text" name="nombre" size=30 id="nombre" value="<?php echo $nombre ?>" placeholder="Nombre Usuario" ><br><br></p>  
				     <input type="password" name="cont" size=30  id="cont"	value="<?php echo $contraseña ?>" minlength="8" placeholder="Contraseña" ><br><br>
				     <input type="submit" value="Iniciar Sesion" ><br><br>
				 <a href="" >Registrarse como nuevo usuario </a>
			</form>
			<br>
			<!--en los dos campos se va a mostrar, la primera vez vacios, y cuando se equivoque, los datos erroneos-->
	 	
	 <?php if (isset($_GET['mensaje'])){ //si ingreso datos incorrectos abajo del boton inicar sesion se van a mostrar los errores (las excepcines (que estan en validarLogin.php) guardadas en la variable GET)
	         echo ($_GET['mensaje'] . "<br>");
			 echo ("Por favor intente nuevamente");	
	 } ?>
	 </center>		
	 </body>
	 <?php } catch (Exception $e){  //si ya tenia una sesion iniciada y quizo entrar a la pag inicioSesion lo va a llevar a la pag principal
			    header("Location: /home.php");
	  } ?> 			
</html>
