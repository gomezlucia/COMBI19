
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
        $consulta= "SELECT id_combi, patente, chasis, modelo, nombre_tipo, debaja, asientos FROM combis NATURAL JOIN tipos_combi " ;#debaja = 0 es falso
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
          while (($valores = mysqli_fetch_array($resultado)) ){
        	 $patente = $valores['patente'];
             $chasis = $valores['chasis'];
             $modelo = $valores['modelo'];
             $id_combi = $valores['id_combi'];
             $tipo_combi = $valores['nombre_tipo'] ;
             $debaja = $valores['debaja'];
             $asientos=$valores['asientos'];
             ?>
             <div>
             	<h2><?php echo $patente ?></h2>
             	<div>
             		<p>
             			<b>Numero de chasis:</b> <?php echo $chasis;?><br>
             			<b>Modelo:</b> <?php echo $modelo;?><br>
             			<b>Tipo de combi:</b> <?php echo $tipo_combi;?><br>
                  <b>Cantidad de asientos:</b> <?php echo $asientos;?><br>
                <?php  if ($debaja == 0){
                //    $tipo='checkbox';
                ?><br>
                <input type="checkbox" onclick="llamarDebaja();">Dar de baja combi<br><br>
                <?php
              }
              else{ ?>
                <br>
                <b >Combi dada de baja <br><br>
              <?php }} ?>




             		</p>
                <?php

               function evaluarDebaja($id_combi){
                 $mensaje = 'La combi fue dada de baja exitosamente';
               //  echo="funcion";

                $consulta2= "SELECT id_combi FROM viajes WHERE (now()<=fecha_hora_salida) and id_combi ='$id_combi'" ;
               $result25= mysqli_query ($link, $consulta2) or die ('Consulta fallida 44' .mysqli_error());
               echo $mensaje;
            //       if (mysqli_num_rows($resultado)>0){
            //     if ($resultado){
            //      while (($valores = mysqli_fetch_array($resultado)) ){
              //        $id_combi_act = $valores['id_combi'];
              //        if ($id_combi_act == $id_combi){
              //           $mensaje= 'No se puede dar de baja las combis que tengan viajes asignados, por favor primero modifique los datos de esos viajes o cancele el viaje en caso de que tenga pasajes vendidos';






                }
               ?>

               <?php
               function imprimir($mensaje){ echo $mensaje ; } ?>




                <script>
                function llamarDebaja(){
                  alert('<?php echo evaluarDebaja($id_combi); ?>');
                }

                </script>

             	</div>

             </div>
             <?php

        

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
