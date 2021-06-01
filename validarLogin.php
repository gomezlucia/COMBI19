<?php
	session_start(); //inicia la sesion
	//se crea la clase usuario
	class usuario {

		//funcion para comprobar si existe el usuario en la base de datos
		public function validar_usuario ($link) {
			//recogemos las variables post del formulario, colocamos mysql_real_scape_string para evitar inyecciones
			if ((isset ($_POST['nombre'])) and (isset ($_POST['cont']))){

				$nombre= $_POST['nombre'];
				$contraseña= $_POST['cont'];

				$_SESSION['nombre_login']=$nombre;
				$_SESSION['cont_login']=$contraseña;

				if((!empty($nombre)) || (!empty($contraseña))){
				//validacion del lado del servidor
					$nombre = mysqli_real_escape_string ($link, $_POST['nombre']);
					$contraseña = mysqli_real_escape_string ($link, $_POST['cont']);

					$consulta1 = "SELECT * FROM usuarios WHERE nombre_usuario= '".$nombre."' AND contraseña= '".$contraseña."';" ;
					$resultadoConsulta1 = mysqli_query($link, $consulta1) or die ('Consulta1 fallida ' .mysqli_error($link));;
					/*si el número de filas devuelto por la variable resultado es 1,significa que en la base de datos,en la tabla usuarios existe una fila que coincide con los datos ingresados. */
					if($datosUsuario =mysqli_fetch_array($resultadoConsulta1)) {
                         //guada los datos del usuario en la variable global SESSION
						 $_SESSION['id_usuario'] = $datosUsuario ['id_usuario'];
		              //   $_SESSION['nombre_usuario'] = $datosUsuario ['nombre_usuario'];
						// $_SESSION['contraseña']=$datosUsuario ['contraseña'];
			             $_SESSION['nombre'] = $datosUsuario ['nombre'];
			             $_SESSION['apellido']=$datosUsuario ['apellido'];

			             if($datosUsuario['tipo_usuario']=='cliente'){
				             $_SESSION['mail'] = $datosUsuario ['mail'];
		                     $_SESSION['DNI'] = $datosUsuario ['DNI'];
			                 $_SESSION['fecha_nacimiento']=$datosUsuario ['fecha_nacimiento'];
			                  $_SESSION['nombre_usuario'] = $datosUsuario ['nombre_usuario'];
						 $_SESSION['contraseña']=$datosUsuario ['contraseña'];
			             }else{
			 	             $_SESSION['debaja'] = $datosUsuario ['debaja'];
							 if ($datosUsuario ['debaja'] == 0 ){
								 $_SESSION['mail'] = $datosUsuario ['mail'];
								 $_SESSION['legajo'] = $datosUsuario ['legajo'];
								 $_SESSION['nombre_usuario'] = $datosUsuario ['nombre_usuario'];
						 $_SESSION['contraseña']=$datosUsuario ['contraseña'];}
							 else{
								 throw new Exception ('Usted esta dado de baja');
							 }
			             }
					 }
					  else {
						 throw new Exception ('Nombre de usuario o contraseña incorrecta');
					 }

			     } else {
				      throw new Exception ('No se completo el formulario de iniciar sesion');
			     }
			 }
		 }

		 public function session (&$nombreUsuario){ //llega el parametro por referencia
			if (isset ($_SESSION['nombre_usuario'])){
				 $nombreUsuario= $_SESSION['nombre_usuario'];
			}
		}

		 public function iniciada ($nombreUsuario) { //tira la exception si la sesion NO esta iniciada
			if (!isset ($nombreUsuario)) {
				throw new Exception ('Es necesario iniciar sesion para acceder a este contenido');
			}
		}

		 public function noIniciada ($nombreUsuario) { //tira la exception si la sesion SI esta iniciada
			if (isset ($nombreUsuario)) {
				throw new Exception ('Sesion iniciada');
			}
		}

	     public function id(&$id){
	    	if(isset($_SESSION['id_usuario'])){
	    		$id=$_SESSION['id_usuario'];
	    	}
	    }
	    public function tieneSesionIniciada(&$sesion,$nombreUsuario){
	    	 if (!isset ($nombreUsuario)) {
				 $sesion=false;
			 }
	    }

	}
?>


