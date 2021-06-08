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
    <title>Registro de ruta</title>
 <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
  </head>
  <body>
    <?php  try {
       $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
       $origen="";
       $destino="";
       if (isset ($_GET['error']) ){
         $origen=$_SESSION['origen_formulario'];
         $destino=$_SESSION['destino_formulario'];
       }
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
    <form action="registrarRuta.php" method="post">
     <h1> Registrar ruta </h1>   
				<input type="text" name="origen" size=50 placeholder=" Origen" required="" value="<?php echo $origen ?>"> <br><br>          
				<input type="text" name="destino" size=50 placeholder=" Destino" required="" value="<?php echo $destino ?>"> <br><br>      
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
    </form>
    </center>
  </body>
  <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage(); 
                 echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
     }?>
</html>
