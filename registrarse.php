<?php
	include("BD.php");// conectar y seleccionar la base de datos
	$link = conectar();
	$cumple= false;
	$cumple1= false;
	$mensaje= "";
	
	if ((isset ($_POST['nombre'])) and (isset ($_POST['apellido']))) {
		$nombre= $_POST['nombre'];
		$apellido= $_POST['apellido'];
		if((!empty($_POST['nombre'])) and (!empty($_POST['apellido'])) and (!empty($_POST['nombre_usuario'])) and (!empty($_POST['mail'])) and (!empty($_POST['contraseña'])) and (!empty($_POST['fecha_nacimiento']) and (!empty($_POST['DNI'])))){
		if ((ctype_alpha($nombre)) and (ctype_alpha($apellido))){// verificacion si contiene solo caracteres alfabeticos
			if (isset ($_POST['nombre_usuario'])){
				$usuario= $_POST['nombre_usuario'];
				if ((strlen($usuario) >= 6) and (ctype_alnum($usuario))) {// alfanumerico y 6 caracteres
					if ((isset ($_POST['contraseña']))) {
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
											$cumple1= true;
										}
										else{
										$mensaje="debe introducir un mail";
										}
									}
							 else {
								$mensaje="La contraseña debe tener al menos una mayuscula y un simbolo o un numero";
							}
						} else {
							$mensaje= "La contraseña debe tener 8 caracteres como minimo";
						} 
					 } else {
						$mensaje="La conntraseña no fueron introducida";
					}					
				} else {
					$mensaje="El nombre de usuario debe tener al menos 6 caracteres";
				}
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
	
	$cumple2=true;// verificacion de la existencia del nombre de usuario
	if ($cumple1 == true){
		$query25= ("SELECT nombre_usuario FROM clientes");//hacer consulta 
		$result25= mysqli_query ($link, $query25) or die ('Consulta fallida 70' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($result25)){
			if ($usuario == $usuarioTabla['nombre_usuario']){
				$cumple2= false;
				$mensaje="El nombre de usuario ya existe, por favor elija otro";
			}
		}
	}
	
	if ($cumple1 == true){
		$query25= ("SELECT mail FROM clientes");//hacer consulta 
		$result25= mysqli_query ($link, $query25) or die ('Consulta fallida 80' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($result25)){
			if ($usuario == $usuarioTabla['mail']){
				$cumple2= false;
				$mensaje="Este mail ya tiene una cuenta asociada";
			}
		}
	}

	
	if (($cumple1== true) and ($cumple2== true)){
		$query31= "INSERT INTO clientes (apellido, nombre, mail, nombre_usuario, contraseña, fecha_nacimiento, DNI) values ('$_POST[apellido]', '$_POST[nombre]', '$_POST[mail]', '$_POST[nombre_usuario]', '$_POST[contraseña]', '$_POST[fecha_nacimiento]','$_POST[DNI]')";//falta subir la imagen y su tipo
		$result31= mysqli_query ($link, $query31) or die ('Consuluta query1 fallida 81: ' .mysqli_error($link));
		$exito= true;
	}

 ?>


<html>
<head> 
	<title> Registro </title>
	<link rel="stylesheet" type="text/css" href= " ../css/Estilos.css" media="all" > 
</head>
<body class = "body" >
	<div class="div_body">
			<div class="div_superior" >
				<p> Registrarse </p>
			</div>
	<br> <br>
	<?php 
	if ((isset($exito)) and (($exito==true))){
	?>
	Usuario regitrado exitosamente <br><br>
	<a href="../registrarse.php"> Click aqui para iniciar sesion &nbsp;&nbsp;&nbsp; </a>
	<?php
	} else {
		?>
		<div class="div_registro">
		Error al completar el formulario. <br><br>
		<?php echo ($mensaje); ?> <br><br>
		Por favor intente nuevamente <br> <br>
		<a href="../registrarse.php" class="links"> Click aqui para volver a intenar &nbsp;&nbsp;&nbsp; </a>
		</div>
	<?php
	}
	?>
	</div>
</body>
</html>
