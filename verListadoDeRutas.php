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
  <script type="text/javascript" src="seguir.js"></script>
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
                 <?php if ($debaja == 0) { ?>
                 <form action="darDebajaRuta.php" method="post">
                     <input type="submit" name="debaja" value="Dar de baja Ruta" class="btn_buscar"  onclick="return SubmitForm(this.form)" ></input><br>
                     <input type="hidden" name="id_ruta" value="<?php echo $id_ruta; ?>"></input>
                     <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
                 </form>
                 <form action="modificarRuta.php" method="post">
                     <input type="submit" name="modificar" value="Modificar Ruta"></input>
                     <input type="hidden" name="ruta" value="<?php echo $id_ruta; ?>"></input>
                 </form>
             </p><hr>
    <?php }else{ ?>
       <i>Ruta dada de baja</i><hr>
   <?php }
 }
          if(mysqli_num_rows($resultado)==0){?>
              <p><b>Aun no hay rutas cargadas</b></p>
            <?php }
         }?>
         </center>
</body>
</html>

