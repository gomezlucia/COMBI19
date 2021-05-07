<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();

?>
<!DOCTYPE html>
<html>
<head>
	<h1>Combis</h1>
</head>
<body>
     <?php
        $consulta= "SELECT id_combi, patente, chasis, modelo, nombre_tipo FROM combis NATURAL JOIN tipos_combi WHERE debaja = 0" ;#debaja = 0 es falso
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
        	while (($valores = mysqli_fetch_array($resultado)) ){
        	 $patente = $valores['patente'];
             $chasis = $valores['chasis'];
             $modelo = $valores['modelo'];
             $id_combi = $valores['id_combi'];
             $tipo_combi = $valores['nombre_tipo'] ;
             ?>
             <div>
             	<h2><?php echo $patente ?></h2>
             	<div>
             		<p>
             			<b>Numero de chasis:</b> <?php echo $chasis;?><br>
             			<b>Modelo:</b> <?php echo $modelo;?><br>
             			<b>Tipo de combi:</b> <?php echo $tipo_combi;?><br>
                  <label for="myCheck">Dar de baja combi    </label>
                  <input type="checkbox" id="myCheck" onclick="evaluarDebaja($id_combi)">
                  <?php echo $mensaje; ?>

             		</p>
                <?php
                function evaluarDebaja($id_combi){
                  $mensaje= "La combi fue dada de baja exitosamente" ;
                  $consulta= "SELECT v.origen, v.id_combi, v.fecha_hora_salida, c.debaja FROM viajes v NATURAL JOIN combis c WHERE (now()<=fecha_hora_salida)" ;
                  $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
                  if ($resultado){
                  	while (($valores = mysqli_fetch_array($resultado)) ){
                       $id_combi_act = $valores['id_combi'];
                       if ($id_combi_act == $id_combi){
                          $mensaje= "Esta combi esta asignada a un viaje. Por favor, modifique o cancele el viaje antes de dar de baja la combi";
                       }
                     }
                     return $mensaje;
                   }
                 }

                 ?>


             	</div>

             </div>
             <?php

        }
        if(mysqli_num_rows($resultado)==0){
            ?>
            <div>
                 <p>
                  <center> <b>Aun no hay combis cargadas en la pagina</b>
            </div>
            <?php

    }
       }

        ?>
