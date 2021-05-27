<?php
    include("BD.php");// conectar y seleccionar la base de datos
    $link=conectar();
    session_start();
    if (!empty($_POST['origen'] and !empty($_POST['destino']))) {
     	 $origen=$_POST['origen'];
     	 $destino=$_POST['destino'];
     	 $existeRuta="SELECT id_ruta FROM rutas WHERE origen='$origen' and destino='$destino'";
     	 $resultado= mysqli_query($link,$existeRuta) or die ('Consulta existeRuta fallida: ' .mysqli_error($link));
     	 if (mysqli_num_rows($resultado)!=0) {
     	 	  $_SESSION['origen_formulario']=$origen;
              $_SESSION['destino_formulario']=$destino;
     	 	  echo "<script > alert('La ruta ya se encontraba registrada');window.location='cargarRuta.php?error=1'</script>";
         }else{
         	if ($origen == $destino) {
         		 $_SESSION['origen_formulario']=$origen;
                 $_SESSION['destino_formulario']=$destino;
         		 echo "<script > alert('No se puede dar de alta una ruta con la misma ciudad de origen y destino');window.location='cargarRuta.php?error=1'</script>";
         	 }else{
         		 $agregar="INSERT INTO rutas(origen, destino) VALUES ('$origen','$destino')";
         		 $resultado= mysqli_query($link,$agregar) or die ('Consulta agregar fallida: ' .mysqli_error($link));
         		 if ($resultado) {
         		 	 echo "<script > alert('Ruta registrada exitosamente');window.location='home.php'</script>";
         		 } 
         	}
         }
     	 
     } 
 ?>