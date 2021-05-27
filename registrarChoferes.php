<?php
 include "BD.php";// conectar y seleccionar la base de datos
 $link = conectar();
 include "validarLogin.php";
 $usuarioAdmin= new usuario();
 $usuarioAdmin -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
 $usuarioAdmin ->id($id);
?>
<html>
  <head>
    <title>Registro de Choferes</title>
  </head>
  <body>
	   <a href="home.php" >Volver al home </a>
    <form action="registrarse.php" method="post">
      <?php  	$usuarioAdmin -> iniciada($nombreUsuario);
      $nombre="";
      $usuario="";
       $apellido="";

       $contra="";
       $clave="";
       $mail="";
      $legajo="";
   if (isset($_GET['error']) ){
       $nombre= $_SESSION['nombre_formulario'];
         $apellido=$_SESSION['apellido_formulario'];

                 $legajo=$_SESSION['legajo_formulario'];
               $usuario=	$_SESSION['nombre_usuario_formulario'] ;
               $contra=	$_SESSION['contra_formulario'];
               $mail=	$_SESSION['mail_formulario'] ;
       }  ?>
     <h1> Registrar chofer </h1>
				<input type="text" name="nombre" size=50 placeholder=" Nombre" value="<?php echo "$nombre"?>" required=""> <br><br>
				<input type="text" name="apellido" size=50 placeholder=" Apellido" value="<?php echo "$apellido"?>" required=""> <br><br>
				<input type="text" name="nombre_usuario" size=50 placeholder=" Nombre de usuario" value="<?php echo "$usuario"?>" required=""> <br><br>
        <input type="email" name="mail" size=50 placeholder=" Email" value="<?php echo "$mail"?>" required=""> <br><br>
        <input type="text" name="legajo" size=50 placeholder=" Legajo" value="<?php echo "$legajo"?>" required=""> <br><br>
				<input type="password" name="contraseña" size=50 placeholder=" Contraseña" value="<?php echo "$nombre"?>" required=""> <br><br>
        <input type="password" name="clave1" size=50   minlength= "8 " placeholder=" Confirmar Contraseña" value="<?php echo "$contra"?>" required=""> <br><br>
	    <input type="hidden" name="tipo_usuario" value='chofer'> <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
        <?php if (isset ($_GET['error']) and (!$_GET['error'])) { ?>
               <input type="hidden" name="nombre" value="<?php echo "$nombre"?>" >
               <input type="hidden" name="apellido" value="<?php echo "$apellido"?>">
               <input type="hidden" name="legajo"  value="<?php echo "$legajo"?>">

               <input type="hidden" name="mail" required="" value="<?php echo "$mail"?>" >
               <input type="hidden" name="contra" value="<?php echo "$contra"?>">
               <input type="hidden" name="form" required="" value="segundo_form" >
             <input type="hidden" name="tipo_usuario" value='chofer'> <br><br>


       <?php } ?>
    </form>
  </body>
</html>
