<?php
 include "BD.php";// conectar y seleccionar la base de datos
 $link = conectar();
	session_start();
  $exito=false;

  $tarjeta= $_POST['numero_tarjeta'];
  $clave= $_POST['clave'];
  $fecha=$_POST['fecha'];
  $id=$_POST['id_cliente'];
  $id_tarjeta= $_POST['id_tarjeta']
//  var_dump($_POST);
  if () {  //ES UNA TARJETA nueva
      $consulta1="INSERT INTO tarjetas ( numero_tarjeta, codugo_seguridad, fecha_vencimiento) values ( '$_POST[numero_tarjeta]', '$_POST[clave]', '$_POST[fecha]') " ;
      $result1=mysqli_query ($link, $consulta1) or die ('Consuluta query1 fallida 18: ' .mysqli_error($link));

    //  $comentario= $_POST['comentario'];
      if ($result1){
        $id_tarjeta =mysqli_insert_id($link);
      //  var_dump($_POST);
      $consulta3="INSERT INTO tarjetas_clientes (id_tarjeta, id_cliente, vip) values ('$id_tarjeta', '$_POST[id_cliente]', '1')";
//        var_dump($consulta3);
      $result3=mysqli_query ($link, $consulta3) or die ('Consuluta query1 fallida 16: ' .mysqli_error($link));

      if ($result3){
        $exito=true;
}}}
else {
  $consulta5="UPDATE tarjetas_clientes SET vip='1' WHERE (id_cliente= '$id') and (id_tarjeta = '$tarjeta') " ;
    $resultado5 =mysqli_query ($link, $consulta5) or die ('Consulta alta vip fallida: ' .mysqli_error($link));

    if ($resultado5){
      $exito=true;
    }
  }
  if ($exito){
      echo "<script > alert('Felicitaciones! Ahora sos cliente VIP!');window.location='home.php'</script>";
  }else{
    echo "<script > alert('Operación fallida. Por favor intente de nuevo mas tarde');window.location='verPerfilDeUsuario.php'</script>";
  }

 ?>
