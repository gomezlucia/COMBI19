<?php
 include "BD.php";// conectar y seleccionar la base de datos
 $link = conectar();
 include "validarLogin.php";
?>
<html>
  <head>
    <title>Registro de Usuarios</title>
  </head>
  <body>
	  <?php 
       $nombre="";
       $usuario="";
       $apellido="";
       $contra="";
       $clave="";
       $dni="";
       $fecha_nacimiento="";
       $mail="";
       if (isset($_GET['error'])){
         $nombre= $_SESSION['nombre_cliente'];
	 	 $apellido= $_SESSION['apellido_cliente'];
	 	 $usuario=$_SESSION['nombre_usuario_cliente'];
	 	 $mail=$_SESSION['mail_cliente'];
	 	 $contra=$_SESSION['contraseña_cliente'];
         $fecha_nacimiento=$_SESSION['fecha_nacimiento_c'];
         $dni=$_SESSION['DNI_c'];
       }?>
     <h1> Registrar usuario </h1>
    <form action="registrarse.php" method="post">
    	 <input type="text" name="nombre" size=50 required="" placeholder=" Nombre" value="<?php echo $nombre ?>"> <br><br>
		 <input type="text" name="apellido" size=50 required=""  placeholder=" Apellido" value="<?php echo $apellido ?>"> <br><br>
		 Fecha de nacimiento  <input type="date" required=""  name="fecha_nacimiento" size=50 placeholder=" Fecha de nacimiento" value="<?php echo $fecha_nacimiento ?>"> <br><br>
		 <input type="text" name="DNI" size=50 required=""  placeholder=" DNI sin puntos" value="<?php echo $dni ?>"> <br><br>
		 <input type="email" name="mail" size=50 required=""  placeholder=" Email" value="<?php echo $mail ?>"> <br><br>
		 <input type="text" name="nombre_usuario"  required="" size=50 placeholder=" Nombre de usuario" value="<?php echo $usuario ?>"> <br><br>
		 <input type="password" name="contraseña"  required="" size=50 placeholder=" Contraseña" value="<?php echo $contra ?>"> <br><br>
         <input type="password" name="clave1" size=50 required=""   minlength= "8 " placeholder=" Confirmar Contraseña" > <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
	     <input type="hidden" name="tipo_usuario" value='cliente'> <br><br>
    </form>
  </body>
</html>
