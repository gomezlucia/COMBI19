<?php
	include("BD.php");// conectar y seleccionar la base de datos
	$link = conectar();
	$cumple= false;
	$cumple1=false;
	$mensaje= "";
	$exito=false;
	session_start();

	 function edad($edad){
         list($anio,$mes,$dia) = explode("-",$edad);
         $anio_dif = date("Y") - $anio;
         $mes_dif = date("m") - $mes;
         $dia_dif = date("d") - $dia;
         if ($dia_dif < 0 || $mes_dif < 0) { 
         	$anio_dif--; 
         } 
     return $anio_dif; }

     function validarContra($contra){
     	 if ((strlen($contra)) >= 8){
			 $mayus= 0;
			 $simbolo= 0;
			 $nro= 0;
			 for ($i=0; $i<strlen($contra);$i++){
				 $caracter= $contra[$i];
				 if (ctype_upper($caracter)){
					 $mayus ++;
				 }elseif (!ctype_alnum ($caracter)) {
					 $simbolo ++;
					 } elseif (ctype_digit($caracter)){
						 $nro ++;
					 }
			 }
	         if (($mayus <> 0) and (($simbolo <> 0) and ($nro <> 0)))  {
			 	 return true;
			 }else{
			 	return false;
			 }
	     }else{
	     	return false;
	     }
     }

     function existeMail($mail,$link){
         $estaMail="SELECT mail FROM usuarios WHERE mail='$mail'";//hacer consulta
		 $resultado= mysqli_query ($link, $estaMail) or die ('Consulta estamail fallida ' .mysqli_error());
		 $num=mysqli_num_rows($resultado);
     return $num;}

     function existeNombreUsuario($nombre,$link){
         $estaNombreU= "SELECT nombre_usuario FROM usuarios WHERE nombre_usuario='$nombre'";//hacer consulta
		 $resultado= mysqli_query ($link, $estaNombreU) or die ('Consulta estaNombreU fallida' .mysqli_error());
		 $num=mysqli_num_rows($resultado);
	 return $num;}

	 function existeLegajo($legajo,$link){
         $estaLegajo= "SELECT legajo FROM usuarios WHERE legajo='$legajo'";//hacer consulta
		 $resultado= mysqli_query ($link, $estaLegajo) or die ('Consulta estaLegajo fallida' .mysqli_error());
		 $num=mysqli_num_rows($resultado);
     return $num;}

     if(isset($_POST['nombre']) and isset($_POST['apellido']) and isset($_POST['mail']) and isset($_POST['nombre_usuario']) and isset($_POST['contraseña']) and isset($_POST['clave1'])  ){
       	 $nombre= $_POST['nombre'];
		 $apellido= $_POST['apellido'];
		 $usuario= $_POST['nombre_usuario'];
		 $contraseña= $_POST['contraseña'];
		 $mail=$_POST['mail'];
		 $nombre_usuario=$_POST['nombre_usuario'];
		 if ((ctype_alpha($nombre)) and (ctype_alpha($apellido))){	 	
		 	 if($_POST['clave1']==$contraseña) {
				 if(validarContra($contraseña)){
				     if(existeNombreUsuario($nombre_usuario,$link)==0){	     
                         if(existeMail($mail,$link)==0){
                             $cumple=true;
                         }else{
                             $mensaje="El mail ingresado ya tiene una cuenta asociada";
                         }
				     }else{
                         $mensaje="El nombre de usuario ya existe, por favor elija otro"; 
				     }         
				 }else{
				 	 $mensaje="La contraseña debe contar con al menos 8 caracteres, contener letras mayúsculas, letras minúsculas, poseer al menos un número y un símbolo";
				 }
			 }else{  
			 	 $mensaje="Las contraseñas no coinciden";
			 }			 
		 }else{ 
		 	 $mensaje= "El nombre y el apellido deben ser alfabeticos";
		 }
     }

 if ($_POST['tipo_usuario']=='cliente'){ 
     $dni=$_POST['DNI'];
     $fecha_nacimiento=$_POST['fecha_nacimiento'];
     if((ctype_digit($dni)) and ((strlen($dni)) >= 7) and ((strlen($dni)) < 9)){
         if ( edad($fecha_nacimiento) >= 18){
		     $cumple1= true;
	     }else{
			 $mensaje='Debes ser mayor de edad para registrarte en esta pagina';
		 }
     }else{
         $mensaje="DNI invalido. Por favor intente de nuevo";
     }
 }else{ //es chofer
     $legajo=$_POST['legajo'];
     if(existeLegajo($legajo,$link)==0){
         $cumple1= true;
	}else{
		$mensaje='Ya existe un usuario con ese legajo por favor ingrese otro';
	}
 }

	 if ($cumple1 and $cumple){
          if ($_POST['tipo_usuario']=='cliente'){
		     $agregarCliente= "INSERT INTO usuarios (apellido, nombre, mail, nombre_usuario, contraseña, fecha_nacimiento, DNI, tipo_usuario) values ('$apellido', '$nombre', '$mail', '$nombre_usuario', '$contraseña', '$fecha_nacimiento','$dni', 'cliente' )";
		     $resultado= mysqli_query ($link, $agregarCliente) or die ('Consuluta agregarCliente fallida : ' .mysqli_error($link));
		     $exito= true;
	     }else{
             $agregarChofer= "INSERT INTO usuarios (apellido, nombre, nombre_usuario, mail, legajo, contraseña, tipo_usuario, debaja) values ('$apellido', '$nombre', '$nombre_usuario', '$mail', '$legajo', '$contraseña', 'chofer' , '0')";
		     $resultado= mysqli_query ($link, $agregarChofer) or die ('Consuluta agregarCliente fallida : ' .mysqli_error($link));
		     $exito= true;
         }
     }

 if ((isset($exito)) and ($exito)){
	 if($_POST['tipo_usuario']=='cliente'){
         echo "<script > alert('Usuario regitrado exitosamente');window.location='inicioSesion.php'</script>";
     }
     else{
     	 echo "<script > alert('Usuario regitrado exitosamente');window.location='home.php'</script>";
     }
 }else {
	 if($_POST['tipo_usuario']=='cliente'){
	 	 $_SESSION['nombre_cliente']=$nombre;
	 	 $_SESSION['apellido_cliente']=$apellido;
	 	 $_SESSION['nombre_usuario_cliente']=$nombre_usuario;
	 	 $_SESSION['mail_cliente']=$mail;
	 	 $_SESSION['contraseña_cliente']=$contraseña;
         $_SESSION['fecha_nacimiento_c']=$fecha_nacimiento;
         $_SESSION['DNI_c']=$dni;
         echo "<script > alert('$mensaje');window.location='registroUsuario.php?error=$exito'</script>";
     }else{
     	 $_SESSION['nombre_chofer']=$nombre;
	 	 $_SESSION['apellido_chofer']=$apellido;
	 	 $_SESSION['nombre_usuario_chofer']=$nombre_usuario;
	 	 $_SESSION['contraseña_chofer']=$contraseña;
	 	 $_SESSION['mail_chofer']=$mail;
	 	 $_SESSION['legajo_chofer']=$legajo;
     	 echo "<script > alert('$mensaje');window.location='registrarChoferes.php?error=$exito'</script>";
     }
  }

 ?>
