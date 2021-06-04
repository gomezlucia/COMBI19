<?php
     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     $sesion=true;
?>
<!DOCTYPE html>
<html>
<head>
</head>

<body>
<a href="home.php">Volver al home</a>
      <h1>Viajes disponibles</h1>
     <?php
          
         $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
         if($sesion){
             $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
             $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
             $usuario=mysqli_fetch_array ($resultado);
             $tipo_usuario=$usuario['tipo_usuario'];
         }



$mensaje="";
/*echo $_POST['origen'].";";
echo $_POST['destino'].";";
echo "campo destino:".(empty($_POST['destino'])).";";
echo $_POST['fecha_inicial'];
echo $_POST['fecha_final'];
echo " Fecha actual".date("Y-m-d");*/
echo isset($tipo_usuario)."aca";#si es falso no hay
if (empty($_POST['origen'])){
    $mensaje= "debe estar completo origen";
}
else{//origen esta lleno
    $origen=$_POST['origen'];
    $busco_destino=false;
    $busco_rango=false;
    $fecha1=((empty($_POST['fecha_inicial']))and (!empty($_POST['fecha_final'])));

    $fecha2=((!empty($_POST['fecha_inicial'])) and (empty($_POST['fecha_final'])));
    //echo "segundo incompleto:".$fecha1."primero incompleto".$fecha2;
    if (($fecha1) or ($fecha2))   {#se ingreso el rango incompleto
        $mensaje= "Si se desea buscar por rango de fechas, se deben completar ambas";
    }
    else{
        if(!empty($_POST['destino'])){
        $destino=$_POST['destino'];
        echo "entree al destino";
        $busco_destino=true;
    }
      if((!empty($_POST['fecha_inicial'])) and (!empty($_POST['fecha_final']))){//ingreso el rango completo
        echo "entre el rango";
        $fecha_inicial=$_POST['fecha_inicial'];
        $fecha_final=$_POST['fecha_final'];
        if(($fecha_final<$fecha_inicial) or ($fecha_inicial<date("Y-m-d"))){
            $mensaje="Se debe ingresar un rango de fechas valido";#la fecha final no debe ser menor a la inicial y la inicial no debe ser menor a la actual
        }
        else{
        $busco_rango=true;
       }
   } 
}
}
if($mensaje<>""){
    echo "<script > alert('$mensaje');window.location='buscarPasaje.php?origen=$origen'</script>";;
}
else{
    if(  ($busco_destino) and ($busco_rango)  ){
        echo ";;;todo";
        $consulta= "SELECT v.id_viaje,v.id_ruta, r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) AND DATE(v.fecha_hora_salida)>='2021-06-10' AND DATE(v.fecha_hora_salida)<='2021-07-20' AND r.origen='$origen' AND r.destino='$destino'" ;}
    else{
        if($busco_destino){
            echo "busco_destino";
            $consulta="SELECT v.id_viaje,v.id_ruta, r.origen, r.destino,v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) and r.origen='$origen' AND r.destino='$destino'";
        }
        elseif ($busco_rango) {
            echo "busco_rango";
             $consulta="SELECT v.id_viaje,v.id_ruta, r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) AND DATE(v.fecha_hora_salida)>='$fecha_inicial' AND DATE(v.fecha_hora_salida)<='$fecha_final' AND r.origen='$origen'";
        }
        else{
            $consulta="SELECT v.id_viaje,v.id_ruta, r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0) and r.origen='$origen'";
        }
    }

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
                 $id_viaje=$valores['id_viaje'];?>
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
                 <?php if($sesion){  
                         if( ($cupo==0) and ($tipo_usuario=='administrador') ){ ?>
                             <form action="modificarDatosDeViajes.php" method="post">
                                 <input type="submit" name="modificar" value="Modificar Viaje"></input>
                                 <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                             </form> 
             <?php       }elseif (($cupo<$asientos) and ($tipo_usuario=='cliente') ) { 
                             $comproPasaje="SELECT * FROM clientes_viajes WHERE id_viaje='$id_viaje' and id_cliente='$id'";
                             $resultadoPasaje= mysqli_query($link,$comproPasaje) or die ('Consulta comproPasaje fallida: ' .mysqli_error($link));
                             if(mysqli_num_rows($resultadoPasaje)==0){?>
                                 <form action="comprarPasaje.php" method="post">
                                     <input type="submit" name="comprar" value="Comprar pasaje"></input>
                                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 </form> 
                      <?php  }else{  ?>
                                 <form action="" method="post">
                                     <input type="submit" name="cancelar" value="Cancelar pasaje"></input>
                                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 </form> 
    }
 <?php                       }
                      }
                     }elseif (($cupo<$asientos) ) { ?>
                         <form action="comprarPasaje.php" method="post">
                             <input type="submit" name="comprar" value="Comprar viaje"></input>
                             <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                         </form> 
<?php                }
             }
                 
        }
         if(mysqli_num_rows($resultado)==0){ ?>
             <center> <b>No hay viajes disponibles por el momento</b> </center>
<?php        } }  ?>
</body>
</html>