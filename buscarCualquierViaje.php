 <?php
 function buscar($link){ ?>
   <form action="validarDatosBusquedaPasaje.php" method="post">
     <h2>Buscar Viaje </h2> 
        <select name= 'rutas' id="rutas">
             <option value="0">Seleccione ruta</option>
             <?php $consulta= "SELECT id_ruta,origen,destino FROM rutas WHERE  debaja='0'";
             $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option value="' . $valores["id_ruta"] . '">' . $valores["origen"] ."-". $valores["destino"]. '</option>';}?>
     </select> <br>
      <p>Entre las fechas:(Opcional)</p>
      <input type="date" name="fecha_inicial" > y
     <input type="date" name="fecha_final" > <br><br>
        <input type="hidden" name="form" required="" value="primer_form" >
        <input type="submit" value="Buscar">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='home.php'"> 
    </form><br>
<?php } 
?>

