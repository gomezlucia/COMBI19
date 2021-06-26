<?php
     include "BD.php";// conectar y seleccionar la base de datos
     $link = conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     include "listarViajes.php";
     include "menu.php";
     include "buscarPasaje.php";
     $sesion=true;
?>
<html>
    <head>
        <title> COMBI-19</title>
           <script type="text/javascript" src="seguir.js"></script>
          <script type="text/javascript" src="confirmarCancelarPasaje.js"></script>
       <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
     </head>

     <body>
       <header>
         <a href="home.php" >
             <img src="logo_is.png" class="div_icono">
         </a>


<?php        $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
             if ($sesion) { ?>

                 <?php $consulta00= "SELECT u.vip FROM usuarios u WHERE u.id_usuario=$id";
                       $resultado00= mysqli_query($link,$consulta00) or die ('Consulta fallida: 00 ' .mysqli_error($link));
                       $es_vip = mysqli_fetch_array($resultado00);
                       if ($es_vip['vip']=='1'){ ?>
                         <b><?php echo $nombreUsuario ; ?></b> <b>VIP</b>
                 <?php } else{    ?>
                   <b><?php echo $nombreUsuario; ?></b>
<?php      }    echo menu($id,$link);
             }else{ ?>
                 <div class="links">
                 <li><a href="inicioSesion.php"><p>Iniciar Sesion</p></a></li>
                 <li><a href="registroUsuario.php"><p>Registrarse como nuevo usuario<p></a></li>
                    </div>
 <?php       } ?>
         <hr>
         </header>
         <div class="container-main">
         <div class="buscador">
             <center>
               <?php
                 if (isset($_GET['error'])) {
                     $origen=$_SESSION['busco_origen'];
                     if(!empty($_GET['busco_final'])){
                         $fecha_final=$_SESSION['fecha_final'];
                     }else{
                         $fecha_final="";
                     }
                     if(!empty($_GET['busco_inicial'])){
                         $fecha_inicial=$_SESSION['fecha_inicial'];
                     }else{
                         $fecha_inicial="";
                     }
                     if (!empty($_GET['busco_destino'])) {
                         $destino=$_SESSION['busco_destino'];
                     }else{
                         $destino="";
                     }
                 }else{
                    $origen="";
                    $destino="";
                    $fecha_final="";
                    $fecha_inicial="";
                 }
               echo buscar($link,$fecha_inicial,$fecha_final,$origen,$destino);  ?>

             </center>

         </div>
         <div class="comentarios">
             <h2>Comentarios</h2>
              <?php
         $consulta="SELECT c.puntaje, c.comentario, u.nombre FROM calificaciones c INNER JOIN viaje_calificacion v ON (v.id_calificacion=c.id_calificacion) INNER JOIN usuarios u ON (v.id_cliente=u.id_usuario) ORDER BY c.id_calificacion DESC LIMIT 10";
         $resultado=mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
         while ($valores=mysqli_fetch_array($resultado)) {
            $nombre=$valores['nombre'];
            $puntaje=$valores['puntaje'];
            $comentario=$valores['comentario'];
            ?>
              <div>
                    <hr>
                    <p>
                        <b>Nombre:</b> <?php echo $nombre;?><br>
                        <b>Puntaje:</b> <?php echo $puntaje;?><br>
                         <?php echo $comentario;?><br>
      <?php }
       if(mysqli_num_rows($resultado)==0){
            ?>
            <div>
                 <p>
                  <center> <b>No hay comentarios en la pagina por el momento</b>
            </div>
            <?php

            }
         ?>
            </p>
        </div>

         </div>
</div>
         <div class="listado">
             <center>
               <?php if ((isset($es_vip))and($es_vip['vip']=='0')){ ?>
               <form action="registrarVIP.php" method="post">
                   <b> Si se registra como cliente vip, obtendra un 10% de descuento en cada compra que realice en nuestra página! </b><br><br>
                  <input type="submit" value="Registrarse como cliente VIP"><br><br>

               </form>
             <?php } ?>
             <h1><b>Viajes</b></h1>
<?php        echo listarViajes($link,$usuario,$nombreUsuario,$id,true);  ?>
             </center>
         </div>



     </body>
</html>
