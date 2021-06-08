<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
        include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    include "menu.php";
?>
<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
</head>
<body>

 <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>                       
       <hr>     
     </header> 
     <center> 
    <h1>Combis</h1>
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
             	<h3><?php echo $patente ?></h3>
             		<p>
             			<b>Numero de chasis:</b> <?php echo $chasis;?><br>
             			<b>Modelo:</b> <?php echo $modelo;?><br>
             			<b>Tipo de combi:</b> <?php echo $tipo_combi;?><br>
                  <b>Cantidad de asientos:</b> <?php echo $asientos;?><br>
                <?php  if ($debaja == 0){ ?>
                      <form action="funcionEvaluarDebaja.php" method="post">
                         <input type="hidden" name="id_combi" value="<?php echo $id_combi; ?>"> </input>
                          <input type="hidden" name="tipo" value="combi"> </input>
                         <input type="submit" value="Dar de baja"><br><br></input>
                     </form>
                <?php }else{ ?>
                     <b >Combi dada de baja <br><br>
              <?php  } 
         }?>
                 </p>
<?php        if(mysqli_num_rows($resultado)==0){ ?>
                 <p>
                  <b>Aun no hay combis cargadas en la pagina</b>
                 </p>
<?php        }
         } ?>
        </center>  
</html>

