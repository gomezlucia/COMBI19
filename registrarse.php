<?php
	include("BD.php");// conectar y seleccionar la base de datos
	$link = conectar();
	$cumple= false;
	$cumple1= false;
	$mensaje= "";
	$contra_correcta= true;

	function edad($edad){
   list($anio,$mes,$dia) = explode("/",$edad);
    $anio_dif = date("Y") - $anio;
    $mes_dif = date("m") - $mes;
    $dia_dif = date("d") - $dia;
     if ($dia_dif < 0 || $mes_dif < 0) { $anio_dif--; } return $anio_dif; }

  if ($_POST['tipo_usuario']=='cliente'){

	if ((isset ($_POST['nombre'])) and (isset ($_POST['apellido']))) {
		$nombre= $_POST['nombre'];
		$apellido= $_POST['apellido'];
		if((!empty($_POST['nombre'])) and (!empty($_POST['apellido'])) and (!empty($_POST['nombre_usuario'])) and (!empty($_POST['mail'])) and (!empty($_POST['contraseña'])) and (!empty($_POST['fecha_nacimiento']) and
    (!empty($_POST['DNI'])) and (!empty($_POST['clave1'])))){
		if ((ctype_alpha($nombre)) and (ctype_alpha($apellido))){// verificacion si contiene solo caracteres alfabeticos
			if (isset ($_POST['nombre_usuario'])){
				$usuario= $_POST['nombre_usuario'];
//				if ((ctype_alnum($usuario))) {// alfanumerico y 6 caracteres
					if ((isset ($_POST['contraseña'])) and (isset ($_POST['clave1'])) and ($_POST['clave1']==$_POST['contraseña'])) {
						$contra= $_POST['contraseña'];
						if ((strlen($contra)) >= 8){
							$mayus= 0;
							$simbolo= 0;
							$nro= 0;
							for ($i=0; $i<strlen($contra);$i++){
								$caracter= $contra[$i];
								if (ctype_upper($caracter)){
									$mayus ++;
								} elseif (!ctype_alnum ($caracter)) {
									$simbolo ++;
								} elseif (ctype_digit($caracter)){
									$nro ++;
								}
							}

							 if (($mayus <> 0) and (($simbolo <> 0) or ($nro <> 0))) {

										if(isset($_POST['mail'])){

                      if((ctype_digit($_POST['DNI'])) and ((strlen($_POST['DNI'])) >= 7) and ((strlen($_POST['DNI'])) < 9)){

												if ( edad($_POST['fecha_nacimiento']) >= 18){
											  $cumple1= true;
											}
											else{
												$mensaje='Debes ser mayor de edad para registrarte en esta pagina';
											}
                       }
                       else{
                         $mensaje="DNI invalido. Por favor intente de nuevo";
                       }
										}
										else{
										$mensaje="debe introducir un mail";
										}
									}
							 else {
									$contra_correcta= false;
							}
						} else {
							$contra_correcta= false;
						}
					 } else {
						$contra_correcta= false;
					}
//				} else {
//					$mensaje="ingrese";
//				}
			} else {
				$mensaje= "Introduzca un nombre de usuario";
			}
		} else {
			$mensaje= "El nombre y el apellido deben ser alfanumericos";
		}
		} else{
			$mensaje="Complete todos los campos";
		}
	} else {
		$mensaje= "Introduzca su nombre y apellido";
	}
}
////////////////////SI ES CHOFER SE COMPLETRA EL OTRO REGISTRO
else{
  if ((isset ($_POST['nombre'])) and (isset ($_POST['apellido']))) {
    $nombre= $_POST['nombre'];
    $apellido= $_POST['apellido'];
    if((!empty($_POST['nombre'])) and (!empty($_POST['apellido'])) and (!empty($_POST['nombre_usuario'])) and (!empty($_POST['mail'])) and (!empty($_POST['legajo'])) and (!empty($_POST['contraseña'])) and
		(!empty($_POST['clave1']))){
    if ((ctype_alpha($nombre)) and (ctype_alpha($apellido))){// verificacion si contiene solo caracteres alfabeticos
      if (isset ($_POST['nombre_usuario'])){
        $usuario= $_POST['nombre_usuario'];
//				if ((ctype_alnum($usuario))) {// alfanumerico y 6 caracteres
          if ((isset ($_POST['contraseña'])) and (isset ($_POST['clave1'])) and ($_POST['clave1']==$_POST['contraseña'])) {
            $contra= $_POST['contraseña'];
            if ((strlen($contra)) >= 8){
              $mayus= 0;
              $simbolo= 0;
              $nro= 0;
              for ($i=0; $i<strlen($contra);$i++){
                $caracter= $contra[$i];
                if (ctype_upper($caracter)){
                  $mayus ++;
                } elseif (!ctype_alnum ($caracter)) {
                  $simbolo ++;
                } elseif (ctype_digit($caracter)){
                  $nro ++;
                }
              }

              if (($mayus <> 0) and (($simbolo <> 0) and ($nro <> 0))) {
								if(isset($_POST['mail'])){
									if(isset($_POST['legajo'])){
                  $cumple1= true;
								    }
										else{
											$mensaje= "Introduzca legajo del chofer";
										}
								}
								else{
									$mensaje="Introduzca email";
								}
                    }
               else {
                $contra_correcta= false;
              }
            } else {
              $contra_correcta= false;
            }
           } else {
            $contra_correcta= false;
          }
//				} else {
//					$mensaje="ingrese";
//				}
      } else {
        $mensaje= "Introduzca un nombre de usuario";
      }
    } else {
      $mensaje= "El nombre y el apellido deben ser alfanumericos";
    }
    } else{
      $mensaje="Complete todos los campos";
    }
  } else {
    $mensaje= "Introduzca su nombre y apellido";
  }
}

if ($contra_correcta == false ){
	$mensaje= "La contraseña debe contar con al menos 8 caracteres, contener letras mayúsculas, letras minúsculas, poseer al menos un número y un símbolo";
}


	$cumple2=true;// verificacion de la existencia del nombre de usuario
	if ($cumple1 == true){
		$query25= ("SELECT nombre_usuario FROM usuarios");//hacer consulta
		$result25= mysqli_query ($link, $query25) or die ('Consulta fallida 70' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($result25)){
			if ($usuario == $usuarioTabla['nombre_usuario']){
				$cumple2= false;
				$mensaje="El nombre de usuario ya existe, por favor elija otro";
			}
		}
	}
	if (($cumple1 == true) and ($_POST['tipo_usuario'] <> 'cliente')){
		$query25= ("SELECT legajo FROM usuarios");//hacer consulta
		$result25= mysqli_query ($link, $query25) or die ('Consulta fallida 170' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($result25)){
			if ($_POST['legajo'] == $usuarioTabla['legajo']){
				$cumple2= false;
				$mensaje='Ya existe un usuario con ese legajo por favor ingrese otro';
			}
		}
	}

	if ($cumple1 == true){
        $query27= ("SELECT mail FROM usuarios");//hacer consulta
        $mail= $_POST['mail'];
		$result27= mysqli_query ($link, $query27) or die ('Consulta fallida 183' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($result27)){
			if ($mail == $usuarioTabla['mail']){
				$cumple2= false;
				$mensaje="El mail ingresado ya tiene una cuenta asociada";
			}
		}
	}


	if (($cumple1== true) and ($cumple2== true)){
    if ($_POST['tipo_usuario']=='cliente'){
		$query31= "INSERT INTO usuarios (apellido, nombre, mail, nombre_usuario, contraseña, fecha_nacimiento, DNI, tipo_usuario) values ('$_POST[apellido]', '$_POST[nombre]', '$_POST[mail]', '$_POST[nombre_usuario]', '$_POST[contraseña]', '$_POST[fecha_nacimiento]','$_POST[DNI]', 'cliente' )";//falta subir la imagen y su tipo
		$result31= mysqli_query ($link, $query31) or die ('Consuluta query1 fallida 163: ' .mysqli_error($link));
		$exito= true;
	}
  else{
    $query31= "INSERT INTO usuarios (apellido, nombre, nombre_usuario, mail, legajo, contraseña, tipo_usuario, debaja) values ('$_POST[apellido]', '$_POST[nombre]', '$_POST[nombre_usuario]', '$_POST[mail]', '$_POST[legajo]', '$_POST[contraseña]', 'chofer' , '0')";//falta subir la imagen y su tipo
		$result31= mysqli_query ($link, $query31) or die ('Consuluta query1 fallida 168: ' .mysqli_error($link));
		$exito= true;
  }
}


 if ((isset($exito)) and (($exito==true))){
	 if($_POST['tipo_usuario']=='cliente'){
         echo "<script > alert('Usuario regitrado exitosamente');window.location='inicioSesion.php'</script>";
     }
     else{
     	 echo "<script > alert('Usuario regitrado exitosamente');window.location='home.php'</script>";
     }
 }else {
	 if($_POST['tipo_usuario']=='cliente'){
         echo "<script > alert('Error al completar el formulario.'+'$mensaje');window.location='registroUsuario.php'</script>";
     }else{
     	 echo "<script > alert('Error al completar el formulario.'+'$mensaje');window.location='registrarChoferes.php'</script>";
     }
  }

 ?>
