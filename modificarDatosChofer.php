  <?php
  include "BD.php";// conectar y seleccionar la base de datos
  $link = conectar();
?>
  <html>
  <head>
    <title>Modificar datos del chofer</title>
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
    </form>
  </body>
</html>