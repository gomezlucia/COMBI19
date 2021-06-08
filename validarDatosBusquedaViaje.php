<?php
     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     $sesion=true;
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
     <?php
          
         $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
         if($sesion){
             $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
             $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
             $usuario=mysqli_fetch_array ($resultado);
             $tipo_usuario=$usuario['tipo_usuario'];
         }

     $mensaje="";
     $ruta=$_POST['rutas'];
     $busco_rango=false;
     if ( (empty($_POST['fecha_inicial']) and !empty($_POST['fecha_final']) ) or (!empty($_POST['fecha_inicial']) and empty($_POST['fecha_final']) ) ){#se ingreso el rango incompleto
         $mensaje= "Si se desea buscar por rango de fechas, se deben completar ambas";
     }
     else{
         if((!empty($_POST['fecha_inicial'])) and (!empty($_POST['fecha_final']))){//ingreso el rango completo
             if($_POST['fecha_final']<$_POST['fecha_inicial']){
                 $mensaje="Se debe ingresar un rango de fechas valido";#la fecha final no debe ser menor a la inicial
             }else{
                 $busco_rango=true;
             }
         } 
     }
if($mensaje<>""){
     echo "<script > alert('$mensaje');window.location='viajes.php?ruta=$ruta&fecha_inicial=$_POST[fecha_inicial]&fecha_final=$_POST[fecha_final]'</script>";;
}
else{
    if($busco_rango){
         $fecha_hora_salida=strftime('%Y-%m-%d %H:%M:%S', strtotime($_POST['fecha_inicial'])); //dudaa
         $fecha_hora_llegada=strftime('%Y-%m-%d %H:%M:%S', strtotime($_POST['fecha_final']));
         $consulta= "SELECT v.id_viaje,v.id_ruta,r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos,v.debaja FROM viajes v INNER JOIN combis c on (v.id_combi=c.id_combi) INNER JOIN tipos_combi t on (c.id_tipo_combi =t.id_tipo_combi ) INNER JOIN rutas r on (v.id_ruta=r.id_ruta) WHERE r.id_ruta='$ruta' AND DATE(v.fecha_hora_salida)>='$_POST[fecha_inicial]' AND v.fecha_hora_salida<='$_POST[fecha_final]'" ;
     }else{
            $consulta="SELECT v.id_viaje,v.id_ruta,r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos,v.debaja FROM viajes v INNER JOIN combis c on (v.id_combi=c.id_combi) INNER JOIN tipos_combi t on (c.id_tipo_combi =t.id_tipo_combi ) INNER JOIN rutas r on (v.id_ruta=r.id_ruta) WHERE r.id_ruta=$ruta";
         }
      ?>
    <center>
      <h1>Viajes </h1>
<?php     $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
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
                 $debaja=$valores['debaja'];?>
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
                     <?php }?><br>
                 </p>
                 <?php if($debaja!=0){ ?>
                                <b>Estado:</b> <?php echo "Cancelado";?>
                   <?php     }else{ 
                                 if($cupo==0){?>
                                     <form action="modificarDatosDeViajes.php" method="post">
                                         <input type="submit" name="modificar" value="Modificar Viaje"></input>
                                         <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                         <input type="hidden" name="listarViajes" value="<?php echo $home ?>">
                                         <input type="hidden" name="volverA" value="viajes.php">
                                     </form> <br>
                <?php            } ?>
                                 <form action="cancelarViaje.php" method="post">
                                     <input type="submit" name="modificar" value="Cancelar viaje"></input>
                                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                             </form> 

                  <?php      }       
             } //while
         } //if ?>

                        
<?php                
             
         if(mysqli_num_rows($resultado)==0){ ?>
             <b>No hay viajes para ese/esos criterios momentaneamente</b> 
<?php        }   }?>
</center></body>
</html>

