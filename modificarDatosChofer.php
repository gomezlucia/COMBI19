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

$id_usuario=$_POST['id'];
    ?>
    
    <form action="validarDatosChofer.php" method="post">
     <h1>Modificar datos del chofer </h1>   
        <input type="text" name="nombre" size=50 placeholder=" Nombre nuevo"> <br><br>          
        <input type="password" name="contraseña" size=50 placeholder="Contraseña nueva"> <br><br>
        <input type="password" name="contraseña2" size=50 placeholder="Confirmar contraseña"> <br><br>
        <input type="text" name="legajo" size=50 placeholder=" Legajo nuevo"> <br><br>          
        <input type="text" name="email" size=50 placeholder=" email nuevo"> <br><br>
        <input type="hidden"name="id" value="<?php echo $id_usuario;?>">       
       <br><br>
        <input type="submit" value="Guardar">
        <input type= "reset" value= "Borrar">
    </form>
  </body>
</html>