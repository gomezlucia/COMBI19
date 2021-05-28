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
	<h1>Combis</h1>
</head>
<body>
  <?php  try {
            $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     $fecha_hora_salida="";
     $fecha_hora_llegada="";
     $precio="";

 ?>

 <a href="home.php" >Volver al home </a>
     <?php
     $consulta= "SELECT v.id_viaje, v.id_ruta, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.debaja , t.origen, t.destino, c.id_cliente FROM viajes v NATURAL JOIN rutas t NATURAL JOIN clientes_viajes c WHERE (id_cliente='$id')" ;
     $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
          while (($valores = mysqli_fetch_array($resultado)) ){

        	 $fecha_hora_salida = $valores['fecha_hora_salida'];
             $fecha_hora_llegada = $valores['fecha_hora_llegada'];
             $precio = $valores['precio'];
             $origen = $valores['origen'];
             $id_viaje = $valores['id_viaje'] ;
             $debaja = $valores['debaja'];
             if ($debaja <> 0){
               $estado= "cancelado";
             }else{

             if ($fecha_hora_llegada >= now()){
               $estado= "en curso";
               if ($fecha_hora_salida >= now()){
                 $estado="pendiente";
               }
             }
             else{
               $estado= "finalizado";
             }

             }

             ?>
             <div>

             	<h2><?php echo $origen ,'-', $destino ?></h2>
             	<div>
             		<p>
             			<b>Fecha y hora de salida:</b> <?php echo $fecha_hora_salida;?><br>
                  <b>Fecha y hora de llegada:</b> <?php echo $fecha_hora_llegada;?><br>
             			<b>Precio:</b> <?php echo $precio;?><br>
             			<b>Estado:</b> <?php echo $estado;?><br>

                <?php  if ($debaja == 0){ // LA CALIFICACION ES UNICA
                //    $tipo='checkbox';
                ?><br>
                  <form action="funcionEvaluarDebaja.php" method="post">
                <input type="hidden" name="id_combi" value="<?php echo $id_combi; ?>"> </input>
                <input type="hidden" name="tipo" value="combi"> </input>
                <input type="submit" value="Calificar viaje"><br><br></input>

                </form>
                <?php
              }
              else{ ?>
                <br>
                <b >Este viaje ya fue calificado <br><br>
              <?php } }?>

             		</p>
              <?php
 ?>
           	</div>

             </div>
             <?php



        if(mysqli_num_rows($resultado)==0){
            ?>
            <div>
                 <p>
                  <center> <b>Aun no ha realizado ningun viaje con nosotros!</b>
            </div>
            <?php

            }
       }

        ?>
      <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                       $mensaje=$e->getMessage();
                       echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                        //redirige a la pagina inicioSesion y muestra una mensaje de error
           }?>
</html>
