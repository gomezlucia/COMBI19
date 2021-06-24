<?php 
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
include "menu.php";
date_default_timezone_set("America/Argentina/Buenos_aires");
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
         function mostrarMotivo(frm) {
             var x = document.getElementById("motivo");
             var c = document.getElementById("cancelarAcccion");
             if (x.style.display === "none") {
                  x.style.display = "block";
                  c.style.display = "block";
              } else {
                 x.style.display = "none";
                  var opcion = confirm('Si cancela el viaje se le devolvera el 100% del monto abonado a los clientes correspondientes¿Estas seguro que desea continuar?');
                 if(opcion == true){
                     frm.submit();
                 }else{
                     return false;
                 }
             }
         }
         function ocultarMotivo(){
             var x = document.getElementById("motivo");
             var c = document.getElementById("cancelarAcccion");
             x.style.display = "none";
             c.style.display = "none";
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
     $proximoViaje= "SELECT r.destino,r.origen,v.id_viaje,v.fecha_hora_salida,v.fecha_hora_llegada,v.precio,v.cupo,v.estadoV,c.patente,tc.asientos FROM rutas r INNER JOIN viajes v ON (r.id_ruta=v.id_ruta) INNER JOIN combis c ON (v.id_combi=c.id_combi) INNER JOIN tipos_combi tc ON (c.id_tipo_combi=tc.id_tipo_combi) WHERE v.debaja=0 and v.fecha_hora_llegada=(SELECT MIN(v1.fecha_hora_llegada) FROM viajes v1 WHERE v1.fecha_hora_llegada>now() and (v1.estadoV<>'finalizado') and v1.id_chofer='$id')" ;
    // var_dump($proximoViaje);
     $resultadoProximoViaje= mysqli_query($link,$proximoViaje) or die ('Consulta proximoViaje fallida: ' .mysqli_error($link));
     if (mysqli_num_rows($resultadoProximoViaje)!=0){
         $viaje=mysqli_fetch_array ($resultadoProximoViaje);
         $obtenerPasajeros="SELECT cv.id_cliente,u.nombre,u.apellido,u.mail,u.DNI,u.tiene_covid,cv.id_cliente_viaje,cv.id_viaje,cv.estado,cv.estado,cv.total FROM usuarios u INNER JOIN clientes_viajes cv ON (u.id_usuario=cv.id_cliente) INNER JOIN viajes v on (cv.id_viaje=v.id_viaje and u.id_usuario=cv.id_cliente ) LEFT JOIN ddjj_cliente djc ON (v.id_viaje=djc.id_viaje and u.id_usuario=djc.id_cliente) WHERE v.id_viaje='$viaje[id_viaje]'";
         $resultadoObtenerPasajeros= mysqli_query($link,$obtenerPasajeros) or die ('Consulta obtenerPasajeros fallida: ' .mysqli_error($link)); ?>
         
         <h1>Proximo viaje</h1>
         <p>
             <b>Origen:</b> <?php echo $viaje['origen'];?><br>
             <b>Destino:</b> <?php echo $viaje['destino'];?><br>
             <b>Combi:</b> <?php echo $viaje['patente'];?><br>
             <b>Fecha y hora de salida:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($viaje['fecha_hora_salida']));?><br>
             <b>Fecha y hora de llegada:</b> <?php echo  date("d/m/Y  H:i:s", strtotime($viaje['fecha_hora_llegada']));?>
         </p> 

<?php        //CANCELAR VIAJE

             if($viaje['estadoV']!='en curso'){ ?>
                 <form action="cancelarViaje.php" method="POST">
                     <div id="motivo" style="display:none;">
                         <textarea name="motivo" cols="50" rows="6" required="" placeholder="Escriba su motivo de cancelacion" ></textarea>
                     </div>
                     <input type="submit"  name="cancelar" value="Cancelar Viaje" onclick="mostrarMotivo(this.form)"><br><br>
                     <input type="submit" id="cancelarAcccion" style="display:none;" name="cancelar" value="Cancelar" onclick="ocultarMotivo()">
                     <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje'] ?>">
                     <input type="hidden" name="ruta" value="<?php echo $viaje['origen']."-".$viaje['destino'] ?>">
                     <input type="hidden" name="volverA" value="proximoViaje.php">
                 </form>                  
 <?php   }      

             //CANCELAR VIAJE

             //BOTONES DE INICIO Y FIN DE VIAJE

             if( ($viaje['fecha_hora_salida']<=date("Y-m-d H:i:s")) and $viaje['estadoV']=='pendiente' ) { ?>
                 <form action="inicioFinViaje.php" method="POST">
                     <input type="submit"  name="boton" value="Iniciar Viaje" >
                     <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje'] ?>">
                 </form>         
 <?php       }
             if ($viaje['estadoV']=='en curso') { ?>
                 <form action="inicioFinViaje.php" method="POST">
                     <input type="submit"  name="boton" value="Finalizar Viaje">
                     <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje'] ?>">
                 </form> 
 <?php       }

             //BOTONES DE INICIO Y FIN DE VIAJE
         
         if(mysqli_num_rows($resultadoObtenerPasajeros)==0){ //no tiene pasajeros ?>
             <p><b>Sin pasajeros</b></p>
<?php    }else{ //tiene pasajeros 
             $counter = 0;  ?>
           <h3>Pasajeros:</h3> 
<?php        while ($pasajeros=mysqli_fetch_array ($resultadoObtenerPasajeros)) { 
                 $ddjjCompletada="SELECT estado FROM ddjj_cliente WHERE id_viaje='$viaje[id_viaje]' and id_cliente='$pasajeros[id_cliente]'";
                 $resultddjjCompletada=mysqli_query($link,$ddjjCompletada) or die ('Consulta ddjjCompletada fallida: ' .mysqli_error($link));
                 if($pasajeros['estado']=='pendiente' or $pasajeros['estado']=='ausente' or( mysqli_num_rows($resultddjjCompletada)!=0 )){ //datos del pasajero ?>
                     <p>
                         <b>Nombre:</b> <?php echo $pasajeros['nombre']." ";?>
                         <b>Apellido:</b> <?php echo $pasajeros['apellido']." ";?>
                         <b>DNI:</b> <?php echo $pasajeros['DNI'];?><br>
                     </p> 
<?php            } //datos del pasajero
                 
                 //SOLO SE MUESTRA EL FORMULARIO SI NO LO COMPLETO Y SIGUE TENIENDO EL PASAJE PENDIENTE 
                 if(mysqli_num_rows($resultddjjCompletada)==0 and $pasajeros['estado']=='pendiente' and compararFechas($viaje['fecha_hora_salida']) ){ 
?>                   <button onclick="mostrarBoton(<?php echo  $counter ?>)">Completar Declaracion Jurada</button>
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
                             <input type="hidden" name="id_cliente" value="<?php echo $pasajeros['id_cliente'] ?>">
                             <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje'] ?>">
                             <input type="hidden" name="monto" value="<?php echo $pasajeros['total'] ?>">
                             <input type="hidden" name="mail" value="<?php echo $pasajeros['mail'] ?>">
                             <input type="hidden" name="ruta" value="<?php echo $viaje['origen']."-".$viaje['destino']?>">
                             <input type="submit" name="completar" value="Enviar">
                         </form>
                         <font color="red"><p id="mensajeError"></p></font>
                     </div> 
<?php                $counter++;
                 }elseif($pasajeros['estado']=='ausente'){ //
                         echo " <font color='red'><b><p>Pasajero Ausente</p></b></font>"; 
                 }elseif(mysqli_num_rows($resultddjjCompletada)!=0){ 
                     $estadoDDJJ=mysqli_fetch_array ($resultddjjCompletada);
                     if ($estadoDDJJ['estado']=='rechazado') {
                         echo " <font color='red'><b><p>Pasajero Rechazado</p></b></font>"; 
                     }else{
                         echo " <font color='green'><b><p>Pasajero Aceptado</p></b></font>"; 
                     }  
                 }
             } //while pasajeros 
?>
<?php    }//tiene pasajeros             

         }else{ ?>
             <H2><b>No tiene un viaje asignado</b></H2>
<?php    }
     
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

     if (($anio_dif == 0)and($mes_dif == 0)and($dia_dif == 0)and(($hora-date("H"))<=2)) {
         $ddjj=true;
     }   
     return $ddjj;
} 
?>
</center>
</body>
</html>







