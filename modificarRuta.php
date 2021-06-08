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
    <title>Modificar ruta</title>
     <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
  </head>
  <body>
  <?php
     if (isset($_POST['ruta'])) {
       $id_ruta=$_POST['ruta'];   
       $tieneViajesAsignados="SELECT r.id_ruta FROM rutas r INNER JOIN viajes v ON('$id_ruta'=v.id_ruta) ";
       $resultado=mysqli_query($link,$tieneViajesAsignados) or  die ('Consulta fallida: ' .mysqli_error());
       if(mysqli_num_rows($resultado)!=0) {
          echo "<script > alert('Las rutas con viajes asignados no pueden ser modificadas');window.location='verListadoDeRutas.php'</script>";
       }
     }else{
       $id_ruta=$_GET['id'];
     }
     $consulta="SELECT origen,destino FROM rutas WHERE id_ruta='$id_ruta'";
     $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
     $ruta=mysqli_fetch_array ($resultado); 
     $origen=$ruta['origen'];
     $destino=$ruta['destino'];
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
    <form action="validarRuta.php" method="post">
     <h1>Modificar datos del chofer </h1>   
        <input type="text" name="origen" size=50 placeholder=" Origen"  required="" value="<?php echo $origen;?>"><br><br>          
        <input type="text" name="destino" size=50 placeholder=" Destino"  required="" value="<?php echo $destino;?>"><br><br>        
        <input type="hidden"name="id" value="<?php echo $id_ruta;?>">
        <input type="submit" value="Guardar">
        <input type= "reset" value= "Borrar">
    </form>
    </center>   
  </body>
</html>

