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
        $consulta= "SELECT patente, chasis, modelo, nombre_tipo FROM combis NATURAL JOIN tipos_combi WHERE debaja = 0" ;#debaja = 0 es falso
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
        	while (($valores = mysqli_fetch_array($resultado)) ){
        	 $patente = $valores['patente'];
             $chasis = $valores['chasis'];
             $modelo = $valores['modelo'];
             $tipo_combi = $valores['nombre_tipo'] ;
             ?>
             <div>
             	<h2><?php echo $patente ?></h2>
             	<div>
             		<p>
             			<b>Numero de chasis:</b> <?php echo $chasis;?><br>
             			<b>Modelo:</b> <?php echo $modelo;?><br>
             			<b>Tipo de combi:</b> <?php echo $tipo_combi;?><br>
             		</p>
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