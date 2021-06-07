<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>

 <a href="home.php" >Volver al home </a>
 <h2>Rutas</h2>
     <?php
        $consulta= "SELECT id_ruta, origen,destino,debaja FROM rutas " ;
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
          while (($valores = mysqli_fetch_array($resultado)) ){

        	 $origen = $valores['origen'];
             $destino = $valores['destino'];
             $id_ruta = $valores['id_ruta'];
             $debaja=$valores['debaja'] ?>
            <p>
                 <b>Origen:</b> <?php echo $origen;?> <br>
                 <b>Destino:</b> <?php echo $destino;?><br>
                 <form action="modificarRuta.php" method="post">
                     <input type="submit" name="modificar" value="Modificar Ruta"></input>
                     <input type="hidden" name="ruta" value="<?php echo $id_ruta; ?>"></input>
                 </form>
                 <form action="darDebajaRuta.php" method="post">
                     <input type="submit" name="debaja" value="Dar de baja Ruta"></input>
                     <input type="hidden" name="ruta" value="<?php echo $id_ruta; ?>"></input>
                 </form>
             </p><hr>
              <?php }
             if(mysqli_num_rows($resultado)==0){?>
                 <center> Aun no hay rutas cargadas</center>
            <?php } }?>
</body>
</html>
