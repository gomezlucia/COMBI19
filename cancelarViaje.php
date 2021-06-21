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

   $id_viaje_original=$_POST['id_viaje'];
   $ruta=$_POST['ruta'];
   $pag=$_POST['volverA'];

   $consulta_CupoViaje="SELECT cupo FROM viajes WHERE (id_viaje= '$id_viaje_original')";
   $result_CupoViaje=mysqli_query ($link, $consulta_CupoViaje) or die ('Consuluta consulta_CupoViaje fallida: ' .mysqli_error($link));

   if ($result_CupoViaje){
     $cupoViaje = mysqli_fetch_array($result_CupoViaje);

     $consulta_Estados="SELECT id_cliente_viaje,estado FROM clientes_viajes WHERE (id_viaje= '$id_viaje_original')";
     $result_Estados=mysqli_query ($link, $consulta_Estados) or die ('Consuluta consulta_Estados fallida: ' .mysqli_error());

     $consulta_ServAdic="SELECT id_viaje FROM viajes_servicios_adicionales WHERE (id_viaje= '$id_viaje_original')";
     $result_ServAdic=mysqli_query ($link, $consulta_ServAdic) or die ('Consuluta consulta_ServAdic fallida: ' .mysqli_error($link));
     if ($result_ServAdic){ //borra los servicios adicionales,si tiene 
       while($servicios_adicionales= mysqli_fetch_array($result_ServAdic)){
            $borrar_servAdic="DELETE FROM viajes_servicios_adicionales WHERE id_viaje = '$id_viaje_original' ";
            $result_bSA= (mysqli_query ($link, $borrar_servAdic) or die ('Consulta borrar_servAdic: ' .mysqli_error($link)));
       }
     } //borra los servicios adicionales,si tiene 

     if (($cupoViaje['cupo']==0) AND (mysqli_num_rows($result_Estados)== 0)){ //NUNCA compraron el viaje
       $borrar_viaje="DELETE FROM viajes WHERE id_viaje =  $id_viaje_original ";
       $result_bV= (mysqli_query ($link, $borrar_viaje) or die ('Consulta borrar_viaje fallida: ' .mysqli_error($link)));
     } //NUNCA compraron el viaje

     else{ //lo compraron 
       while( $estados = mysqli_fetch_array($result_Estados)){ 
         if ($estados['estado']=='pendiente') {//el estado cambia solo si era pendiente
           $obtenerMails="SELECT c.mail from usuarios c INNER join clientes_viajes cv ON (c.id_usuario=cv.id_cliente) where cv.id_viaje='$id_viaje_original' AND cv.estado='pendiente'";
           $result_mails=mysqli_query ($link, $obtenerMails) or die ('Consulta obtenerMails fallida: ' .mysqli_error($link));
          
           $mails=mysqli_fetch_array($result_mails);
           $mail->setFrom('combi19@gmail.com');
           $mail->addAddress($mails['mail']);
           $mail->Subject = "Viaje a ".$ruta." cancelado";
           $mail->isHTML(true);
           $mailContent = "<p>Hola,somos COMBI-19, debido a un problema el viaje que ha comprado fue cancelado."."<br>"."Lamentamos la molestia, le devolveremos el 100% del monto abonado .</p>";
           $mail->Body = $mailContent;
          
           $cancelarViajeCliente="UPDATE clientes_viajes set estado ='cancelado' WHERE id_cliente_viaje= '$estados[id_cliente_viaje]'" ;
           $result_CancelarVC=mysqli_query ($link, $cancelarViajeCliente) or die ('Consulta cancelarViajeCliente fallida: ' .mysqli_error($link));
           if ($result_CancelarVC){ //cambio el estado a cancelado
             $darDebajaViaje="UPDATE viajes SET debaja='1' WHERE (id_viaje= '$id_viaje_original') " ;
             $result_debajaV =mysqli_query ($link, $darDebajaViaje) or die ('Consulta darDebajaViaje fallida: ' .mysqli_error($link));
           }//cambio el estado a cancelado
         } //el estado cambia solo si era pendiente
       }  
       $mail->send();
     }//lo compraron 
    
     
     if (isset($result_bV) or isset($result_debajaV)){ //se elimino o se dio de baja y cambio de estado
       echo "<script > alert('Viaje eliminado exitosamente');window.location='$pag'</script>";
     }//se elimino o se dio de baja y cambio de estado
   }else{
     echo "<script > alert('El viaje no se pudo eliminar');window.location='$pag'</script>";
   }
?>


