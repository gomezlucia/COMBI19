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
     <?php try{  $usuarioAdmin -> iniciada($nombreUsuario);
       $nombre="";
       $usuario="";
       $apellido="";
       $contra="";
       $clave="";
       $mail="";
       $legajo="";
       if (isset($_GET['error'])){
         $nombre= $_SESSION['nombre_chofer'];
         $apellido=$_SESSION['apellido_chofer'];
         $usuario= $_SESSION['nombre_usuario_chofer'];
         $contra=$_SESSION['contraseña_chofer'];
         $mail= $_SESSION['mail_chofer'];
         $legajo=$_SESSION['legajo_chofer'];
       }?>
	   <a href="home.php" >Volver al home  </a>   
    <form action="registrarse.php" method="post">
     <h1> Registrar chofer </h1>
				<input type="text" name="nombre" required="" size=50 placeholder=" Nombre" value="<?php echo $nombre ?>"> <br><br>
				<input type="text" name="apellido" required=""  size=50 placeholder=" Apellido" value="<?php echo $apellido ?>"> <br><br>
				<input type="text" name="nombre_usuario" required=""  size=50 placeholder=" Nombre de usuario" value="<?php echo $usuario ?>"> <br><br>
        <input type="email" name="mail" size=50  required="" placeholder=" Email" value="<?php echo  $mail ?>"> <br><br>
        <input type="text" name="legajo" size=50  required="" placeholder=" Legajo" value="<?php echo $legajo  ?>"> <br><br>
				<input type="password" name="contraseña" required=""  size=50 placeholder=" Contraseña" value="<?php echo $contra  ?>"> <br><br>
        <input type="password" name="clave1" size=50 required=""   minlength= "8 " placeholder=" Confirmar Contraseña" > <br><br>
	    <input type="hidden" name="tipo_usuario" value='chofer'> <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
    </form>
  </body>
   <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage(); 
                 echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
     }?>
</html>
