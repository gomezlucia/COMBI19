<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
    $id_servicio_adicional=$_POST['id'];
    if ($_POST['precio'] <> 0){
    if (!empty($_POST['nombre_servicio'] and !empty($_POST['precio']))) {
     	 $servicio=$_POST['nombre_servicio'];
     	 $precio=$_POST['precio'];

     	 $existeAdicional="SELECT id_servicio_adicional FROM servicios_adicionales WHERE nombre_servicio='$servicio' and id_servicio_adicional<>'$id_servicio_adicional'";
     	 $resultado= mysqli_query($link,$existeAdicional) or die ('Consulta existe Adicional fallida: ' .mysqli_error($link));
     	 if (mysqli_num_rows($resultado)!=0) {
     	 	  echo "<script > alert('El adicional ingresado ya se encontraba registrado');window.location='modificarDatosAdicionales.php?id=$id_servicio_adicional'</script>";
         }else{
         		 $actualizar="UPDATE servicios_adicionales SET nombre_servicio='$servicio',precio='$precio' WHERE id_servicio_adicional='$id_servicio_adicional'";
         		 $resultado2= mysqli_query($link,$actualizar) or die ('Consulta agregar fallida: ' .mysqli_error($link));
         		 if ($resultado2) {
         		 	 echo "<script > alert('Servicio adicional modificado exitosamente');window.location='verListadoDeAdicionales.php'</script>";
         		 }
         	}
        }
       }else{
         echo "<script > alert('No pueden cargarse servicios adicionales gratuitos en el sistema');window.location='modificarDatosAdicionales.php?id=$id_servicio_adicional'</script>";
       }

 ?>
