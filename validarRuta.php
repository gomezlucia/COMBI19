<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
    session_start();
    if (!empty($_POST['origen'] and !empty($_POST['destino']))) {
     	 $origen=$_POST['origen'];
     	 $destino=$_POST['destino'];
         $id=$_POST['id'];
         if ($origen == $destino) {
         	 echo "<script > alert('No se puede dar de alta una ruta con la misma ciudad de origen y destino');window.location='modificarRuta.php?id=$id'</script>";
         }else{
         	 $modificar="UPDATE rutas SET origen='$origen',destino='$destino' WHERE id_ruta='$id'";
             
         	 $resultado= mysqli_query($link,$modificar) or die ('Consulta modificar fallida: ' .mysqli_error($link));
         	 if ($resultado) {
         	 	 echo "<script > alert('Modificacion exitosa');window.location='verListadoDeRutas.php'</script>";
         	 } 
         }
     } 
 ?>