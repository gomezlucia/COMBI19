<?php
     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
       include "menu.php"; 
     $sesion=true;  
?>
<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
     <script type="text/javascript" src="confirmarCancelarPasaje.js"></script>
     <script type="text/javascript" src="seguir.js"></script>
</head>

<body>
     <?php
          
         $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
         if($sesion){
             $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
             $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
             $usuario=mysqli_fetch_array ($resultado);
             $tipo_usuario=$usuario['tipo_usuario'];
         }

     $mensaje="";
     $_SESSION['busco_origen']=$_POST['origen'];
     $busco_destino=false;
     $busco_rango=false;
     if(!empty($_POST['destino'])){
         $busco_destino=true;
         $_SESSION['busco_destino']=$_POST['destino'];
     }
     $fecha_inicial="";
     $fecha_final="";
     if  (empty($_POST['fecha_inicial']) and !empty($_POST['fecha_final']) ){#se ingreso el rango incompleto
         $_SESSION['fecha_final']=$_POST['fecha_final'];
         echo "<script > alert('Si se desea buscar por rango de fechas, se deben completar ambas');window.location='home.php?error=1&busco_destino=$busco_destino&busco_final=1'</script>";
     }elseif(!empty($_POST['fecha_inicial']) and empty($_POST['fecha_final'])){#se ingreso el rango incompleto
         $_SESSION['fecha_inicial']=$_POST['fecha_inicial'];
         echo "<script > alert('Si se desea buscar por rango de fechas, se deben completar ambas');window.location='home.php?error=1&busco_destino=$busco_destino&busco_inicial=1'</script>";
     }elseif((!empty($_POST['fecha_inicial'])) and (!empty($_POST['fecha_final']))){//ingreso el rango completo
         if(($_POST['fecha_final']<$_POST['fecha_inicial']) or ($_POST['fecha_inicial']<date("Y-m-d"))){
             $_SESSION['fecha_inicial']=$_POST['fecha_inicial'];
             $_SESSION['fecha_final']=$_POST['fecha_final'];
             echo "<script > alert('Se debe ingresar un rango de fechas valido');window.location='home.php?error=1&busco_destino=$busco_destino&busco_final=1&busco_inicial=1'</script>";
         }else{
             $busco_rango=true;
         }
     }
     if(($busco_destino) and ($busco_rango)  ){
         $fecha_hora_salida=strftime('%Y-%m-%d %H:%M:%S', strtotime($_POST['fecha_inicial'])); 
         $fecha_hora_llegada=strftime('%Y-%m-%d %H:%M:%S', strtotime($_POST['fecha_final']));
         $consulta= "SELECT  v.debaja, v.id_viaje,v.id_ruta, r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) AND DATE(v.fecha_hora_salida)>='$_POST[fecha_inicial]' AND DATE(v.fecha_hora_llegada)<='$_POST[fecha_final]' AND r.id_ruta='$_POST[destino]'" ;
     }else{
         if($busco_destino){
             $consulta="SELECT  v.debaja, v.id_viaje,v.id_ruta, r.origen, r.destino,v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0)  AND r.id_ruta='$_POST[destino]'";
         }elseif ($busco_rango) {
             $consulta="SELECT  v.debaja,v.id_viaje,v.id_ruta, r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) AND DATE(v.fecha_hora_salida)>='$_POST[fecha_inicial]' AND DATE(v.fecha_hora_llegada)<='$_POST[fecha_final]' AND r.origen='$_POST[origen]'";
         }else{
            $consulta="SELECT v.debaja, v.id_viaje,v.id_ruta, r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) and r.origen='$_POST[origen]'";
         }
     } ?>
  <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
<?php   
         if ($sesion) { ?>
             <b><?php echo $nombreUsuario; ?></b>
<?php        echo menu($id,$link);   
         }    ?>                    
       <hr>     
     </header>
     <center>
      <h1>Viajes disponibles</h1>
<?php 
     $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
     if ($resultado){
         while (($valores = mysqli_fetch_array($resultado)) ){
             $origen = $valores['origen'];
             $destino = $valores['destino'];
             $fecha_hora_salida = $valores['fecha_hora_salida'];
             $fecha_hora_llegada = $valores['fecha_hora_llegada'] ;
             $precio = $valores['precio'] ;
             $cupo=$valores['cupo'];
             $asientos=$valores['asientos'];
             $id_viaje=$valores['id_viaje'];
             $debaja=$valores['debaja']?>
             <hr>
             <p> <b>Origen:</b> <?php echo $origen;?><br>
                     <b>Destino:</b> <?php echo $destino;?><br>
                     <b>Fecha y hora de salida:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($fecha_hora_salida));?><br>
                     <b>Fecha y hora de llegada:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($fecha_hora_llegada));?><br>
                     <b>Precio:</b> <?php echo '$' . $precio;?><br>
                     <b>Cupo:</b> <?php 
                     if($cupo<$asientos){
                         echo $cupo;
                     }else{
                         echo $cupo ?> <i>(está lleno)</i>
                     <?php }?>
             </p><br>
             <?php 
                 if($sesion){ 
                     if( ($tipo_usuario=='administrador') ){
                         if ($cupo==0) { ?>
                             <form action="modificarDatosDeViajes.php" method="post">
                                 <input type="submit" name="modificar" value="Modificar Viaje"></input>
                                 <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 <input type="hidden" name="volverA" value="home.php">
                             </form> 
<?php                    } 
                         if($debaja!=0){ ?>
                                 <b>Estado:</b> <?php echo "Cancelado";?>
               <?php     }else{ ?>
                             <form action="cancelarViaje.php" method="post">
                                 <input type="submit" name="modificar" value="Cancelar viaje"  onclick="return SubmitFormulario(this.form)"></input>
                                 <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                  <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
                                   <input type="hidden" name="volverA" value="home.php">
                             </form> 
                <?php    }
                     }elseif (($cupo<$asientos) and ($tipo_usuario=='cliente') ) { 
                         $comproPasaje="SELECT * FROM clientes_viajes WHERE id_viaje='$id_viaje' and id_cliente='$id'";
                         $resultadoPasaje= mysqli_query($link,$comproPasaje) or die ('Consulta comproPasaje fallida: ' .mysqli_error($link));
                         if (mysqli_num_rows($resultadoPasaje)!=0) {
                             $valores = mysqli_fetch_array($resultadoPasaje);
                             if($valores['estado']=='devuelto total' or $valores['estado']=='devuelto parcial'  ){  ?>
                                 <form action="comprarPasaje.php" method="post">
                                 <input type="submit" name="comprar" value="Comprar pasaje"></input>
                                 <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 <input type="hidden" name="volverA" value="home.php">
                                 <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
                                 </form> 
                  <?php      }else{  ?>
                                 <form action="cancelarPasaje.php" method="post">
                                 <input type="submit" name="cancelar" value="Cancelar pasaje" onclick="return SubmitForm(this.form)"></input>
                                 <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 <input type="hidden" name="pagina" value="validarDatosBusquedaPasaje.php"></input>
                                 <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
                                 </form>
  <?php                      }
                         }else{ ?>
                             <form action="comprarPasaje.php" method="post">
                     <input type="submit" name="comprar" value="Comprar pasaje"></input>
                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                     <input type="hidden" name="volverA" value="home.php">
                 </form> 
           <?php              }

              }  
             }elseif($cupo<$asientos){//if(sesion) 
                ?>
                 <form action="comprarPasaje.php" method="post">
                     <input type="submit" name="comprar" value="Comprar pasaje"></input>
                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                     <input type="hidden" name="volverA" value="home.php">
                 </form> 
 <?php       }
         
         }//while
     }//if($resultado)
                 
     if(mysqli_num_rows($resultado)==0){ ?>
         <center> 
             <b>No hay viajes disponibles por el momento</b> 
         </center>
<?php }  ?>
</center>
</body>
</html>


