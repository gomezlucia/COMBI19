<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Clase Exception */
require ('PHPMailer\src\Exception.php');

/* Clase principal de PHPMailer */
require ('PHPMailer\src\PHPMailer.php');

/* Clase SMTP, necesaria si quieres usar SMTP */
require ('PHPMailer\src\SMTP.php');

$mail = new PHPMailer(TRUE);

$mail->isSMTP();
$mail->Host = 'smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Username = '56ad90b01c46cd'; //paste one generated by Mailtrap
$mail->Password = '514ec72ab3005f' ; //paste one generated by Mailtrap
$mail->SMTPSecure = 'tls';
$mail->Port = 2525;

include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
$id_ruta_original=$_POST['id_ruta'];
$ruta=$_POST['ruta'];
$tieneViajesEnCurso=false;

$consulta0="SELECT id_viaje,fecha_hora_salida, cupo FROM viajes WHERE id_ruta= '$id_ruta_original'";
$result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));
if (mysqli_num_rows($result0) <> 0){ //la ruta esta asignada al menos a un viaje
   while($valores = mysqli_fetch_array($result0)){
       $id_viaje=$valores['id_viaje'];
       $fecha_hora_salida=$valores['fecha_hora_salida'];
       $consulta2="SELECT estado FROM clientes_viajes WHERE (id_viaje= '$id_viaje')";
       $result2=mysqli_query ($link, $consulta2) or die ('Consuluta query1 fallida 12: ' .mysqli_error());
       if ($valores['cupo'] <> 0){ //actualmente no tiene pasajes comprados
         while (($valores1 = mysqli_fetch_array($result2))){
             if ($valores1['estado']=='en curso'){
                 $tieneViajesEnCurso=true;
                 echo "<script > alert('La ruta no puede ser eliminada ya que hay un viaje en curso por dicha ruta');window.location='verListadoDeRutas.php'</script>";
             }elseif(!$tieneViajesEnCurso and $valores1['estado']=='pendiente'){ //solo con ese estado cancelo un viaje
                 $consulta4="UPDATE rutas set debaja ='1' WHERE id_ruta= '$id_ruta_original' " ;
                 $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
                 enviarMails($id_viaje,$link,$ruta,$mail,$fecha_hora_salida);
                 cancelarViaje($id_viaje,$link,$ruta,$mail);
                 echo "<script > alert('Ruta dada de baja exitosamente');window.location='verListadoDeRutas.php'</script>";
             }elseif(!$tieneViajesEnCurso){ //viaje con estado finalizado/cancelado/devuelto parcial/devuelto total doy debaja ruta
                 $consulta4="UPDATE rutas set debaja ='1' WHERE id_ruta= '$id_ruta_original' " ;
                 $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
                 echo "<script > alert('Ruta dada de baja exitosamente');window.location='verListadoDeRutas.php'</script>";
             }
         }
         $mail->send();
       }elseif(mysqli_num_rows($result2)== 0){ //nunca lo habian comprado
           borrarViaje($id_viaje, $link,$ruta,$mail);
           $consulta4="UPDATE rutas set debaja ='1' WHERE id_ruta= '$id_ruta_original' " ;
           $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
           echo "<script > alert('Ruta dada de baja exitosamente');window.location='verListadoDeRutas.php'</script>";
       }else{ //cancelaron la compra
           darDebajaViaje($link,$id_viaje);
           $consulta4="UPDATE rutas set debaja ='1' WHERE id_ruta= '$id_ruta_original' " ;
           $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
           echo "<script > alert('Ruta dada de baja exitosamente');window.location='verListadoDeRutas.php'</script>";
       }
   }
}else{ //no hay viajes con esa ruta
   $consulta1="DELETE FROM rutas WHERE id_ruta = '$id_ruta_original' ";
   $resultado1= (mysqli_query ($link, $consulta1) or die ('Consulta fallida 11: ' .mysqli_error($link)));
   echo "<script > alert('Ruta eliminada exitosamente');window.location='verListadoDeRutas.php'</script>";
}

function enviarMails($id_viaje_original,$link,$ruta,$mail,$fecha_hora_salida){
   list($fecha, $horario)= explode(" ", $fecha_hora_salida);
   $obtenerMails="SELECT c.mail from usuarios c INNER join clientes_viajes cv ON (c.id_usuario=cv.id_cliente) where cv.id_viaje='$id_viaje_original' and cv.estado='pendiente'";
   $result_mails=mysqli_query ($link, $obtenerMails) or die ('Consulta obtenerMails fallida: ' .mysqli_error($link));
   while ($mails=mysqli_fetch_array($result_mails)) {
     $mail->setFrom('combi19@gmail.com');
     $mail->addAddress($mails['mail']);
     $mail->Subject = "Viaje a ".$ruta." el dia ".$fecha." a las ".$horario." cancelado";
     $mail->isHTML(true);
     $mailContent = "<p>Hola,somos COMBI-19, debido a un problema el viaje que ha comprado fue cancelado."."<br>"."Lamentamos la molestia, le devolveremos el 100% del monto abonado .</p>";
     $mail->Body = $mailContent;  
   }
}

function cancelarViaje($id_viaje_original,$link,$ruta,$mail){
   $cancelarViajeCliente="UPDATE clientes_viajes set estado ='cancelado' WHERE id_viaje= '$id_viaje_original' and estado='pendiente' " ;
   $result_CancelarVC=mysqli_query ($link, $cancelarViajeCliente) or die ('Consulta cancelarViajeCliente fallida: ' .mysqli_error($link));  
   if ($result_CancelarVC){
     darDebajaViaje($link,$id_viaje_original);
   }
}

function darDebajaViaje($link,$id_viaje_original){
   $darDebajaViaje="UPDATE viajes SET debaja='1' WHERE (id_viaje= '$id_viaje_original') " ;
   $result_debajaV =mysqli_query ($link, $darDebajaViaje) or die ('Consulta darDebajaViaje fallida: ' .mysqli_error($link));
}

function borrarViaje($id_viaje_original, $link){
   $consulta_ServAdic="SELECT id_viaje FROM viajes_servicios_adicionales WHERE (id_viaje= '$id_viaje_original')";
   $result_ServAdic=mysqli_query ($link, $consulta_ServAdic) or die ('Consuluta consulta_ServAdic fallida: ' .mysqli_error($link));
   if ($result_ServAdic){
     while($servicios_adicionales= mysqli_fetch_array($result_ServAdic)){
         $borrar_servAdic="DELETE FROM viajes_servicios_adicionales WHERE id_viaje = '$id_viaje_original' ";
         $result_bSA= (mysqli_query ($link, $borrar_servAdic) or die ('Consulta borrar_servAdic: ' .mysqli_error($link)));
     }
   }
   $borrar_viaje="DELETE FROM viajes WHERE id_viaje =  $id_viaje_original ";
   $result_bV= (mysqli_query ($link, $borrar_viaje) or die ('Consulta borrar_viaje fallida: ' .mysqli_error($link)));   
}  ?>



