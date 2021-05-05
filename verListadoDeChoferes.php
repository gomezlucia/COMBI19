<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
?>
<!DOCTYPE html>
<html>
<head>
	<h1>Choferes</h1>
</head>
<body>
     <?php
        $consulta= "SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(v.fecha_hora_llegada, v.fecha_hora_salida)))) as horas, v.id_chofer,u.nombre, u.apellido FROM viajes v inner join usuarios u on(v.id_chofer=u.id_usuario) WHERE(now()>=+v.fecha_hora_salida) GROUP BY v.id_chofer" ;
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
        	while (($valores = mysqli_fetch_array($resultado)) ){
        	 $nombre = $valores['nombre'];
             $apellido = $valores['apellido'];
             $horas_trabajadas = $valores['horas'];
             ?>
             	<div>
                    <hr>
             		<p>
             			<b>Nombre:</b> <?php echo $nombre;?><br>
             			<b>Apellido:</b> <?php echo $apellido;?><br>
                        <b>Horas trabajadas:</b> <?php  
                        $horas=explode(":", $horas_trabajadas);
                        echo $horas[0];
                        ?><br>
             		</p>
             	</div>

             <?php
           
        }
        if(mysqli_num_rows($resultado)==0){
            ?>
            <div>
                 <p>
                  <center> <b>Aun no hay choferes cargados en la pagina</b> 
            </div>
            <?php

    }
       }     
        
        ?>