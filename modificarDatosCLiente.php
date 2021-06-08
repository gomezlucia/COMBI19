<?php
    include "BD.php";// conectar y seleccionar la base de datos
    $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    include "menu.php";
?>
  <html>
  <head>
    <title>Modificar datos</title>
    <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
  </head>
  <body>
  <?php

 try {
             $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada 
$consulta="SELECT nombre, apellido, DNI, contraseña, mail FROM usuarios WHERE id_usuario='$id'";
$resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
    $usuarioCliente=mysqli_fetch_array ($resultado); 
    $nombre=$usuarioCliente['nombre'];
    $apellido=$usuarioCliente['apellido'];
    $DNI=$usuarioCliente['DNI'];
    $contraseña=$usuarioCliente['contraseña'];
    $email=$usuarioCliente['mail'];
    ?>
   <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>                       
       <hr>     
     </header>
     <center>
    <form action="validarDatosCliente.php" method="post">
     <h1>Modificar datos personales </h1>   
        <input type="text" name="nombre" size=50 placeholder=" Nombre nuevo" value="<?php echo $nombre;?>"><br><br>    
        <input type="text" name="apellido" size=50 placeholder="Apellido nuevo" value="<?php echo $apellido;?>"><br><br>       
       <input type="text" name="DNI" size=50 placeholder=" D.N.I nuevo" value="<?php echo $DNI;?>"><br><br>     
        <input type="password" name="contraseña" size=50 placeholder="Contraseña nueva"value="<?php echo $contraseña;?>"><br><br>
        <input type="password" name="contraseña2" size=50 placeholder="Confirmar contraseña"value="<?php echo $contraseña;?>"><br><br>
        <input type="text" name="email" size=50 placeholder=" email nuevo"value="<?php echo $email;?>"><br><br>
        <input type="hidden"name="id" value="<?php echo $id;?>">       
       <br><br>
        <input type="submit" value="Guardar">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='verPerfilDeUsuario.php'"> 
    </form>
    </center>    
</body>
  <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage(); 
                 echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
     }?>
</html>
