<?php
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
if ($_POST['boton']=='Iniciar Viaje') {
    inicioViaje($link,$_POST['id_viaje']);
}else{
    finViaje($link,$_POST['id_viaje']);
}
function inicioViaje($link,$id_viaje){
     $ausentes="SELECT DISTINCT cv.id_cliente FROM clientes_viajes cv WHERE cv.id_cliente not in (SELECT DISTINCT djc.id_cliente FROM clientes_viajes cv INNER JOIN ddjj_cliente djc ON (cv.id_viaje=djc.id_viaje) WHERE djc.id_viaje='$id_viaje')";
     $resultadoAusentes=mysqli_query($link,$ausentes) or die ('Consulta ausentes fallida: ' .mysqli_error($link));

     if(mysqli_num_rows($resultadoAusentes)!=0){
         while ($ausente=mysqli_fetch_array ($resultadoAusentes)) {
             $cambiarEstado="UPDATE clientes_viajes SET estado='ausente' WHERE id_viaje='$id_viaje' and id_cliente='$ausente[id_cliente]'";
             $resultadoCambiarEstado=mysqli_query($link,$cambiarEstado) or die ('Consulta cambiarEstado fallida: ' .mysqli_error($link));

             $actualizarCupo="UPDATE viajes SET cupo=cupo-1 WHERE (id_viaje= '$id_viaje') " ;
             $resultadoCupo =mysqli_query ($link, $actualizarCupo) or die ('Consulta actualizarCupo fallida : ' .mysqli_error($link));
         }
     }
 
     $pasajeros="SELECT id_cliente_viaje FROM clientes_viajes WHERE id_viaje='$id_viaje' and estado='pendiente'";
     $resultadoPasajeros =mysqli_query ($link, $pasajeros) or die ('Consulta pasajeros fallida : ' .mysqli_error($link));

     if (mysqli_num_rows($resultadoPasajeros)!=0) {
         while ($pasaje=mysqli_fetch_array ($resultadoPasajeros)) {
             $enCurso="UPDATE clientes_viajes SET estado='en curso' WHERE (id_cliente_viaje= '$pasaje[id_cliente_viaje]') " ;
             $resultadoEnCurso =mysqli_query ($link, $enCurso) or die ('Consulta enCurso fallida : ' .mysqli_error($link));
         }
     }
     $inicio="UPDATE viajes SET estadoV='en curso' WHERE (id_viaje= '$id_viaje') " ;
     $resultadoInicio =mysqli_query ($link, $inicio) or die ('Consulta inicio fallida : ' .mysqli_error($link));

      echo "<script > alert('Viaje Iniciado');window.location='proximoViaje1.php'</script>";
 }
function finViaje($link,$id_viaje){
     $pasajeros="SELECT id_cliente_viaje FROM clientes_viajes WHERE id_viaje='$id_viaje' and estado='en curso'";
     $resultadoPasajeros =mysqli_query ($link, $pasajeros) or die ('Consulta pasajeros fallida : ' .mysqli_error($link));

     if (mysqli_num_rows($resultadoPasajeros)!=0) {
         while ($pasaje=mysqli_fetch_array ($resultadoPasajeros)) {
             $finalizado="UPDATE clientes_viajes SET estado='finalizado' WHERE (id_cliente_viaje= '$pasaje[id_cliente_viaje]') " ;
             $resultadoFinalizado =mysqli_query ($link, $finalizado) or die ('Consulta finalizado fallida : ' .mysqli_error($link));
         }
     }
     $fecha_hora_llegada=date("Y-m-d H:i:s");
     $actualizarFechaFin="UPDATE viajes SET fecha_hora_llegada='$fecha_hora_llegada' WHERE (id_viaje= '$id_viaje') " ;
     $resultadoFechaFin =mysqli_query ($link, $actualizarFechaFin) or die ('Consulta actualizarFechaFin fallida : ' .mysqli_error($link));
     $fin="UPDATE viajes SET estadoV='finalizado' WHERE (id_viaje= '$id_viaje') " ;
     $resultadoFin =mysqli_query ($link, $fin) or die ('Consulta fin fallida : ' .mysqli_error($link));
      echo "<script > alert('Viaje Finalizado');window.location='proximoViaje1.php'</script>";

}
?>