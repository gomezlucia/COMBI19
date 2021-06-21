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
    <title>Modificar datos del servicio adicional</title>
     <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
  </head>
  <body>
  <?php
 #echo "aquii". $_GET['nombre_servicio'];
if(empty($_POST['id'])){
  $id_servicio_adicional=$_GET['id'];
  
}
else{
  $id_servicio_adicional=$_POST['id'];

}
$consulta= "SELECT s.nombre_servicio, s.precio, s.id_servicio_adicional FROM servicios_adicionales s where s.id_servicio_adicional='$id_servicio_adicional' " ;    
    $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
    $valores=mysqli_fetch_array($resultado);
    $nombre_servicio=$valores['nombre_servicio'];
    $precio=$valores['precio'];
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
    <form action="validarDatosAdicional.php" method="post">
     <h1>Modificar datos del servicio adicional </h1>   
        <input type="text" name="nombre_servicio" size=50 placeholder=" Nombre nuevo" value="<?php echo $nombre_servicio;?>"><br><br>          
        <input type="text" name="precio" size=50 placeholder=" Precio nuevo"value="<?php echo $precio;?>"><br><br>        
        <input type="hidden"name="id" value="<?php echo $id_servicio_adicional;?>">       
       <br><br>
        <input type="submit" value="Guardar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='verListadoDeAdicionales.php'"> 
    </form>
    </center>  
  </body>
</html>

