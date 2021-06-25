<?php

     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     include "menu.php"; 
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Agregar adicionales al pasaje</title>
    <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
 </head>
  <?php try {
             $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?> 
 <body>
    <?php 
         $noTieneCovid="SELECT c.tiene_covid FROM usuarios c  Where id_usuario='$id'";
         $resultado=mysqli_query($link,$noTieneCovid) or  die ('Consulta noTieneCovid fallida: ' .mysqli_error());
         $cliente=mysqli_fetch_array($resultado);
         if($cliente['tiene_covid']!=0) {
             echo "<script > alert('No puede comprar este viaje ya que ha declarado síntomas compatibles con COVID-19 dentro de los 15 días anteriores a la fecha de salida');window.location='home.php'</script>";
         }else{
         	 if (!isset($_POST['id_viaje'])) {
         	 	 $id_viaje=$_SESSION['viaje'];
         	 }else{
         	     $id_viaje=$_POST['id_viaje'];
         	    
         	 }

      #     $tieneTarjetas="SELECT t.numero_tarjeta FROM usuarios c INNER JOIN tarjetas_clientes tc ON (c.id_usuario=tc.id_cliente) INNER JOIN tarjetas t ON (tc.id_tarjeta= t.id_tarjeta) WHERE id_usuario='$id'";
       #    $resultadoTarjetas=mysqli_query($link,$tieneTarjetas) or  die ('Consulta tiieneTarjetas fallida: ' .mysqli_error());

         	 $viaje="SELECT  r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio FROM viajes v  NATURAL JOIN rutas r  WHERE id_viaje='$id_viaje'";
         	 $resultadoViaje=mysqli_query($link,$viaje) or  die ('Consulta viaje fallida: ' .mysqli_error()); 
         	 $datosViaje = mysqli_fetch_array($resultadoViaje);

         	 $adicionales="SELECT vs.id_servicio_adicional, vs.id_viaje,s.nombre_servicio,s.precio FROM servicios_adicionales s NATURAL JOIN viajes_servicios_adicionales vs WHERE vs.id_viaje='$id_viaje'";
         	 $resultado=mysqli_query($link,$adicionales) or  die ('Consulta noTieneCovid fallida: ' .mysqli_error()); 

           #if(isset($_POST['volverA'])){
            #   $volverA=$_POST['volverA'];
           #}else{
            #   $volverA=$_GET['p'];
           #}?>
               <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); 
                $precio=$datosViaje['precio'];?>                       
       <hr>     
     </header>
         	 <center>
         	 	 <p> <b>Origen:</b> <?php echo $datosViaje['origen'];?><br>
         		     <b>Destino:</b> <?php echo $datosViaje['destino'];?><br>
             	     <b>Fecha y hora de salida:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($datosViaje['fecha_hora_salida']));?><br>
                   <b>Fecha y hora de llegada:</b> <?php echo date("d/m/Y  H:i:s", strtotime($datosViaje['fecha_hora_llegada']));?><br>
                   <b>Precio:</b> <?php echo '$' . $datosViaje['precio'];?><br>
                   <?php       if(mysqli_num_rows($resultado)!=0){?>
                   <form action="agregarAdicionalesAlPasaje.php" method="post">  
                         <b>Seleccionar adicionales:</b><br>
                 <?php   while ($valores = mysqli_fetch_array($resultado)) {
                     	       echo '<input type="checkbox" name="chkl[]" value="' . $valores["id_servicio_adicional"] . '">' . $valores["nombre_servicio"] ." $". $valores["precio"].   '</input><br><br>';
                     	   }
                       

?>    
          </b>
          <input type="hidden" name="id_viaje" value="<?php echo $_POST['id_viaje']; ?>"></input>
          <input type="submit" name="Actualizar" value="Actualizar total">
      </form>

      <?php
      $adicionales_seleccionados=""; 
      if (!empty($_POST['chkl'])) {
             $checkbox1 = $_POST['chkl'];
             $precioAdicional=0;
             foreach($checkbox1 as $valor) { 
                 $consulta="SELECT nombre_servicio,precio FROM servicios_adicionales WHERE id_servicio_adicional='$valor'";  
                 $resultado=mysqli_query($link,$consulta)  or die ('Consulta fallida: ' .mysqli_error());
                 $valores = mysqli_fetch_array($resultado);
                 $adicionales_seleccionados=$valores['nombre_servicio'].",".$valores['precio']."/".$adicionales_seleccionados;
                 $precioAdicional=$precioAdicional+$valores['precio'];
           } 
         $precio=$precio+$precioAdicional;

       ?>
       <br>
       Servicios adicionales seleccionados:<?php echo str_replace ( "," , " $" , $adicionales_seleccionados ); ?>
       <br>
     <?php } }
     else{?>
      <br>
        <b><i><h3>No hay servicios adicionales para este viaje</h3> </i></b><br><br>

     <?php $adicionales_seleccionados=""; } ?>
       <b>Total a abonar: </b>$<?php echo $precio ?><br><br>
       <form action="comprarPasaje.php" method="post"> 
        <input type="hidden" name="adicionales_seleccionados" value="<?php echo $adicionales_seleccionados; ?>"></input> 
        <input type="hidden" name="total" value="<?php echo $precio; ?>"></input>
        <input type="hidden" name="id_viaje" value="<?php echo $_POST['id_viaje']; ?>"></input>
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='home.php'"> 
        <input type="submit" name="continuar" value="Continuar">

      </form>
         	 </center>
 <?php  } 
    
    ?>
 
 </body>
 <?php   } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage(); 
                 echo "<script> alert('Por favor, inicie sesión en COMBI-19 o regístrese como nuevo usuario para realizar la compra');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
         }?>
</html>