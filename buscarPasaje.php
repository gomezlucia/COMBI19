   <?php
  include "BD.php";// conectar y seleccionar la base de datos
  $link = conectar();


if(!empty($_GET['fecha_inicial'])){
   $fecha_inicial=$_GET['fecha_inicial'];}
else{
  $fecha_inicial="";
}
if(!empty($_GET['fecha_final'])){
   $fecha_final=$_GET['fecha_final'];
 }
else{
  $fecha_final="";
}
?>

   <html>
  <head>
    <title>Buscar Pasaje</title>
    <script   src="https://code.jquery.com/jquery-3.1.1.min.js"  ></script>
   
    <script language="javascript">
       $(document).ready(function(){
        $("#origen").change(function () {
          $("#origen option:selected").each(function () {
           var  origen = $(this).val();
            $.post("obtenerDestino.php", { origen: origen }, function(data){
              $("#destino").html(data);
            });            
          });
        });
      });
    </script>
  </head>
  <body>
  <a href="home.php" >Volver al home </a>     
    <form action="validarDatosBusquedaPasaje.php" method="post">
     <h1>Buscar pasaje </h1> 
        Origen :   
             <select id="origen" name= 'origen' required=''  > 
            <?php  if(!empty($_GET['origen'])){  ?>
               <option value="<?php echo $_GET['origen'] ?>"><?php echo $_GET['origen'] ?></option>
      <?php }else{ ?>
             <option value="0">Seleccione uno</option>
               <?php }
               $consulta= "SELECT DISTINCT origen FROM rutas";
               $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error());
               while ($row= $resultado->fetch_assoc()) { ?>
                  <option value="<?php echo $row['origen'] ?>" ><?php echo $row['origen']?></option>   
         <?php  } ?>
     </select> <br><br>
             
Destino:(Opcional)
     <?php  if(!empty($_GET['destino'])){
             $destino=$_GET['destino'];
             $destinoC= "SELECT destino FROM rutas WHERE id_ruta='$destino' ";
             $resultadoC= mysqli_query($link,$destinoC) or die ('Consulta fallida: ' .mysqli_error($link));
             $valor = mysqli_fetch_array($resultadoC);
             $consulta2= "SELECT id_ruta,destino FROM rutas WHERE origen='$_GET[origen]' and id_ruta<>'$destino' ";
             $resultado2= mysqli_query($link,$consulta2) or die ('Consulta fallida: ' .mysqli_error($link));?>
              <select id="destino" name= 'destino'   > 
             <option value="<?php echo $destino ?>" selected="selected"><?php echo  $valor['destino'] ?></option>
       <?php while ($row= $resultado2->fetch_assoc()) { ?>
                  <option value="<?php echo $row['destino'] ?>" ><?php echo $row['destino']?></option>   
         <?php  } ?>
               </select> <br><br> 
      <?php }else{ ?>
               <select name= "destino" id="destino" ></select> 
   <?php    } ?>
     
      <p>Entre las fechas:(Opcional)</p>
      <input type="date" name="fecha_inicial" value="<?php echo "$fecha_inicial"?>"> y
     <input type="date" name="fecha_final" value="<?php echo "$fecha_final"?>" > <br><br>
        <input type="hidden" name="form" required="" value="primer_form" >
        <input type="submit" value="Buscar ">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='home.php'"> 
    </form>
</body>
</html>
