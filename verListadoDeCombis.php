
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
        $consulta= "SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(v.fecha_hora_llegada, v.fecha_hora_salida)))) as horas, v.id_chofer,u.nombre, u.apellido, u.mail, u.legajo FROM viajes v inner join usuarios u on(v.id_chofer=u.id_usuario) WHERE(now()>=+v.fecha_hora_salida) GROUP BY v.id_chofer UNION SELECT 0 AS horas, u1.id_usuario  ,u1.nombre, u1.apellido, u1.mail, u1.legajo FROM usuarios u1 WHERE(u1.tipo_usuario='chofer')and NOT EXISTS ( SELECT * from viajes v1 WHERE v1.id_chofer=u1.id_usuario)" ;
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: 14 ' .mysqli_error($link));

        if ($resultado){
        	while (($valores = mysqli_fetch_array($resultado)) ){
        	 $nombre = $valores['nombre'];
             $apellido = $valores['apellido'];
             $mail = $valores['mail'];
             $legajo = $valores['legajo'];
             $horas_trabajadas = $valores['horas'];
             $debaja= $valores['debaja'];
             ?>
             	<div>
                    <hr>
             		<p>
             			<b>Nombre:</b> <?php echo $nombre;?><br>
             			<b>Apellido:</b> <?php echo $apellido;?><br>
                        <b>Mail:</b> <?php echo $mail;?><br>
                        <b>Legajo:</b> <?php echo $legajo;?><br>
                        <b>DEBAJA:</b> <?php echo $debaja;?><br>
                        <b>Horas trabajadas:</b> <?php
                        $horas=explode(":", $horas_trabajadas);
                        echo $horas[0];
                        if ($debaja == 0){
                      //    $tipo='checkbox';
                      ?><br>
                      <input type="checkbox" >Dar de baja chofer<br><br>
                      <?php
                    }
                    else{ ?>
                      <br>
                      <b >Chofer dado de baja <br><br>
                    <?php } ?>


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
