<?php 
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
if (isset($_POST['id_usuario'])) {
	 $vender="INSERT INTO clientes_viajes( id_cliente, id_viaje, estado, total) VALUES ('$_POST[id_usuario]',$_POST[id_viaje],'en curso','$_POST[precio]')";
	 $resultadoVender= mysqli_query($link,$vender) or die ('Consulta vender fallida: ' .mysqli_error($link));
	 
	 $actualizarCupo="UPDATE viajes SET cupo=cupo+1 WHERE id_viaje='$_POST[id_viaje]'";
     $resultadoActualizar=mysqli_query($link,$actualizarCupo) or  die ('Consulta actualizarCupo fallida: ' .mysqli_error()); 
	 
	 if ($resultadoVender and $resultadoActualizar) {
	 	 echo "<script > alert('Pasaje vendido');window.location='proximoViaje.php'</script>";
	 }
}
?>
