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

 <a href="home.php" >Volver al home </a>   
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
             $asientos = $valores['asientos'];
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
                  <form action="funcionEvaluarDebaja.php" method="post">
                <input type="hidden" name="id_combi" value="<?php echo $id_combi; ?>"> </input>
                <input type="hidden" name="tipo" value="combi"> </input>
                <input type="submit" value="Dar de baja"><br><br></input>

                </form>
                <?php
              }
              else{ ?>
                <br>
                <b >Combi dada de baja <br><br>
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
                  <center> <b>Aun no hay combis cargadas en la pagina</b>
            </div>
            <?php

            }
       }

        ?>
</html>
