<html>
  <head>
    <title>Registro de Usuarios</title>
  </head>
  <body>

    <form action="registrarse.php" method="post">
       <?php  	$nombre="";
       	session_start();
       	$apellido="";
       	$usuario="";
       	$contra="";
       	$clave="";
       	$mail="";
       	$fecha="";
       	
        $dni="";
    if (isset($_GET['error']) ){
        $nombre= $_SESSION['nombre_formulario'];
          $apellido=$_SESSION['apellido_formulario'];
          $fecha=$_SESSION['fecha_formulario'];
          				$dni=$_SESSION['dni_formulario'];
          			$usuario=	$_SESSION['nombre_usuario_formulario'] ;
          			$contra=	$_SESSION['contra_formulario'];
          			$mail=	$_SESSION['mail_formulario'] ;
        }  ?>

         <h1> Registrar usuario </h1>


				<input type="text" name="nombre" size=50 placeholder=" Nombre" value="<?php echo "$nombre"?>" required=""> <br><br>
				<input type="text" name="apellido" size=50 placeholder=" Apellido" value="<?php echo "$apellido"?>" required=""> <br><br>
				Fecha de nacimiento <input type="date" name="fecha_nacimiento" size=50 placeholder=" Fecha de nacimiento" value="<?php echo "$fecha"?>" required=""> <br><br>
				<input type="text" name="DNI" size=50 placeholder=" DNI sin puntos" value="<?php echo "$dni"?>" required=""> <br><br>
				<input type="email" name="mail" size=50 placeholder=" Email" value="<?php echo "$mail"?>" required=""> <br><br>
				<input type="text" name="nombre_usuario" size=50 placeholder=" Nombre de usuario" value="<?php echo "$usuario"?>" required=""> <br><br>
				<input type="password" name="contraseña" size=50 placeholder=" Contraseña" value="<?php echo "$contra"?>" required=""> <br><br>
        <input type="password" name="clave1" size=50   minlength= "8 " placeholder=" Confirmar Contraseña"> <br><br>
        <input type="hidden" name="tipo_usuario" value='cliente'> <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
 <?php if (isset ($_GET['error']) and (!$_GET['error'])) { ?>
        <input type="hidden" name="nombre" value="<?php echo "$nombre"?>" >
        <input type="hidden" name="apellido" value="<?php echo "$apellido"?>">
        <input type="hidden" name="fecha"  value="<?php echo "$fecha"?>">
        <input type="hidden" name="dni" value="<?php echo "$dni"?>">
        <input type="hidden" name="mail" required="" value="<?php echo "$mail"?>" >
        <input type="hidden" name="contra" value="<?php echo "$contra"?>">
        <input type="hidden" name="form" required="" value="segundo_form" >
	    <input type="hidden" name="tipo_usuario" value='cliente'> <br><br>


<?php } ?>
    </form>
  </body>
</html>
