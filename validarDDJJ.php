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

include("BD.php");// conectar y seleccionar la base de datos
$link = conectar();
$id_cliente=$_POST['id_cliente'];
$id_viaje=$_POST['id_viaje'];
$mailCliente=$_POST['mail'];
$ruta=$_POST['ruta'];
$monto=$_POST['monto'];

if($_POST['difRes']=='no'){
	 $dr=1;
	 	//$estado='aceptado';
}else{
	 $dr=0;
}

if($_POST['dolorG']=='no'){
	 $dg=1;	 	 	 
}else{
	 $dg=0;
}

if($_POST['gusto/olfato']=='no'){
	 $go=1; 	 
}else{
	 $go=0;
}

if($_POST['fiebre']=='no'){
	 $f=1;
}else{
     $f=0;
}

if ($_POST['temperatura']<38) {
	 $t=1;
 }else{
 	 $t=0;
 }

 if($t==1){
     if( ($f+$go+$dg+$dr)<=2){
	     $estado='rechazado';
     }else{
     	$estado='aceptado';
     }
 }else{
 	 $estado='rechazado';
 }
 echo "antes consulta";
 $consultaDDJJ="INSERT INTO declaraciones_juradas(temperatura, fiebre_ultima_sem, perdida_gusto_olfato, dolor_garganta, dificultad_respiratoria) VALUES ('$_POST[temperatura]','$f','$go','$dg','$dr')"; 
 $resultadoDDJJ=mysqli_query($link,$consultaDDJJ) or die ('ConsultaDDJJ fallida: ' .mysqli_error($link));
 $id_ddjj=mysqli_insert_id($link);

$asignarDDJJ="INSERT INTO ddjj_cliente(id_cliente, id_ddjj, id_viaje, estado) VALUES ('$id_cliente','$id_ddjj', '$id_viaje', '$estado') ";
$resultadoAsignarDDJJ=mysqli_query($link,$asignarDDJJ) or die ('Consulta asignarDDJJ fallida: ' .mysqli_error($link));

if($estado=='rechazado'){
	 $mail->setFrom('combi19@gmail.com');
     $mail->addAddress($mailCliente);
     $mail->Subject = "Pasaje a ".$ruta." devuelto";
     $mail->isHTML(true);
     $mailContent = "<p>Hola,somos COMBI-19, debido a que presenta sintomas de COVID-19 se cancelo su pasaje y se le devolvio $".$monto." (el monto total abonado).No podra comprar pasajes dentro de los proximos 15 dias.  </p>";
     $mail->Body = $mailContent;
     $mail->send();
     
     $cancelarPasaje="UPDATE clientes_viajes set estado ='devuelto total' WHERE (id_viaje= '$id_viaje') and (id_cliente = '$id_cliente')" ;
     $resultCancelacion=mysqli_query ($link, $cancelarPasaje) or die ('Consuluta cancelarPasaje fallida : ' .mysqli_error($link));

     $actualizarCupo="UPDATE viajes SET cupo=cupo-1 WHERE (id_viaje= '$id_viaje') " ;
     $resultCupo =mysqli_query ($link, $actualizarCupo) or die ('Consuluta actualizarCupo fallida : ' .mysqli_error($link));

     $tieneCovid="UPDATE usuarios set tiene_covid =1 WHERE (id_cliente = '$id_cliente')" ;
      $resultCovid =mysqli_query ($link, $tiene_covid) or die ('Consuluta tiene_covid fallida : ' .mysqli_error($link));
}

 if ($resultadoAsignarDDJJ and $resultadoDDJJ) {
 	 header("Location: /COMBI19-main/proximoViaje.php");
 }
?>
