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
    //  echo "DALEEE";
   $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    $ruta=$_POST['ruta'];
    $id_viaje_original=$_POST['id_viaje'];
    $pagina= $_POST['pagina'];
    $consulta0="SELECT fecha_hora_salida, fecha_hora_llegada, id_ruta, precio, cupo  FROM viajes WHERE (id_viaje= '$id_viaje_original')";
    $result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));

    $consulta1="SELECT mail  FROM usuarios WHERE (id_usuario= '$id')";
    $result1=mysqli_query ($link, $consulta1) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));

     if ($result0){
        $datosViaje = mysqli_fetch_array($result0);
        $mailCliente= mysqli_fetch_array($result1);
        $pasaje_completo = compararFechas($datosViaje['fecha_hora_salida']);
        if (!($pasaje_completo)){
           $monto=$datosViaje['precio'] /2;
           $consulta4="UPDATE clientes_viajes set estado ='devuelto parcial' WHERE (id_viaje= '$id_viaje_original') and (id_cliente = '$id')" ;
        }else{
           $monto = $datosViaje['precio'];
           $consulta4="UPDATE clientes_viajes set estado ='devuelto total' WHERE (id_viaje= '$id_viaje_original') and (id_cliente = '$id')" ;
        }
         $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
         $consulta5="UPDATE viajes SET cupo=cupo-1 WHERE (id_viaje= '$id_viaje_original') " ;
         $result5 =mysqli_query ($link, $consulta5) or die ('Consuluta query4 fallida 15: ' .mysqli_error($link));
         if (isset($result4) or isset($result5)){

             $mail->setFrom('combi19@gmail.com');
             $mail->addAddress($mailCliente['mail']);

             $mail->Subject = "Pasaje a ".$ruta." cancelado";
             $mail->isHTML(true);

             if ($pasaje_completo){
               $mailContent = "<p>Hola,somos COMBI-19, debido a que cancelo el pasaje con mas de 48 horas de anticipacion se le devolvera $".$monto." (el monto total abonado) </p>";
               $mail->Body = $mailContent;

               $mail->send();
               echo "<script > alert('Pasaje cancelado exitosamente. En un momento le llegara un mail con la confirmación de la cancelación del pasaje y de la devolucion total de su pasaje');window.location='$pagina'</script>";
             }else{
               $mailContent = "<p>Hola,somos COMBI-19, debido a que cancelo el pasaje con menos de 48 horas de anticipacion se le devolvera $".$monto." (la mitad de lo abonado) </p>";
               $mail->Body = $mailContent;

               $mail->send();
               echo "<script > alert('Pasaje cancelado exitosamente. En un momento le llegara un mail con la confirmación de la cancelación del pasaje y de la devolucion de la mitad de su pasaje');window.location='$pagina'</script>";
             }
         } 
   }else{
      echo "<script > alert('El pasaje no pudo ser cancelado correctamente. Por favor, intentelo de nuevo mas tarde');window.location='$pagina'</script>";
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

   $pasaje_completo=true;
   $tothoras = 24;

   date_default_timezone_set("America/Argentina/Buenos_aires");

   if ($anio_dif == 0){
     if ($mes_dif == 0) {
       if ($dia_dif <= 2) {
         //echo $tothoras." - ".date("H")."<br>";
         $hora_resta1= $tothoras-date("H");
          //echo "hora:1 ".$hora_resta1."<br>";
         if ($dia_dif == 2){
           $hora_resta1= $hora_resta1 + $tothoras;
           //echo "hora:2 ".$hora_resta1."<br>";
         }
         $hora_suma= $hora_resta1 + $hora;
         //echo "hora:3 ".$hora_suma."<br>";
         if ($hora_suma <= 48){
           $pasaje_completo = false; //  echo 'es antes de 48 horas';
         }else{
             $pasaje_completo = true;
         }
       }else{
           $pasaje_completo = true;
       }
     }
   }

return $pasaje_completo; } ?>

