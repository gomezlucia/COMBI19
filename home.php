<?php
     include "BD.php";// conectar y seleccionar la base de datos
     $link = conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     include "listarViajes.php";
     include "menu.php";
     $sesion=true;
?>
<html>
    <head>
        <title> COMBI-19</title>
       <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
     </head>

     <body> 
       <header>
         <a href="home.php" >  
             <img src="logo_is.png" class="div_icono">  
         </a>
         
         
<?php        $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
             if ($sesion) { ?>
                 <b><?php echo $nombreUsuario; ?></b>
<?php          echo menu($id,$link);
             }else{ ?> 
                 <div class="links">
                 <li><a href="inicioSesion.php"><p>Iniciar Sesion</p></a></li>
                 <li><a href="registroUsuario.php"><p>Registrarse como nuevo usuario<p></a></li> 
                    </div> 
 <?php       } ?>                       
         <hr>     
         </header>
         <div class="comentarios">
             <center>COMENTARIOS</center>
         </div>
         <div class="buscador">
             <center>BUSCADOR</center>
         </div>
         <div class="listado">
             <center>
<?php        echo listarViajes($link,$usuario,$nombreUsuario,$sesion,$id);  ?>
             </center>
         </div>                
     </body> 
</html>
