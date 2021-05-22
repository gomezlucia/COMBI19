      
 <?php
  include "BD.php";// conectar y seleccionar la base de datos
  $link = conectar();
  include "validarLogin.php";
  $usuario= new usuario();
  $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
  $usuario ->id($id);
?>
<!DOCTYPE html>
<html>
<head>
<title> CARGAR VIAJE</title>
</head>
<body>
 <?php  try {
           $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
    $origen="";
    $destino="";
    $fecha_hora_salida="";
    $fecha_hora_llegada="";
    $precio=""; 
  if (isset ($_GET['error']) ){
    $origen=$_SESSION['origen_formulario'];
    $destino=$_SESSION['destino_formulario'];
    $f_h_s=$_SESSION['fecha_hora_salida_formulario'];
    $f_h_l=$_SESSION['fecha_hora_llegada_formulario'];
    $precio=$_SESSION['precio_formulario'];
   }
?>
   <a href="home.php">Volver al home</a>
     <center>
     <form action="validarViaje.php" method="post">
     	<h1>Registro de viaje</h1>
  		<input type="text" name="origen" size=50 placeholder="Origen" value="<?php echo "$origen"?>" required=""> <br><br>
		 <input type="text" name="destino" size=50 placeholder="Destino" required=""value="<?php echo "$destino"?>"> <br>
		 <p>Fecha y hora de salida</p>
		 <input type="datetime-local" name="fecha_hora_salida" required="" value="<?php echo "$f_h_s"?>"> <br>
		 <p>Fecha y hora de llegada</p>
		 <input type="datetime-local" name="fecha_hora_llegada"required=""  value="<?php echo "$f_h_l"?>"> <br><br>
		 <input type="number" name="precio" size=50 placeholder="Precio del pasaje" required="" value="<?php echo "$precio"?>"  >  <br><br>
     <?php if ( ( isset ($_GET['error']) and $_GET['error'] ) or ( !isset ($_GET['error']) ) ){ ?>
          <input type="submit" value="Mostrar choferes y combis diponibles">
          <input type= "reset" value= "Borrar">
     <?php } ?>
     </form>

 <?php if (isset ($_GET['error']) and (!$_GET['error'])) { ?>
       
     <form  action="validarViaje.php" method="post">  
 <?php
     $fecha_hora_salida=strftime('%Y-%m-%d %H:%M:%S', strtotime($_SESSION['fecha_hora_salida_formulario']));
     $fecha_hora_llegada=strftime('%Y-%m-%d %H:%M:%S', strtotime($_SESSION['fecha_hora_llegada_formulario']));?>   
     <select name= 'combis' id="combis">
             <option value="0">Seleccione combi</option>
             <?php $consulta= "SELECT id_combi,patente,chasis,modelo FROM combis WHERE  debaja='0' and  id_combi not in(SELECT id_combi from viajes WHERE ('$fecha_hora_salida' BETWEEN fecha_hora_salida and fecha_hora_llegada) or ('$fecha_hora_llegada' BETWEEN fecha_hora_salida and fecha_hora_llegada))";
             $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option value="' . $valores["id_combi"] . '">' . $valores["patente"] ." ". $valores["chasis"]."  ". $valores["modelo"] .  '</option>';}?>
     </select> <br><br>
     <select name= 'choferes' id="choferes">
         <option value="0">Seleccione chofer</option>
         <?php 
         $consulta= "SELECT id_usuario,nombre,apellido FROM usuarios WHERE debaja='0' and tipo_usuario='chofer'and id_usuario not in (SELECT id_chofer from viajes WHERE  ('$fecha_hora_salida' BETWEEN fecha_hora_salida and fecha_hora_llegada) or ('$fecha_hora_llegada' BETWEEN fecha_hora_salida and fecha_hora_llegada))";
          $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
          while ($valores = mysqli_fetch_array($resultado)) {
           echo '<option value="' . $valores["id_usuario"] . '">' . $valores["nombre"] ." ". $valores["apellido"].'</option>';}?>
     </select><br><br>
     <p>Seleccione los adicionales que desea agregar al viaje:</p>
     <select name= 'servicios_adicionales[]'  multiple="multiple">
             <?php $consulta= "SELECT * FROM servicios_adicionales";
             $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option value="' . $valores["id_servicio_adicional"] . '">' . $valores["nombre_servicio"] .  '</option>';}?>
     </select> <br><br>
     <input type="hidden" name="origen" value="<?php echo "$origen"?>" > 
     <input type="hidden" name="destino" value="<?php echo "$destino"?>"> 
     <input type="hidden" name="fecha_hora_salida"  value="<?php echo "$fecha_hora_salida"?>"> 
     <input type="hidden" name="fecha_hora_llegada" value="<?php echo "$fecha_hora_llegada"?>">
     <input type="hidden" name="precio" required="" value="<?php echo "$precio"?>" >
     <input type="hidden" name="form" required="" value="segundo_form" >
     <input type="submit" value="Cargar viaje">
     <input type= "reset" value= "Borrar">   
     </form> 
 <?php } ?>
    
     

	</center>       
</body>
<?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage(); 
                 echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
     }?>
</html>
