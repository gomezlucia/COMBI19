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
    <title>Modificar datos del chofer</title>
     <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
  </head>
  <body>
  <?php

if(empty($_POST['id'])){
  $id_usuario=$_GET['id'];
  
}
else{
  $id_usuario=$_POST['id'];

}
$consulta="SELECT nombre, contraseña, legajo, mail FROM usuarios WHERE id_usuario='$id_usuario'";
    $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
    $usuarioChofer=mysqli_fetch_array ($resultado); 
    $nombre=$usuarioChofer['nombre'];
    $contraseña=$usuarioChofer['contraseña'];
    $legajo=$usuarioChofer['legajo'];
    $email=$usuarioChofer['mail'];
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
    <form action="validarDatosChofer.php" method="post">
     <h1>Modificar datos del chofer </h1>   
        <input type="text" name="nombre" size=50 placeholder=" Nombre nuevo" value="<?php echo $nombre;?>"><br><br>          
        <input type="password" name="contraseña" size=50 placeholder="Contraseña nueva"value="<?php echo $contraseña;?>"><br><br>
        <input type="password" name="contraseña2" size=50 placeholder="Confirmar contraseña"value="<?php echo $contraseña;?>"><br><br>
        <input type="text" name="legajo" size=50 placeholder=" Legajo nuevo"value="<?php echo $legajo;?>"><br><br>        
        <input type="text" name="email" size=50 placeholder=" email nuevo"value="<?php echo $email;?>"><br><br>
        <input type="hidden"name="id" value="<?php echo $id_usuario;?>">       
       <br><br>
        <input type="submit" value="Guardar">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='verListadoDeChoferes.php'"> 
    </form>
    </center>  
  </body>
</html>

