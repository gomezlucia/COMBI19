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
        $consulta= "SELECT SEC_TO_TIME(sum(time_to_sec(TIMEDIFF(v.fecha_hora_llegada, v.fecha_hora_salida)))) as horas,u.debaja, v.id_chofer,u.nombre, u.apellido, u.mail, u.legajo, u.id_usuario FROM viajes v inner join usuarios u on(v.id_chofer=u.id_usuario) WHERE(now()>=+v.fecha_hora_salida) GROUP BY v.id_chofer UNION SELECT 0 AS horas,u1.debaja, u1.id_usuario ,u1.nombre, u1.apellido, u1.mail, u1.legajo, u1.id_usuario FROM usuarios u1 WHERE(u1.tipo_usuario='chofer')and u1.id_usuario not in (SELECT u.id_usuario FROM viajes v inner join usuarios u on(v.id_chofer=u.id_usuario) WHERE(now()>=+v.fecha_hora_salida) GROUP BY v.id_chofer )";
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: 14 ' .mysqli_error($link));

        if ($resultado){
        	while (($valores = mysqli_fetch_array($resultado)) ){
        	 $nombre = $valores['nombre'];
             $apellido = $valores['apellido'];
             $mail = $valores['mail'];
             $legajo = $valores['legajo'];
             $horas_trabajadas = $valores['horas'];
             $debaja= $valores['debaja'];
             $id_chofer= $valores['id_chofer'];
              $id_usuario=$valores['id_usuario'];
             ?>
             	<div>
                    <hr>
             		<p>
             			<b>Nombre:</b> <?php echo $nombre;?><br>
             			<b>Apellido:</b> <?php echo $apellido;?><br>
                        <b>Mail:</b> <?php echo $mail;?><br>
                        <b>Legajo:</b> <?php echo $legajo;?><br>
                        <b>Horas trabajadas:</b> <?php
                        $horas=explode(":", $horas_trabajadas);
                        echo $horas[0];
                        if ($debaja == 0){
                      //    $tipo='checkbox';
                      ?><br>
                       <form action="modificarDatosChofer.php" method="post"> 
                           <input type="hidden"name="id" value="<?php echo $id_usuario;?>">
                           <input type="submit"  value ="Modificar Datos">
                        </form><br>
                        <form action="funcionEvaluarDebaja.php" method="post">
                      <input type="hidden" name="id_chofer" value="<?php echo $id_chofer; ?>"> </input>
                      <input type="hidden" name="tipo" value="chofer"> </input>
                      <input type="submit" value="Dar de baja"><br><br></input>

                      </form>

                      <?php
                    }
                    else{ ?>
                      <br>
                      <b >Chofer dado de baja</b> <br><br>
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
