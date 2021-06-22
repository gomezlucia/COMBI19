<?php 
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
include "menu.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
     <script   src="https://code.jquery.com/jquery-3.1.1.min.js"  ></script>
    <script type="text/javascript">
 	     function mostrarBoton(id) {
             var x = document.getElementById('btn-'+ id);
             if (x.style.display === "none") {
                 x.style.display = "block";
              } else {
                 x.style.display = "none";
             }
         }
         function validarCheckbox(){
             if(!$('input[id=checkbox1]:checked').length==1){
                 document.getElementById("mensajeError").innerHTML = "Por favor complete si tuvo fiebre en la ultima semana";
                 return false;
             }
             if(!$('input[id=checkbox2]:checked').length==1){
                 document.getElementById("mensajeError").innerHTML = "Por favor complete si perdió el gusto y/o olfato en la última semana";
                 return false;
             }
             if(!$('input[id=checkbox3]:checked').length==1){
                 document.getElementById("mensajeError").innerHTML = "Por favor complete si tiene dolor de garganta";
                 return false;
             }
             if(!$('input[id=checkbox4]:checked').length==1){
                 document.getElementById("mensajeError").innerHTML = "Por favor complete si tiene dificultad respiratoria";
                 return false;
             }
             return true;
         }
 </script>  
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
<center>
	 <?php
     $consulta= "SELECT * FROM rutas r INNER JOIN viajes v ON (r.id_ruta=v.id_ruta) INNER JOIN combis c ON (v.id_combi=c.id_combi) WHERE v.debaja=0 and v.fecha_hora_salida=(SELECT MIN(v1.fecha_hora_salida) FROM viajes v1 WHERE (now()<=v1.fecha_hora_salida) and v1.id_chofer='$id')" ;
     $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
     if ($resultado){
     	 $viaje=mysqli_fetch_array ($resultado);
     	 $consulta2="SELECT * FROM usuarios u INNER JOIN clientes_viajes cv ON (u.id_usuario=cv.id_cliente)  INNER JOIN viajes v ON (cv.id_viaje=v.id_viaje) WHERE v.id_viaje='$viaje[id_viaje]'";
     	 $resultado2= mysqli_query($link,$consulta2) or die ('Consulta2 fallida: ' .mysqli_error($link)); ?>
          <h1>Proximo viaje</h1>
         <p>
             <b>Origen:</b> <?php echo $viaje['origen'];?><br>
             <b>Destino:</b> <?php echo $viaje['destino'];?><br>
             <b>Combi:</b> <?php echo $viaje['patente'];?><br>
             <b>Fecha y hora de salida:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($viaje['fecha_hora_salida']));?><br>
             <b>Fecha y hora de llegada:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($viaje['fecha_hora_llegada']));?><br>
             </p>
<?php    if(mysqli_num_rows($resultado2)==0){ //no tiene pasajeros ?>
             <p>
         	     <b>Sin pasajeros</b>
             </p>
<?php    }else{ //tiene pasajeros
	         $counter = 0;?>
	         <h3>Pasajeros:</h3>
 <?php       while ($pasajeros=mysqli_fetch_array ($resultado2)) { 
 	             $ddjjCompletada="SELECT estado FROM ddjj_cliente WHERE id_viaje='$viaje[id_viaje]' and id_cliente='$pasajeros[id_usuario]'";
                 $resultddjjCompletada=mysqli_query($link,$ddjjCompletada) or die ('Consulta ddjjCompletada fallida: ' .mysqli_error($link)); 
 	             if( (mysqli_num_rows($resultddjjCompletada)!=0) or ($pasajeros['estado']=='pendiente') ){ ?>
                     <p>
                         <b>Nombre:</b> <?php echo $pasajeros['nombre']." ";?>
                         <b>Apellido:</b> <?php echo $pasajeros['apellido']." ";?>
                         <b>DNI:</b> <?php echo $pasajeros['DNI'];?><br>
                     </p> 
 <?php          
                     if(mysqli_num_rows($resultddjjCompletada)==0){ //no complero la DDJJ ?>
                         <button onclick="mostrarBoton(<?php echo  $counter ?>)">Completar Declaracion Jurada</button>
                         <div id="btn-<?php echo $counter ?>" style="display:none;" ><br>
                             <form action="validarDDJJ.php" method="POST" onsubmit="return validarCheckbox()">
                          	     <label for="temperatura">Temperatura Actual</label>
  	                             <input type="number" step="0.10" name="temperatura" required="">
  	                             <p>Fiebre en la última semana</p>
  	                                 <input type="checkbox" name="fiebre" id="checkbox1" value="si"> SI
                                     <input type="checkbox" name="fiebre" id="checkbox1" value="no">NO
                                 <p>Pérdida de gusto y/o olfato en la última semana</p>
                                     <input type="checkbox" name="gusto/olfato" id="checkbox2" value="si"> SI
                                     <input type="checkbox" name="gusto/olfato" id="checkbox2" value="no">NO
                                 <p>Dolor de garganta</p>
                                     <input type="checkbox" name="dolorG" id="checkbox3" value="si"> SI
                                     <input type="checkbox" name="dolorG" id="checkbox3" value="no">NO
                                 <p>Dificultad respiratoria</p>
                                     <input type="checkbox" name="difRes" id="checkbox4" value="si"> SI
                                     <input type="checkbox" name="difRes" id="checkbox4" value="no">NO<br><br>
                                     <input type="hidden" name="id_cliente" value="<?php echo $pasajeros['id_usuario'] ?>">
                                     <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje'] ?>">
                                     <input type="hidden" name="monto" value="<?php echo $pasajeros['total'] ?>">
                                     <input type="hidden" name="mail" value="<?php echo $pasajeros['mail'] ?>">
                                     <input type="hidden" name="ruta" value="<?php echo $viaje['origen']."-".$viaje['destino']?>">
                                     <input type="submit" name="completar" value="Enviar">
                             </form>
                             <font color="red"><p id="mensajeError"></p></font>
                         </div> 
   <?php                 $counter++;
                     }else{ //completo la DDJJ
                 	     $estadoDDJJ=mysqli_fetch_array ($resultddjjCompletada);
                 	     if ($estadoDDJJ['estado']=='rechazado') {
                 	 	     echo " <font color='red'><b><p>Pasajero Rechazado</p></b></font>"; 
                 	     }else{
                              echo " <font color='green'><b><p>Pasajero Aceptado</p></b></font>"; 
                 	     }
                     }
 	             } 
             }//while
         }// no tiene pasajeros   
         if(mysqli_num_rows($resultado)==0){ ?>
             <p>
         	     <b>No tiene un viaje asignado</b>
             </p>
<?php    }
     } 
function compararFechas($fecha_hora_salida){
     list($fecha, $horario)= explode(" ", $fecha_hora_salida);
     //echo "fecha: ".$fecha." horario: ".$horario."<br>";
     list($hora, $minuto)= explode(":", $horario);
     //echo "hora: ".$hora." minuto: ".$minuto."<br>";
     list($anio,$mes,$dia) = explode("-",$fecha);
     //echo "anio: ".$anio." mes: ".$mes." dia: ".$dia."<br>";

     $anio_dif = $anio - date("Y");
     $mes_dif =  $mes - date("m");
     $dia_dif = $dia - date("d") ;
     //echo "anio_dif".$anio_dif." mes_dif ".$mes_dif." dia_dif ".$dia_dif."<br>";

     $ddjj=false;

     date_default_timezone_set("America/Argentina/Buenos_aires");

     if (($anio_dif == 0)and($mes_dif == 0)and($dia_dif == 0)and(($hora-date("H"))<=2)) {
         $ddjj=true;
     } 	 
     return $ddjj;
}
  ?>  
</center>
</body>
</html>


