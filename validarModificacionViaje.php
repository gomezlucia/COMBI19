<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
	 if(!empty ($_POST['precio'])) {	
        
		 $pag=$_POST['volverA'];
		 $ruta=$_POST['rutas'];
		 $precioNuevo=$_POST['precio'];
		 $id_viaje=$_POST['id_viaje'];
		 if( (!empty($_POST['choferes'])) and  (!empty($_POST['combis'])) ){
		  	 $id_chofer=$_POST['choferes'];
			 $id_combi=$_POST['combis'];
			 $consuluta="UPDATE viajes SET id_chofer='$id_chofer',id_combi='$id_combi',id_ruta='$ruta',precio='$precioNuevo' WHERE id_viaje='$id_viaje'";
			 $resultado= (mysqli_query ($link, $consuluta) or die ('Consulta fallida: ' .mysqli_error($link)));
			 echo "<script > alert('Modificacion exitosa');window.location='$pag'</script>;";

		 }else{ //echo "no se modifico el chofer Y la combi";
		 	 if  (!empty($_POST['choferes'])) {
		 		 $id_chofer=$_POST['choferes'];
			     $consuluta="UPDATE viajes SET id_chofer='$id_chofer',id_ruta='$ruta',precio='$precioNuevo' WHERE id_viaje='$id_viaje'";
			     $resultado= (mysqli_query ($link, $consuluta) or die ('Consulta fallida: ' .mysqli_error($link)));
			      echo "<script > alert('Modificacion exitosa');window.location='$pag'</script>;";

		 	 }else{ //echo "no se modifico el chofer";
		 	 	 if (!empty($_POST['combis'])) {
		 	 	     $id_combi=$_POST['combis'];
			         $consuluta="UPDATE viajes SET id_combi='$id_combi',id_ruta='$ruta',precio='$precioNuevo' WHERE id_viaje='$id_viaje'";
			         $resultado= (mysqli_query ($link, $consuluta) or die ('Consulta fallida: ' .mysqli_error($link)));	

			          echo "<script > alert('Modificacion exitosa');window.location='$pag'</script>;";
		 	 	 }else{//echo "no se modifico el chofer ni la combi";

		 	 	 $consuluta="UPDATE viajes SET id_ruta='$ruta',precio='$precioNuevo' WHERE id_viaje='$id_viaje'";
		 	 	 $resultado= (mysqli_query ($link, $consuluta) or die ('Consulta fallida: ' .mysqli_error($link)));	
		 	 	  echo "<script > alert('Modificacion exitosa');window.location='$pag'</script>;";	
		 	 	 }
		 	 }
		 }
	 }else{
		echo "Por favor, no deje ningun campo en blanco.";
	}
