<?php
    include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
?>
<!DOCTYPE html>
<html>
<head>
    <style type="text/css">       
            img{
             display:block;
             margin:auto;
             height: 180px;
             padding: 5px;
            }
        </style>
</head>
     <?php try {
             $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?> 
<body>
     <a href="home.php" > 
            <img src="logo_is.png" class="div_icono">     
        </a>
      <h1>Viajes disponibles</h1>
     <?php
         $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
         $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
         $usuario=mysqli_fetch_array ($resultado); 
         $tipo_usuario=$usuario['tipo_usuario'];
         $consulta= "SELECT v.id_viaje,v.origen, v.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t WHERE (now()<=fecha_hora_salida)and (debaja=0)" ;
         $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
         if ($resultado){
        	while (($valores = mysqli_fetch_array($resultado)) ){
        	     $origen = $valores['origen'];
                 $destino = $valores['destino'];
                 $fecha_hora_salida = $valores['fecha_hora_salida'];
                 $fecha_hora_llegada = $valores['fecha_hora_llegada'] ;
                 $precio = $valores['precio'] ;
                 $cupo=$valores['cupo'];
                 $asientos=$valores['asientos'];
                 $id_viaje=$valores['id_viaje'];?>
                 <hr>
                 <p> <b>Origen:</b> <?php echo $origen;?><br>
         		     <b>Destino:</b> <?php echo $destino;?><br>
             	     <b>Fecha y hora de salida:</b> <?php echo $fecha_hora_salida;?><br>
                     <b>Fecha y hora de llegada:</b> <?php echo $fecha_hora_llegada;?><br>
                     <b>Precio:</b> <?php echo '$' . $precio;?><br>
                     <b>Cupo:</b> <?php 
                     if($cupo<$asientos){
                         echo $cupo;
                     }else{
                         echo $cupo ?> <i>(está lleno)</i>
                     <?php }?><br>
                 </p>
                 <?php 
                 if( ($cupo==0) and ($tipo_usuario=='administrador') ){ ?>
                     <form action="modificarDatosDeViajes.php" method="post">
                         <input type="submit" name="modificar" value="Modificar Viaje"></input>
                         <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                     </form> 
             <?php } 
             }
             if(mysqli_num_rows($resultado)==0){ ?>
                 <center> <b>No hay viajes disponibles por el momento</b> </center>
<?php        }
         }     ?>
</body>
 <?php   } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage(); 
                 echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
         }?>
</html>
