<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
    session_start();
    if (!empty($_POST['nombre_servicio'] and !empty($_POST['precio']))) {
     	 $servicio=$_POST['nombre_servicio'];
     	 $precio=$_POST['precio'];
     	 $existeAdicional="SELECT id_servicio_adicional FROM servicios_adicionales WHERE nombre_servicio='$servicio'";
     	 $resultado= mysqli_query($link,$existeAdicional) or die ('Consulta existe Adicional fallida: ' .mysqli_error($link));
     	 if (mysqli_num_rows($resultado)!=0) {
     	 	  $_SESSION['nombre_servicio']=$servicio;
              $_SESSION['precio']=$precio;
     	 	  echo "<script > alert('El adicional ingresado ya se encontraba registrado');window.location='cargarAdicional.php?error=1'</script>";
         }else{
         		 $agregar="INSERT INTO servicios_adicionales(nombre_servicio, precio) VALUES ('$servicio','$precio')";
         		 $resultado2= mysqli_query($link,$agregar) or die ('Consulta agregar fallida: ' .mysqli_error($link));
         		 if ($resultado2) {
         		 	 echo "<script > alert('Adicional registrado exitosamente');window.location='home.php'</script>";
         		 }
         	}
         }
 ?>
