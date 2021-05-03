<?php
	include("BD.php");// conectar y seleccionar la base de datos
	$link=conectar();
	$mensaje1= "";
	$mensaje2="";
	$exito1= true;
	$exito2=true;

		if((!empty($_POST['patente'])) and (!empty($_POST['chasis'])) and (!empty($_POST['modelo']))and (!empty($_POST['tipo_de_combi']))){
			$patente=$_POST['patente'];
			$consulta_existe= "SELECT id_combi FROM combis WHERE patente = '".$patente."'" ;#solo la patente 
			$resultado= mysqli_query($link,$consulta_existe) or die ('Consulta fallida: ' .mysqli_error($link));#consulto por la existencia de filas con los mismos atributos 
			if(mysqli_num_rows($resultado)==0){
				$chasis=$_POST['chasis'];
				$modelo= $_POST['modelo'];
				$id_tipo_combi=$_POST['tipo_de_combi'];
				$consulta_agregar= "INSERT INTO combis (patente, chasis, modelo, id_tipo_combi) values ('".$patente."', '".$chasis."', '".$modelo."', '".$id_tipo_combi."' )";
				$result_insercion= mysqli_query ($link, $consulta_agregar) or die ('Consulta consulta_agregar fallida: ' .mysqli_error($link));
				}
			else{
					$mensaje2="Error al completar el fomulario, la patente que intenta ingresar ya esta registrada en el sistema.Por favor intente nuevamente";
			        $exito2=false;
			}
		}
		else{
			$exito1=false; //
			$mensaje1="Error al completar el fomulario, complete todos los campos.Por favor intente nuevamente";
		}

		if ( (isset($exito1)) and ($exito1==true) and ($exito2==true) ){ 
             echo "<script > alert(' Combi regitrada exitosamente ');window.location='home.php'</script>";
         } 
         else{
         	 if($exito1==false){
                 echo "<script> alert('$mensaje1');window.location='/COMBI19-main/cargarCombi.php'</script>";
                
             } else {
		         if($exito2==false){
		             echo "<script> alert('$mensaje2');window.location='/COMBI19-main/cargarCombi.php'</script>";
		         }
             }
	
         }
?>
