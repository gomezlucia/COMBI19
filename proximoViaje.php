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
	 <script type="text/javascript" src="seguir.js"></script>
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
<?php    if(mysqli_num_rows($resultado2)==0){ ?>
             <p>
         	     <b>Sin pasajeros</b>
             </p>
<?php    }else{ ?>
	         <h3>Pasajeros:</h3>
 <?php       while ($pasajeros=mysqli_fetch_array ($resultado2)) { ?>
           	     <p>
                     <b>Nombre:</b> <?php echo $pasajeros['nombre']." ";?>
                     <b>Apellido:</b> <?php echo $pasajeros['apellido']." ";?>
                     <b>DNI:</b> <?php echo $pasajeros['DNI'];?><br>
                 </p> 
 <?php           if(compararFechas($viaje['fecha_hora_salida'])){
                     echo "Completar DDJJ";
                 }
              }
         }   
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

