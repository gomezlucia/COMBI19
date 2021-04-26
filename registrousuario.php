<?php
	include "../BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
	$cumple= false;
	$cumple1= false;
	$mensaje= "";
	
	if ((isset ($_POST['nombre'])) and (isset ($_POST['apellido']))) {
		$nombre= $_POST['nombre'];
		$apellido= $_POST['apellido'];
		if((!empty($_POST['nombre'])) and (!empty($_POST['apellido'])) and (!empty($_POST['user_name'])) and (!empty($_POST['user_mail'])) and (!empty($_POST['clave'])) and (!empty($_POST['clave1']))){
		if ((ctype_alpha($nombre)) and (ctype_alpha($apellido))){// verificacion si contiene solo caracteres alfabeticos
			if (isset ($_POST['user_name'])){
				$usuario= $_POST['user_name'];
				if ((strlen($usuario) >= 6) and (ctype_alnum($usuario))) {// alfanumerico y 6 caracteres
					if ((isset ($_POST['clave'])) and (isset ($_POST['clave1'])) and ($_POST['clave1']==$_POST['clave'])){
						$contra= $_POST['clave'];
						if ((strlen($contra)) >= 6){
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
								if (!empty($_FILES['imagen']['name'])){
									if ((($_FILES['imagen']['type'] == "image/png") || ($_FILES["imagen"]["type"] == "image/jpeg") || ($_FILES["imagen"]["type"] == "image/pjpeg") || ($_FILES["imagen"]["type"] == "image/gif") || ($_FILES["imagen"]["type"] == "image/tiff") || ($_FILES["imagen"]["type"] == "image/ppm") || ($_FILES["imagen"]["type"] == "image/jfif")    )){
									$imagen = $_FILES['imagen']['tmp_name'];
									$aux = file_get_contents ($imagen);
									$aux = addslashes($aux);
									$tipoimagen = $_FILES['imagen']['type'];
										if(isset($_POST['user_mail'])){
											$cumple1= true;
										}
										else{
										$mensaje="debe introducir un mail";
										}
									}else{
										echo($_FILES['imagen']['type']);
										$mensaje="el formato de  la imagen no es valido";
									}
								}
								else{
									$mensaje="debe de cargar una imagen como foto de perfil";
								}
							} else {
								$mensaje="La contraseña debe tener al menos una mayuscula y un simbolo o un numero";
							}
						} else {
							$mensaje= "La contraseña debe tener 6 caracteres como minimo";
						} 
					} else {
						$mensaje="Las conntraseñas no fueron introducidas, o no coinciden";
					}					
				} else {
					$mensaje="El nombre de usuario debe tener al menos 6 caracteres y ser alfanumerico";
				}
			} else {
				$mensaje= "Introduzca un nombre de usuario";
			}
		} else {
			$mensaje= "El nombre y el apellido deben ser alfanumericos";
		}
		}else{
			$mensaje="Complete todos los campos";
		}
	} else {
		$mensaje= "Introduzca su nombre y apellido";
	}
	
	$cumple2=true;// verificacion de la existencia del nombre de usuario
	if ($cumple1 == true){
		$query25= ("SELECT nombreusuario FROM usuarios");//hacer consulta 
		$result25= mysqli_query ($link, $query25) or die ('Consulta fallida ' .mysqli_error());
		while ($usuarioTabla= mysqli_fetch_array ($result25)){
			if ($usuario == $usuarioTabla['nombreusuario']){
				$cumple2= false;
				$mensaje="El nombre de usuario ya existe, por favor elija otro";
			}
		}
	}
	
	if (($cumple1== true) and ($cumple2== true)){
		$query31= "INSERT INTO usuarios (apellido, nombre, email, nombreusuario,contrasenia,foto_contenido,foto_tipo) values ('$_POST[apellido]', '$_POST[nombre]', '$_POST[user_mail]', '$_POST[user_name]', '$_POST[clave]', '$aux', '$tipoimagen')";//falta subir la imagen y su tipo
		$result31= mysqli_query ($link, $query31) or die ('Consuluta query1 fallida: ' .mysqli_error($link));
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
				<p> The Wall <img src="../css/images/muro.jpg" class="div_icono">
				</p>
			</div>
	<br> <br>
	<?php 
	if ((isset($exito)) and (($exito==true))){
	?>
	Usuario regitrado exitosamente <br><br>
	<a href="../index.php"> Click aqui para iniciar sesion &nbsp;&nbsp;&nbsp; </a>
	<?php
	} else {
		?>
		<div class="div_registro">
		Error al completar el formulario. <br><br>
		<?php echo ($mensaje); ?> <br><br>
		Por favor intente nuevamente <br> <br>
		<a href="../Registrarse.php" class="links"> Click aqui para volver a intenar &nbsp;&nbsp;&nbsp; </a>
		</div>
	<?php
	}
	?>
	</div>
</body>
</html>
	
