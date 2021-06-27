<?php
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
$id_servicio_adicional=$_POST['id'];
$consulta="DELETE FROM servicios_adicionales WHERE id_servicio_adicional = '$id_servicio_adicional'";
$resultado=(mysqli_query ($link, $consulta) or die ('Consulta fallida eliminacion: ' .mysqli_error($link)));
echo "<script > alert('El adicional se elimino exitosamente');window.location='verListadoDeAdicionales.php'</script>";
?>