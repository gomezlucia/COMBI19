<?php 
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();

     $origen =filter_input(INPUT_POST, 'origen'); 
     $consulta2= "SELECT id_ruta,destino FROM rutas WHERE origen='$origen' ";
     $resultado2= mysqli_query($link,$consulta2) or die ('Consulta fallida: ' .mysqli_error($link));
     $html="<option value='0'>Seleccionar uno</option>";
     while ($datos=mysqli_fetch_array ($resultado2) ) {
	     $html.= '<option value="'.$datos["id_ruta"].'">'.$datos["destino"].'</option>';
     }
     echo $html;

?>


