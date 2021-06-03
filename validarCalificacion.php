<?php
 include "BD.php";// conectar y seleccionar la base de datos
 $link = conectar();


if ((isset($_POST['estrella'])) and (isset($_POST['comentario']))){
//  var_dump($_POST);
  if ((!empty($_POST['estrella'])) and (!empty($_POST['comentario']))) {

      $consulta1="INSERT INTO calificaciones ( puntaje, comentario) values ( '$_POST[estrella]', '$_POST[comentario]') " ;
      $result1=mysqli_query ($link, $consulta1) or die ('Consuluta query1 fallida 18: ' .mysqli_error($link));
      if ($result1){
        $id_calificacion=mysqli_insert_id($link);
      //  var_dump($_POST);

      $consulta3="INSERT INTO viaje_calificacion (id_viaje, id_calificacion, id_cliente) values ('$_POST[id_viaje]', '$id_calificacion', '$_POST[id]')";
    //    var_dump($consulta3);
      $result3=mysqli_query ($link, $consulta3) or die ('Consuluta query1 fallida 16: ' .mysqli_error($link));

      if ($result3){

      echo "<script > alert('Calificacion guardada!');window.location='verHistorialViajes.php'</script>";
}
else {
     echo "<script > alert('Para completar la calificacion es necesario puntuar el viaje y agregar un comentario!');window.location='calificarViaje.php'</script>";
  }
}
  }


}  else {
     echo "<script > alert('Para completar la calificacion es necesario puntuar el viaje y agregar un comentario!');window.location='calificarViaje.php'</script>";
  }

//}
 ?>

