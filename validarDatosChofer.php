<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
   // include "classLogin.php";
	//$usuario= new usuario();
	//$usuario ->id($id);
	$cumple1=false;
	$cumple2=true;
	$cumple3=true;
	$mensaje="";
	$mensaje_contra="La contraseña debe contar con al menos 8 caracteres, contener letras mayúsculas, letras minúsculas, poseer al menos un número y un símbolo";


	if( (!empty($_POST['nombre'])) and (!empty ($_POST['contraseña']))and  (!empty ($_POST['contraseña2'])) and (!empty ($_POST['legajo'])) and (!empty($_POST['email'])) ){
		
		 $nombreNuevo=$_POST['nombre'];
		 $contraseñaNueva=$_POST['contraseña'];
		 $legajoNuevo=$_POST['legajo'];
		 $emailNuevo=$_POST['email'];

   if ((ctype_alpha($nombreNuevo)) ){// verificacion si contiene solo caracteres alfabeticos

        if (($_POST['contraseña2']==$_POST['contraseña'])) {
						$contraseñaNueva= $_POST['contraseña'];
						if ((strlen($contraseñaNueva)) >= 8){
							$mayus= 0;
							$simbolo= 0;
							$nro= 0;
							for ($i=0; $i<strlen($contraseñaNueva);$i++){
								$caracter= $contraseñaNueva[$i];
								if (ctype_upper($caracter)){
									$mayus ++;
								} elseif (!ctype_alnum ($caracter)) {
									$simbolo ++;
								} elseif (ctype_digit($caracter)){
									$nro ++;
								}
							}

							 if (($mayus <> 0) and (($simbolo <> 0) and ($nro <> 0))) {
                                     $cumple1=true;
									}
							 else {
								$mensaje=$mensaje_contra;
							}
						} else {
							$mensaje= $mensaje_contra;
						}
					 } else {
						$mensaje="Las contraseñas no fueron introducidas, o no coinciden";
					}

  }
   else{
      $mensaje='El nombre debe ser alfanumerico';
  }
       $id_usuario=intval($_POST['id']);
       if($cumple1){
       	 $consultaEmail= ("SELECT mail FROM usuarios WHERE id_usuario<>$id_usuario");//hacer consulta
		$resultEmail= mysqli_query ($link, $consultaEmail) or die ('Consulta fallida 83' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($resultEmail)){
			if ($_POST['email'] == $usuarioTabla['mail']){
				$cumple2= false;
				echo $cumple2;
				$mensaje="El email ingresado ya tiene una cuenta asociada";
			}
		}
		if($cumple2){
			$consulta_legajo= ("SELECT legajo FROM usuarios WHERE id_usuario<>$id_usuario");//hacer consulta
		$resultLegajo= mysqli_query ($link, $consulta_legajo) or die ('Consulta fallida 170' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($resultLegajo)){
			if ($_POST['legajo'] == $usuarioTabla['legajo']){
				$cumple3= false;
				$mensaje="Ya existe un usuario con ese legajo por favor ingrese otro";
			}
		}
		if($cumple3){
			 $consulta="UPDATE usuarios SET nombre='$nombreNuevo',contraseña='$contraseñaNueva',legajo='$legajoNuevo', mail='$emailNuevo' WHERE id_usuario=$id_usuario";#por ahora
           $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida: ' .mysqli_error($link)));
          echo "<script > alert('Modificacion exitosa');window.location='verListadoDeChoferes.php'</script>";#por ahora
           }
           }

		}
	
	if((!$cumple1)or (!$cumple2) or (!$cumple3)){
           	echo "<script > alert('$mensaje');window.location='verListadoDeChoferes.php'</script>";
           }
}


     else{
     	echo "<script > alert('Por favor complete todos los campos');window.location='verListadoDeChoferes.php'</script>";
     }