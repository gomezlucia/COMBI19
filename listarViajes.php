
     <?php function listarViajes($link,$usuario,$nombreUsuario){
             $sesion=true;
             $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
              if($sesion){
                 $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
                 $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
                 $usuario=mysqli_fetch_array ($resultado);
                 $tipo_usuario=$usuario['tipo_usuario'];
             }
             $consulta= "SELECT v.id_viaje,v.id_ruta,r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0)" ;
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
                     $id_viaje=$valores['id_viaje']; ?>
                      <p> 
                         <b>Origen:</b> <?php echo $origen;?><br>
                         <b>Destino:</b> <?php echo $destino;?><br>
                         <b>Fecha y hora de salida:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($fecha_hora_salida));?><br>
                         <b>Fecha y hora de llegada:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($fecha_hora_llegada));?><br>
                         <b>Precio:</b> <?php echo '$' . $precio;?><br>
                         <b>Cupo:</b> <?php 
                         if($cupo<$asientos){
                             echo $cupo;
                         }else{
                             echo $cupo ?> <i>(está lleno)</i>
                   <?php }   ?>
                     <br></p>
               <?php if($sesion){  
                         if( ($cupo==0) and ($tipo_usuario=='administrador') ){ ?>
                             <form action="modificarDatosDeViajes.php" method="post">
                                 <input type="submit" name="modificar" value="Modificar Viaje"></input>
                                 <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                             </form> 
             <?php       }elseif (($cupo<$asientos) and ($tipo_usuario=='cliente') ) { 
                             $comproPasaje="SELECT * FROM clientes_viajes WHERE id_viaje='$id_viaje' and id_cliente='$id'";
                             $resultadoPasaje= mysqli_query($link,$comproPasaje) or die ('Consulta comproPasaje fallida: ' .mysqli_error($link));
                             if(mysqli_num_rows($resultadoPasaje)==0){ ?>
                                 <form action="comprarPasaje.php" method="post">
                                     <input type="submit" name="comprar" value="Comprar pasaje"></input>
                                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 </form> 
                      <?php  }else{  ?>
                                 <form action="" method="post">
                                     <input type="submit" name="cancelar" value="Cancelar pasaje"></input>
                                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                 </form> 
 <?php                       }
                      }
                     }elseif (($cupo<$asientos) ) { ?>
                         <form action="comprarPasaje.php" method="post">
                             <input type="submit" name="comprar" value="Comprar viaje"></input>
                             <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                         </form> 
<?php                }   ?>
                 <hr>
<?php                } // while (($valores = mysqli_fetch_array($resultado)) )

             } //  if ($resultado)
             if(mysqli_num_rows($resultado)==0){ ?>
                 <center> <b>No hay viajes disponibles por el momento</b> </center>
<?php        }  
     } ?>

