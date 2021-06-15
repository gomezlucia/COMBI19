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
    <script type="text/javascript">
      function eliminarCalificacion(frm){
    var opcion = confirm('¿Esta seguro que desea eliminar su calificación?');
        if(opcion == true){
            frm.submit();
        }else{
            return false;
        }
}

    </script>
     <script type="text/javascript" src="confirmarCancelarPasaje.js"></script>
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
     $consulta= "SELECT v.id_viaje, v.id_ruta, v.id_chofer, v.id_combi, v.fecha_hora_salida, v.fecha_hora_llegada, c.total,c.servicios_adicionales ,c.id_cliente, c.estado, c.tarjeta_utilizada  FROM viajes v  NATURAL JOIN clientes_viajes c  WHERE (id_cliente='$id')" ;
     $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
     //echo 'consulta1';
  //   $consulta2=" SELECT nom_chofer , ape_chofer , id_usuario FROM usuarios WHERE (id_usuario = '$valores['id_chofer']')"
    // $resultado2= mysqli_query($link,$consulta2) or die ('Consulta fallida: ' .mysqli_error($link));
    if ($resultado){

          while (($valores = mysqli_fetch_array($resultado)) ){
            $consulta0= "SELECT id_viaje, id_cliente FROM viaje_calificacion where (id_cliente = '$id')";
            $resultado0= mysqli_query($link,$consulta0) or die ('Consulta fallida: ' .mysqli_error($link));
            //echo 'consulta0';
          //  var_dump($valores0);
            $id_combi= $valores['id_combi'];
            $id_chofer= $valores['id_chofer'];
          //  echo $id_chofer;
            $id_ruta=$valores['id_ruta'];
        //    echo 'asignacion0';
            $consulta12 = "SELECT origen, destino, id_ruta FROM rutas where (id_ruta = '$id_ruta')";
            $result12= mysqli_query($link,$consulta12) or die ('Consulta fallida 12: ' .mysqli_error($link));
            $valores12= mysqli_fetch_array($result12);
          //  echo 'consulta12';
            $consulta11="SELECT nombre, apellido, id_usuario FROM usuarios where (id_usuario = '$id_chofer')";
            $result11= mysqli_query($link,$consulta11) or die ('Consulta fallida 11: ' .mysqli_error($link));
            $valores11=mysqli_fetch_array($result11);
          //  echo 'consulta11';
            $consult10= "SELECT patente, id_combi FROM combis where (id_combi = '$id_combi')";
            $result10 =  mysqli_query($link,$consult10) or die ('Consulta fallida 10: ' .mysqli_error($link));
            $valores10 = mysqli_fetch_array($result10);
          //  echo 'consulta10';
          if ($resultado0){
            while (($valores0 = mysqli_fetch_array($resultado0)) ){
            //  var_dump($valores0);
              if (($valores0['id_viaje'] == $valores['id_viaje'])){
                $calificado = true;

              }
            }
             $destino = $valores12['destino'];
             $fecha_hora_salida = $valores['fecha_hora_salida'];
             $fecha_hora_llegada = $valores['fecha_hora_llegada'];
             $precio = $valores['total'];
             $origen = $valores12['origen'];
             $id_viaje = $valores['id_viaje'] ;
      //       $debaja = $valores['debaja'];
             $estado = $valores['estado'];
             $nombre = $valores11['nombre'];
             $apellido = $valores11['apellido'];
             $servicios_adicionales=$valores['servicios_adicionales'];
             $patente = $valores10['patente'];
             $numero_tarjeta= $valores['tarjeta_utilizada'];
             $primeros = substr($numero_tarjeta, 0,2);
             $ultimos =substr($numero_tarjeta, -4);
             $cantidad=(strlen($numero_tarjeta))-strlen($primeros)-strlen($ultimos);
//             echo $origen, '   -   ', $destino;
            //  echo 'asignaciones';
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
                  <b>Estado:</b> <?php if($estado=='cancelado'){
                     echo "Viaje cancelado por la empresa (devolucion del 100% del monto)";
                  }elseif($estado=='devuelto parcial'){
                     echo "Pasaje cancelado (devolucion del 50% del monto)";
                  }elseif($estado=='devuelto total'){
                     echo "Pasaje cancelado (devolucion del 100% del monto)";
                  }else{
                     echo $estado;
                  }?><br>
                  <b>Nombre del chofer:</b> <?php echo $nombre, '   ', $apellido ;?><br>
                  <b>Patente:</b> <?php echo $patente;?><br>
                  <b>Numero de tarjeta:</b> <?php echo $primeros.(str_repeat('*',$cantidad)).$ultimos;?> <br>
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
                  <input type="submit" value="Eliminar calificación" class="btn_buscar"  onclick="return eliminarCalificacion(this.form)" ><br><br></input>


                  </form>

              <?php  } $calificado= false; }
            else{
              if ($estado == 'pendiente'){?>
                <form action="cancelarPasaje.php" method="post">
                    <input type="submit" name="cancelar" value="Cancelar pasaje" onclick="return SubmitForm(this.form)"></input>
                    <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                    <input type="hidden" name="pagina" value="verHistorialViajes.php"></input>
                    <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
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
