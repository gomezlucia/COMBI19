<?php

    include "BD.php";// conectar y seleccionar la base de datos
    //  echo "DALEEE";
   $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);

    $id_viaje_original=$_POST['id_viaje'];
    $pagina= $_POST['pagina'];
    $consulta0="SELECT fecha_hora_salida, fecha_hora_llegada, id_ruta, precio, cupo  FROM viajes WHERE (id_viaje= '$id_viaje_original')";
    $result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));
    $consulta1="SELECT mail  FROM usuarios WHERE (id_usuario= '$id')";
    $result1=mysqli_query ($link, $consulta1) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));
    echo '1';
    if ($result0){
        $valores = mysqli_fetch_array($result0);
        $valores1= mysqli_fetch_array($result1);
        echo '2';
        $pasaje_completo = compararFechas($valores['fecha_hora_salida']);
        echo 'sali de la funcion';
        echo $pasaje_completo;

        if (!($pasaje_completo)){
        $monto=$valores['precio'] /2;}
        else{
          $monto = $valores['precio'];
        }
        echo 'dddddd';
        echo $monto;

        $to = $valores1['mail'];
        $subject = "Cancelacion de pasaje en  COMBI 19";
        $message = "
              <html>
                <head>
               <title>Cancelacion de pasaje </title>
                </head>
                <body>
                <h1>Esto es un H1</h1>
                <p>Esto es un párrafo en HTML</p>
                </body>
                </html>";

      //  mail($to, $subject, $message);

        $consulta4="UPDATE clientes_viajes set estado ='devuelto' WHERE (id_viaje= '$id_viaje_original') and (id_cliente = '$id')" ;
        $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));

        $cupo_nuevo=$valores['cupo'] - 1;

        $consulta5="UPDATE viajes SET cupo='$cupo_nuevo' WHERE (id_viaje= '$id_viaje_original') " ;
        $result5 =mysqli_query ($link, $consulta5) or die ('Consuluta query4 fallida 15: ' .mysqli_error($link));
      //  echo "result0";
        //  echo "result0 cupo 0";


    if (($result4) or ($result5)){

      echo "<script > alert('Pasaje eliminado exitosamente. En un momento le llegara un mail con la confirmación de la cancelación');window.location='$pagina'</script>";

        }
}else{
echo "<script > alert('El pasaje no pudo ser cancelado correctamente. Por favor, intentelo de nuevo mas tarde');window.location='$pagina'</script>";
}
//return $exito;
function compararFechas($fecha_hora_salida){
  echo 'empieza funcion';
        list($fecha, $horaio)= explode(" ", $fecha_hora_salida);
        echo $fecha, $horaio, '111111';
        list($hora, $minuto)= explode(":", $horaio);
        echo $hora, $minuto, '22222222';
        list($anio,$mes,$dia) = explode("-",$fecha);
        echo $anio, $mes, $dia, '333333333';
        $anio_dif = date("Y") - $anio;
        $mes_dif = date("m") - $mes;
        $dia_dif = date("d") - $dia;
        echo 'paso cuentas';
    //    $hora_dif = date("H") - $hora;
        $tothoras = 24;
        if ($anio_dif == 0){
            echo '4';
          if ($mes_dif == 0) {
            echo '5';
            if ($dia_dif <= 2) {
              echo '6';
              $hora_resta1= $tothoras-date("H");
              if ($dia_dif == 2){
                  $hora_resta1= $hora_resta1 + $tothoras;
              }
            $hora_suma= $hora_resta1 + $hora;
            if ($hora_suma <= 48){
              $pasaje_completo = false;
              echo 'es antes de 48 horas';
            }
            else{
              $pasaje_completo = true;
            }
          }else{
            $pasaje_completo = true;
          }
         }else{
           $pasaje_completo == true;
         }
       }else{
         $pasaje_completo ==true;
       }
    return $pasaje_completo;
}

?>
