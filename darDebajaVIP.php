<?php

include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
$id_cliente= $_POST['id'];


$darDebajaVip="UPDATE usuarios SET vip='0' WHERE (id_usuario= '$id_cliente') " ;
$result_debajaV =mysqli_query ($link, $darDebajaVip) or die ('Consulta darDebajaVip fallida: ' .mysqli_error($link));

if ($result_debajaV){
  $darDebajaTarjetaVip="UPDATE tarjetas_clientes SET vip='0' WHERE (id_cliente= '$id_cliente') " ;
  $result_debajaTarjetaV =mysqli_query ($link, $darDebajaTarjetaVip) or die ('Consulta darDebajaTarjetaVip fallida: ' .mysqli_error($link));
  if ($result_debajaTarjetaV){
    echo "<script > alert('Membresia dada de baja correctamente');window.location='verPerfilDeUsuario.php'</script>";
  }else{
    echo "<script > alert('Ha surgido un problema.Por favor intente de nuevo mas tarde');window.location='verPerfilDeUsuario.php'</script>";
  }
}else{
  echo "<script > alert('Ha surgido un problema.Por favor intente de nuevo mas tarde');window.location='verPerfilDeUsuario.php'</script>";
}
?>
