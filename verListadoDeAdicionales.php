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
    <h1>Servicios Adicionales</h1>
     <?php
        $consulta= "SELECT s.nombre_servicio, s.precio, s.id_servicio_adicional FROM servicios_adicionales s " ;#debaja = 0 es falso
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
        if ($resultado){
          while (($valores = mysqli_fetch_array($resultado)) ){

        	 $precio = $valores['precio'];
             $nombre_servicio = $valores['nombre_servicio'];
             $id_servicio_adicional=$valores['id_servicio_adicional'];

             ?>
             		<p>
             			<b>Nombre:</b> <?php echo $nombre_servicio;?><br>
             			<b>Precio:</b> $<?php echo $precio;?><br>
 <form action="modificarDatosAdicionales.php" method="post"> 
                           <input type="hidden"name="id" value="<?php echo $id_servicio_adicional;?>">
                           <input type="submit"  value ="Editar">
                        </form><br>
                  <hr>
                 </p>

<?php     }   if(mysqli_num_rows($resultado)==0){ ?>
                 <p>
                  <b>Aun no hay adicionales cargados en la pagina</b>
                 </p>
<?php        }
         } ?>
        </center>  
</html>

