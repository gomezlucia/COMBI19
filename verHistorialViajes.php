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
  
   <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
</head>
<body>
  <?php  try {
            $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     $fecha_hora_salida="";
     $fecha_hora_llegada="";
     $precio="";
     $calificado= false;
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
 <h1>Historial de Viajes</h1>
     <?php
     $consulta0= "SELECT id_viaje, id_cliente FROM viaje_calificacion where (id_cliente = '$id')";
     $resultado0= mysqli_query($link,$consulta0) or die ('Consulta  fallida: ' .mysqli_error($link));
     $consulta= "SELECT v.id_viaje, v.id_ruta, v.id_chofer, v.fecha_hora_salida, v.fecha_hora_llegada, c.total,c.servicios_adicionales, v.debaja , t.origen, t.destino, c.id_cliente, c.estado, u.nombre, u.apellido, u.id_usuario FROM viajes v NATURAL JOIN rutas t NATURAL JOIN usuarios u NATURAL JOIN clientes_viajes c  WHERE (id_cliente='$id') and (id_chofer=id_usuario)" ;
     $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
  //   $consulta2=" SELECT nom_chofer , ape_chofer , id_usuario FROM usuarios WHERE (id_usuario = '$valores['id_chofer']')"
    // $resultado2= mysqli_query($link,$consulta2) or die ('Consulta fallida: ' .mysqli_error($link));
    if ($resultado){

          while (($valores = mysqli_fetch_array($resultado)) ){
            $consulta0= "SELECT id_viaje, id_cliente FROM viaje_calificacion where (id_cliente = '$id')";
            $resultado0= mysqli_query($link,$consulta0) or die ('Consulta fallida: ' .mysqli_error($link));
          //  var_dump($valores0);
          if ($resultado0){
            while (($valores0 = mysqli_fetch_array($resultado0)) ){
            //  var_dump($valores0);
              if (($valores0['id_viaje'] == $valores['id_viaje'])){
                $calificado = true;

              }
            }
             $destino = $valores['destino'];
           	 $fecha_hora_salida = $valores['fecha_hora_salida'];
             $fecha_hora_llegada = $valores['fecha_hora_llegada'];
             $precio = $valores['total'];
             $origen = $valores['origen'];
             $id_viaje = $valores['id_viaje'] ;
             $debaja = $valores['debaja'];
             $estado = $valores['estado'];
             $nombre = $valores['nombre'];
             $apellido = $valores['apellido'];
             $servicios_adicionales=$valores['servicios_adicionales'];

//             echo $origen, '   -   ', $destino;
             ?>
               <hr>
               	<h2><?php echo $origen, '-', $destino ;?></h2>
             		<p>
             			<b>Fecha y hora de salida:</b> <?php echo $fecha_hora_salida;?><br>
                  <b>Fecha y hora de llegada:</b> <?php echo $fecha_hora_llegada;?><br>
             			<b>Precio:</b> <?php echo $precio;?><br>
            <?php if (!empty($servicios_adicionales)) { ?>
                     <b>Servicios adicionales:</b><br> <?php  
                     $ads=explode('/',$servicios_adicionales);  
                     foreach ($ads as $value) { 
                       echo $value."<br>";  
                     }?>
  <?php            }     ?>
             			<b>Estado:</b> <?php echo $estado;?><br>
                  <b>Nombre del chofer:</b> <?php echo $nombre, '   ', $apellido ;?><br>

                <?php if ($estado == 'finalizado'){
                  if ($calificado<>true){ // LA CALIFICACION ES UNICA
                //    $tipo='checkbox';
                ?><br>
                <form action="calificarViaje.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>"> </input>
                <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"> </input>
                <input type="submit" value="Calificar viaje"><br><br></input>

                </form>
                <?php
              }
              else{ ?>
                <br>
                <b>Este viaje ya fue calificado <br><br>
                  <form action="eliminarCalificacion.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $id; ?>"> </input>
                  <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"> </input>
                  <input type="submit" value="Eliminar calificación"><br><br></input>

                  </form>

              <?php  } $calificado= false; }
            else{
              if ($estado == 'pendiente'){?>
                <form action="cancelarPasaje.php" method="post">
                    <input type="submit" name="cancelar" value="Cancelar pasaje"></input>
                    <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                    <input type="hidden" name="pagina" value="verHistorialViajes.php"></input>
                </form>
          <?php    }
            } } }?>
             		</p>
              <?php
 ?>

             <?php
        if(mysqli_num_rows($resultado)==0){
            ?>
                 <p> <b>Aun no ha realizado ningun viaje con nosotros!</b></p>
            <?php

            }
       }

        ?>
      <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                       $mensaje=$e->getMessage();
                       echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                        //redirige a la pagina inicioSesion y muestra una mensaje de error
           }?>
</center>
</body>
</html>


