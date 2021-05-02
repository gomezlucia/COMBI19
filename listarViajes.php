<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
?>
<!DOCTYPE html>
<html>
<head>
	<h1>Viajes disponibles</h1>
</head>
<body>
     <?php
        $consulta= "SELECT v.origen, v.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t WHERE (now()<=fecha_hora_salida)" ;
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
             ?>
             <div>
             	<hr>
             	<div>
             		<p>
             			<b>Origen:</b> <?php echo $origen;?><br>
             			<b>Destino:</b> <?php echo $destino;?><br>
             			<b>Fecha y hora de salida:</b> <?php echo $fecha_hora_salida;?><br>
                        <b>Fecha y hora de llegada:</b> <?php echo $fecha_hora_llegada;?><br>
                        <b>Precio:</b> <?php echo '$' . $precio;?><br>
                        <b>Cupo:</b> <?php 
                        if($cupo<$asientos){
                        echo $cupo;
                        }
                        else{
                            echo $cupo ?> <i>(está lleno)</i>
                        <?php }?><br>
             		</p>
             	</div>

             </div>
             <?php
           
        }
        if(mysqli_num_rows($resultado)==0){
            ?>
            <div>
                 <p>
                  <center> <b>No hay viajes disponibles por el momento</b> 
            </div>
            <?php


    }
       }     
        
        ?>
