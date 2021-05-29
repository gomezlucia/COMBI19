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


	if( (empty($_POST['nombre'])) or (empty($_POST['apellido'])) or (empty($_POST['DNI'])) or (empty ($_POST['contraseña']))or  (empty ($_POST['contraseña2']))  or (empty($_POST['email'])) ){

		$mensaje="Por favor, complete todos los campos";
	}
	else{		
		 $nombreNuevo=$_POST['nombre'];
		 $apellidoNuevo=$_POST['apellido'];
		 $dniNuevo=$_POST['DNI'];
		 $emailNuevo=$_POST['email'];
		  if (!(ctype_alpha($nombreNuevo)) ){// verificacion si contiene solo caracteres alfabeticos
               $mensaje="El nombre ingresado es invalido, debe contener solo letras";
	      }
	      else{
	      	if (!(ctype_alpha($apellidoNuevo)) ){// verificacion si contiene solo caracteres alfabeticos
               $mensaje="El apellido ingresado es invalido, debe contener solo letras";
	         }
	        else{
	        	if(!(ctype_digit($dniNuevo))){
	        		$mensaje="El D.N.I ingresado es invalido, debe contener solo numeros";
	        	}
	        	else{
	        		if (($_POST['contraseña2']<>$_POST['contraseña'])) {
	        			$mensaje="Las contraseñas no fueron introducidas, o no coinciden";
	        		}
	        		else{
	        			$contraseñaNueva=$_POST['contraseña'];
	        			if (!(strlen($contraseñaNueva)) >= 8){
	        				$mensaje=$mensaje_contra;
	        			}
	        			else{
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
							if (($mayus == 0) or (($simbolo == 0) or ($nro == 0))) {
                                   $mensaje=$mensaje_contra;
                              }
                              else{
                              	$cumple1=true;
                              }
                          }
                      }
                  }
              }
          }
      }

       
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
			
			 $consulta="UPDATE usuarios SET nombre='$nombreNuevo', apellido='$apellidoNuevo', DNI='$dniNuevo', contraseña='$contraseñaNueva', mail='$emailNuevo' WHERE id_usuario='$id_usuario'";#por ahora
           $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida: acaa' .mysqli_error($link)));
          echo "<script > alert('Modificacion exitosa');window.location='verPerfilDeUsuario.php'</script>";#por ahora
         
           }

		}
	
	if((!$cumple1)or (!$cumple2)){
           	echo "<script > alert('$mensaje');window.location='modificarDatosCliente.php?'</script>";
           }


