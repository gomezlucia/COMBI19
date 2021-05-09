<?php
	include("BD.php");// conectar y seleccionar la base de datos
	$link = conectar();
	session_start();
	     if ( (isset($_POST['form'])) and ($_POST['form']=='segundo_form') ){
	     	 $Consulta="INSERT INTO viajes( id_chofer, id_combi, origen, destino, fecha_hora_salida, fecha_hora_llegada, precio, debaja, cupo) VALUES ('$_POST[choferes]','$_POST[combis]','$_POST[origen]','$_POST[destino]','$_POST[fecha_hora_salida]','$_POST[fecha_hora_llegada]','$_POST[precio]',0,0)";
	     	  $Resultado=mysqli_query($link,$Consulta) or die ('Consulta fallida: ' .mysqli_error($link));
	     	 $id_viaje=mysqli_insert_id($link); 
	     	  if ($Resultado) {
	     	  	 if (isset($_POST['servicios_adicionales'])) {
	     	  	 	 foreach ($_POST['servicios_adicionales'] as $s) {
	     	 	     $consulta="INSERT INTO viajes_servicios_adicionales( id_viaje, id_servicio_adicional) VALUES ('$id_viaje','$s')";
	     	 	     $resultado=mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
	     	 	     
	     	 	     }
	     	  	 }
	     	  	
	     	  echo "<script > alert('Viaje cargado exitosamente');window.location='home.php'</script>";
	     	 }
	     }elseif ((!empty($_POST['origen'])) and (!empty($_POST['destino'])) and (!empty($_POST['fecha_hora_salida']))and (!empty($_POST['fecha_hora_llegada'])) and (!empty($_POST['precio'])) ) {
	     	 $f_s=$_POST['fecha_hora_salida'];
		     $f_l=$_POST['fecha_hora_llegada'];
             $fecha_hora_salida=strftime('%Y-%m-%d %H:%M:%S', strtotime($f_s));
             $fecha_hora_llegada=strftime('%Y-%m-%d %H:%M:%S', strtotime($f_l));
			 $hayChoferes= "SELECT id_usuario,nombre,apellido FROM usuarios WHERE tipo_usuario='chofer'and id_usuario not in (SELECT id_chofer from viajes WHERE  ('$fecha_hora_salida' BETWEEN fecha_hora_salida and fecha_hora_llegada) or ('$fecha_hora_llegada' BETWEEN fecha_hora_salida and fecha_hora_llegada))"; 
			 $resultado= mysqli_query($link,$hayChoferes) or die ('Consulta fallida: ' .mysqli_error($link)); 
			 if(mysqli_num_rows($resultado)==0){
			     echo "<script > alert('No hay choferes disponibles para esas fechas y horas');window.location='cargarViaje.php'</script>";
             }else{ //hay choferes disponibles
				 $hayCombis="SELECT id_combi,patente,chasis,modelo FROM combis WHERE id_combi not in(SELECT id_combi from viajes WHERE ('$fecha_hora_salida' BETWEEN fecha_hora_salida and fecha_hora_llegada) or ('$fecha_hora_llegada' BETWEEN fecha_hora_salida and fecha_hora_llegada))";
			     $resultado= mysqli_query($link,$hayCombis) or die ('Consulta fallida: ' .mysqli_error($link));
			     if(mysqli_num_rows($resultado)==0){
				     echo "<script > alert('No hay combis disponibles para esas fechas y horas');window.location='cargarViaje.php'</script>";
     	         }else{ //hay choferes y combis disponibles
	     		  	 $error=false;
		    	   	 $_SESSION['origenF'] = $_POST['origen'];
		             $_SESSION['destino_formulario'] = $_POST['destino'];
                     $_SESSION['fecha_hora_salida_formulario'] = $f_s;
                     $_SESSION['fecha_hora_llegada_formulario'] = $_POST['fecha_hora_llegada'];
                     $_SESSION['precio_formulario'] = $_POST['precio'];
		             header ("Location: /COMBI19-main/cargarViaje.php?error=$error");
	             }
		     }
         }
?>