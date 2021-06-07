<?php

include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
include "cancelarViaje.php";
echo '1llamar';

$id_viaje_original=$_POST['id_viaje'];
echo $id_viaje_original,'id viaje';
$exito = cancelarViaje($id_viaje_original);
echo '2llamar';
if ($exito== true){
  echo "<script > alert('Viaje eliminado exitosamente');window.location='listarViajes.php'</script>";
}else{
  echo "<script > alert('El viaje no se pudo eliminar');window.location='listarViajes.php'</script>";
}
 ?>
