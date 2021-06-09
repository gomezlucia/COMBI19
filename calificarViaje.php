<?php
 include "BD.php";// conectar y seleccionar la base de datos
 $link = conectar();
 include "validarLogin.php";
 $usuario= new usuario();
 $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
 $usuario ->id($id);
include "menu.php";
?>
<!DOCTYPE html>
<html>
<head>
      <title>Calificar Viaje</title>
   <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
</head>
<body>
  <?php  try {
            $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
 ?>
 <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>                       
       <hr>     
     </header>
     <CENTER>
    <h1>Calificar Viaje</h1>
 <form action="validarCalificacion.php" method="post">
  <p class="clasificacion">
    <input id="radio1" type="radio" name="estrella" value="1"><!--
    --><label for="radio1">★</label><!--
    --><input id="radio2" type="radio" name="estrella" value="2"><!--
    --><label for="radio2">★</label><!--
    --><input id="radio3" type="radio" name="estrella" value="3"><!--
    --><label for="radio3">★</label><!--
    --><input id="radio4" type="radio" name="estrella" value="4"><!--
    --><label for="radio4">★</label><!--
    --><input id="radio5" type="radio" name="estrella" value="5"><!--
    --><label for="radio5">★</label>
    <br><br>


    <h1>¡Dejanos un comentario sobre el viaje!</h1>
       <textarea name="comentario"  minlength="50" placeholder="Escribir Comentario" cols="50" rows="10" ></textarea>
      <input type="hidden" name="id_viaje" value="<?php echo $_POST['id_viaje']; ?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <br><br>
      <input type="submit" value="Guardar">
      <input type= "reset" value= "Cancelar">

  </p>
</form>
</CENTER>

<?php  //echo "<script> alert('$_POST['estrella']');window.location='/COMBI19-main/calificarViaje.php'</script>";
 } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage();
                 echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
     }
     ?>
</html>
