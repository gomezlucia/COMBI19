<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
   // include "classLogin.php";
	//$usuario= new usuario();
	//$usuario ->id($id);
	$id_usuario=$_POST['id'];
	$cumple1=false;
	$cumple2=true;
	$cumple3=true;
	$mensaje="";
	$mensaje_contra="La contraseña debe contar con al menos 8 caracteres, contener letras mayúsculas, letras minúsculas, poseer al menos un número y un símbolo";


	if( (!empty($_POST['nombre'])) and (!empty ($_POST['contraseña']))and  (!empty ($_POST['contraseña2']))  and (!empty($_POST['email'])) ){
		
		 $nombreNuevo=$_POST['nombre'];
		 $contraseñaNueva=$_POST['contraseña'];

		 $emailNuevo=$_POST['email'];

   #if ((ctype_alpha($nombreNuevo)) ){// verificacion si contiene solo caracteres alfabeticos

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

 # }
  # else{
   #   $mensaje='El nombre debe ser alfanumerico';
  #}
       
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
			
			 $consulta="UPDATE usuarios SET nombre_usuario='$nombreNuevo',contraseña='$contraseñaNueva', mail='$emailNuevo' WHERE id_usuario=$id_usuario";#por ahora
           $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida: ' .mysqli_error($link)));
          echo "<script > alert('Modificacion exitosa');window.location='home.php'</script>";#por ahora
         
           }

		}
	
	if((!$cumple1)or (!$cumple2)){
           	echo "<script > alert('$mensaje');window.location='modificarDatosCliente.php?'</script>";
           }

         }
          else{
     	echo "Por favor complete todos los campos";
     }
