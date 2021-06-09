 <?php
 function buscar($link,$fecha_inicial,$fecha_final,$ruta){ ?>
   <form action="validarDatosBusquedaViaje.php" method="post">
     <h2>Buscar Viaje </h2> 
     <?php echo "algo". $ruta; 
     if(empty($ruta)){
      echo "sii";
     }?>
        <select name= 'rutas' id="rutas" required="">
             <option value="">Seleccione ruta</option>
             <?php
             if(empty($ruta)){ 
             $consulta= "SELECT id_ruta,origen,destino FROM rutas WHERE  debaja='0'";
             $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option  value="' . $valores["id_ruta"] . '">' . $valores["origen"] ."-". $valores["destino"]. '</option>';
              }
          }

            else{
              $consulta_r= "SELECT id_ruta,origen,destino FROM rutas WHERE  debaja='0' and id_ruta='$ruta'";
              $resultado_r= mysqli_query($link,$consulta_r) or die ('Consulta fallida: ' .mysqli_error($link));
              $valores_r = mysqli_fetch_array($resultado_r);
              echo '<option selected="true" value="' . $valores_r["id_ruta"] . '" select="" >' . $valores_r["origen"] ."-". $valores_r["destino"]. '</option>';
              $consulta= "SELECT id_ruta,origen,destino FROM rutas WHERE  debaja='0' and id_ruta<>'$ruta'";
              $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option value="' . $valores["id_ruta"] . '">' . $valores["origen"] ."-". $valores["destino"]. '</option>';}
            }

            ?>
     </select> <br>
      <p>Entre las fechas:(Opcional)</p>
      <input type="date" name="fecha_inicial" value="<?php echo $fecha_inicial ?>" > y
     <input type="date" name="fecha_final" value="<?php echo $fecha_final ?>" > <br><br>
        <input type="hidden" name="form" required="" value="primer_form" >
        <input type="submit" value="Buscar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='home.php'"> 
    </form><br>
<?php } 
?>

