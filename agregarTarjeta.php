<?php
    include "BD.php";// conectar y seleccionar la base de datos
    $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
?>
  <html>
  <head>
    <title>Agregar tarjeta</title>
  </head>
  <body>
 <?php $fcha = date("Y-m");?>
  <a href="home.php" >Volver al home </a>     
    <form action="validarDatosTarjeta.php" method="post">
     <h1>Nueva tarjeta </h1>   
        <input type="text" name="numero" size=50 placeholder="Numero de tarjeta" ><br><br>          
        <input type="text" name="seguridad" size=50 placeholder="Codigo de seguridad "><br><br>
        <input type="month" name="fecha" id="fecha" class="form-control" value="<?php echo $fcha ?>"><br><br>
        <input type="hidden"name="id" value="<?php echo $id;?>">      
        <input type="submit" value="Guardar">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='verPerfilDeUsuario.php'"> 
    </form>


  </body>
</html>

