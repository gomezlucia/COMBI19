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
 	<title>Comprar Pasaje</title>
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
         	 	 $numero_tarjeta=$_SESSION['tarjeta_ingresada'];
         	 }else{
         	     $id_viaje=$_POST['id_viaje'];
         	     $numero_tarjeta="";
         	 }

           $tieneTarjetas="SELECT t.numero_tarjeta FROM usuarios c INNER JOIN tarjetas_clientes tc ON (c.id_usuario=tc.id_cliente) INNER JOIN tarjetas t ON (tc.id_tarjeta= t.id_tarjeta) WHERE id_usuario='$id'";
           $resultadoTarjetas=mysqli_query($link,$tieneTarjetas) or  die ('Consulta tiieneTarjetas fallida: ' .mysqli_error());

         	 $viaje="SELECT  r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio FROM viajes v  NATURAL JOIN rutas r  WHERE id_viaje='$id_viaje'";
         	 $resultadoViaje=mysqli_query($link,$viaje) or  die ('Consulta viaje fallida: ' .mysqli_error()); 
         	 $datosViaje = mysqli_fetch_array($resultadoViaje);

         	 $adicionales="SELECT vs.id_servicio_adicional, vs.id_viaje,s.nombre_servicio,s.precio FROM servicios_adicionales s NATURAL JOIN viajes_servicios_adicionales vs WHERE vs.id_viaje='$id_viaje'";
         	 $resultado=mysqli_query($link,$adicionales) or  die ('Consulta noTieneCovid fallida: ' .mysqli_error()); 

           if(isset($_POST['volverA'])){
               $volverA=$_POST['volverA'];
           }else{
               $volverA=$_GET['p'];
           }?>
               <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>                       
       <hr>     
     </header>
         	 <center>
         	 	 <p> <b>Origen:</b> <?php echo $datosViaje['origen'];?><br>
         		     <b>Destino:</b> <?php echo $datosViaje['destino'];?><br>
             	     <b>Fecha y hora de salida:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($datosViaje['fecha_hora_salida']));?><br>
                   <b>Fecha y hora de llegada:</b> <?php echo date("d/m/Y  H:i:s", strtotime($datosViaje['fecha_hora_llegada']));?><br>
                   <b>Precio:</b> <?php echo '$' . $datosViaje['precio'];?><br>
                   <form action="validarPago.php" method="post">  
          <?php       if(mysqli_num_rows($resultado)!=0){?>
                         <b>Seleccionar adicionales:<b><br>
                 <?php   while ($valores = mysqli_fetch_array($resultado)) {
                     	       echo '<input type="checkbox" name="chkl[]" value="' . $valores["id_servicio_adicional"] . '">' . $valores["nombre_servicio"] ." $". $valores["precio"].   '</input><br><br>';
                     	   }
                       }
                       if(mysqli_num_rows($resultadoTarjetas)!=0){?>
                          <b>Mis Tarjetas:</b><br>
                         <select name= "tarjetas" id="tarjetas">
                           <option value="0">Seleccionar Tarjeta:</option>
             <?php         while ($tarjetas = mysqli_fetch_array($resultadoTarjetas)) {
                             echo '<option value="' . $tarjetas["numero_tarjeta"] . '">' . $tarjetas["numero_tarjeta"] . '</option>';
                           } ?>
                           </select> <br><br>
  <?php                    echo "O ingrese una nueva tarjeta"."<br><br>";
                       }?>
                        
                     <b>Numero de tarjeta: </b><input type="number" name="numero_tarjeta"  maxlength="16" value="<?php echo $numero_tarjeta?>"></input><br><br>
                     <b>Clave de seguridad: </b><input type="password" name="clave"  maxlength="4"  value=""></input><br><br>
                          <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                          <input type="submit" name="Submit" value="Pagar pasaje"> 
                          <input type="hidden" name="precio" value="<?php echo  $datosViaje['precio']; ?>">
                          <input type="hidden" name="volverA" value="<?php echo  $volverA;?>">
                          <input type="reset" name="cancelar" value="Cancelar"></input><br><br>
              
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


          
