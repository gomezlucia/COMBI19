<?php function listarViajes($link,$usuario,$nombreUsuario,$id,$vieneDelHome){
        $sesion=true;
        $usuario -> tieneSesionIniciada($sesion,$nombreUsuario);
         if($sesion){
            $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'";
            $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
            $usuario=mysqli_fetch_array ($resultado);
            $tipo_usuario=$usuario['tipo_usuario'];
        }
        if($vieneDelHome==1) {
            $consulta= "SELECT v.id_viaje,v.id_ruta,r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos,v.debaja FROM viajes v NATURAL JOIN combis c NATURAL JOIN tipos_combi t NATURAL JOIN rutas r WHERE (now()<=fecha_hora_salida)and (debaja=0)" ;
        }else{
            $consulta= "SELECT v.id_viaje,v.id_ruta,r.origen, r.destino, v.fecha_hora_salida, v.fecha_hora_salida, v.fecha_hora_llegada, v.precio, v.cupo, t.asientos,v.debaja,v.motivo_cancelacion FROM viajes v INNER JOIN combis c on (v.id_combi=c.id_combi) INNER JOIN tipos_combi t on (c.id_tipo_combi =t.id_tipo_combi ) INNER JOIN rutas r on (v.id_ruta=r.id_ruta)" ;
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
                $id_viaje=$valores['id_viaje'];
                $debaja=$valores['debaja'];
                $motivo=$valores['motivo_cancelacion']?>
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
                    if( ($tipo_usuario=='administrador') ){
                         if ($fecha_hora_salida> date("Y-m-d H:i:s")) {
                             if($debaja!=0 and empty($motivo) ){ ?>
                                  <b>Estado:</b> <?php echo "Cancelado";?>
              <?php          }elseif(!empty($motivo)){ ?>
                                 <b>Estado:</b> <?php echo "Cancelado por el chofer ("."<i>".$motivo."</i>".")";?>
                <?php        }else{ ?>
                                 <form action="cancelarViaje.php" method="post">
                                     <input type="submit" name="modificar" value="Cancelar viaje" class="btn_buscar"  onclick="return SubmitFormulario(this.form)" ></input>
                                     <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                     <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
                            <?php    if($vieneDelHome==1){ ?>
                                         <input type="hidden" name="volverA" value="home.php">
                   <?php             }else{?>
                                         <input type="hidden" name="volverA" value="viajes.php">
                          <?php      }?>
                                 </form>
             <?php
                            if($cupo==0){?>
                                <form action="modificarDatosDeViajes.php" method="post">
                                    <input type="submit" name="modificar" value="Modificar Viaje"></input>
                                    <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                           <?php    if($vieneDelHome==1){ ?>
                                        <input type="hidden" name="volverA" value="home.php">
                   <?php            }else{?>
                                        <input type="hidden" name="volverA" value="viajes.php">
                          <?php     }?>
                                </form> <br>
           <?php            }
                        }
                     }else{ ?>
                         <b>Estado:</b> <?php echo "Finalizado";?>
           <?php      }   
                    }elseif (($cupo<$asientos) and ($tipo_usuario=='cliente') ) {
                            $comproPasaje="SELECT estado FROM clientes_viajes WHERE id_viaje='$id_viaje' and id_cliente='$id' order by id_cliente_viaje desc";
                            $resultadoPasaje= mysqli_query($link,$comproPasaje) or die ('Consulta comproPasaje fallida: ' .mysqli_error($link));
                             if(mysqli_num_rows($resultadoPasaje)!=0){
                                  $valores = mysqli_fetch_array($resultadoPasaje);
                                 if($valores['estado']=='devuelto total' or $valores['estado']=='devuelto parcial'  ){  ?>
                                      <form action="agregarAdicionalesAlPasaje.php" method="post">
                                    <input type="submit" name="comprar" value="Comprar pasaje"></input>
                                    <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                    <input type="hidden" name="volverA" value="home.php">
                                     </form>
                 <?php           }else{ 
                                     if ($valores['estado']== 'pendiente'){//ya lo habia comprado ?>
                                     <form action="cancelarPasaje.php" method="post">
                                         <input type="submit" name="cancelar" value="Cancelar pasaje"  class="btn_buscar"  onclick="return SubmitForm(this.form)" ></input>
                                         <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                                         <input type="hidden" name="pagina" value="home.php"></input>
                                         <input type="hidden" name="ruta" value="<?php echo $origen."-".$destino; ?>"></input>
                                     </form>
<?php                                }
                                 }
                             }else{ ?>
                                <form action="agregarAdicionalesAlPasaje.php" method="post">
                        <input type="submit" name="comprar" value="Comprar pasaje"></input>
                        <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                         <input type="hidden" name="volverA" value="home.php">
                    </form>
                      <?php       }
                            
                     } ?>
        <?php
                 }elseif (($cupo<$asientos) ) { ?>
                    <form action="agregarAdicionalesAlPasaje.php" method="post">
                        <input type="submit" name="comprar" value="Comprar pasaje"></input>
                        <input type="hidden" name="id_viaje" value="<?php echo $id_viaje; ?>"></input>
                         <input type="hidden" name="volverA" value="home.php">
                    </form>
<?php                }   ?>
            <hr>
<?php                } // while (($valores = mysqli_fetch_array($resultado)) )

        } //  if ($resultado)
        if(mysqli_num_rows($resultado)==0){ ?>
            <center> <b>No hay viajes disponibles por el momento</b> </center>
<?php        }
} ?>
