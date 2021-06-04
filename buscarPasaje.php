  <?php
  include "BD.php";// conectar y seleccionar la base de datos
  $link = conectar();

if(!empty($_GET['origen'])){
  echo $_GET['origen'];
}
if(!empty($_GET['destino'])){
  echo $_GET['destino'];
}
if(!empty($_GET['fecha_inicial'])){
  echo $_GET['fecha_final'];}

?>

   <html>
  <head>
    <title>Buscar Pasaje</title>
  </head>
  <body>
  <a href="home.php" >Volver al home </a>     
    <form action="validarDatosBusquedaPasaje.php" method="post">
     <h1>Buscar pasaje </h1> 
        Origen :
        
       <select id="origen" name= 'origen' required >
             <option value="">Seleccione uno</option>
              <?php $consulta= "SELECT DISTINCT origen FROM rutas";
             $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              $i=1;
             while( $valores = mysqli_fetch_array($resultado)){
   echo '<option value="' . $valores["origen"] . '">' . $valores["origen"] . '</option>';
     $i++;}?>
  
     </select> <br><br>
Destino:(Opcional)
     <select name= 'destino' >
             <option value="">Seleccione uno</option>
              <?php $consulta= "SELECT DISTINCT destino FROM rutas ";
             $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
              $i=1;
             while( $valores = mysqli_fetch_array($resultado)){
   echo '<option value="' . $valores["destino"] . '">' . $valores["destino"] . '</option>';
     $i++;}?>
  
     </select> 
      <p>Entre las fechas:(Opcional)</p>
      <input type="date" name="fecha_inicial" > y
     <input type="date" name="fecha_final" > <br><br>
        <input type="hidden" name="form" required="" value="primer_form" >
        <input type="submit" value="Buscar">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='home.php'"> 
    </form>
<!--parte del destino que todavia no hice  -->




</body>
</html>