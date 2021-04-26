 <html>

<head>
<title> The Wall
 </title>
<link rel="stylesheet" type="text/css" href= "css/Estilos.css" media="all" > 
<script language="JavaScript" type="text/javascript" src ="js/validacionRegistro.js"> </script>
<script  src= "js/Passwordcheckbox.js"></script>
</head>

<body class = "body" >
    <div class="div_body">
		<div class="div_superior" >
			 <a class = "div_superior" href="index.php" >  The Wall <img src="css/images/muro.jpg" class="div_icono"> &nbsp;&nbsp;&nbsp; </a>
		</div>
		<div class=div_registro>
	    <div class="div_registrarse">
			<form name="registro" action="php/registrousuario.php"  method= "post" enctype="multipart/form-data" >
				<h1> Registrarse </h1>   
				<input type="text" name="nombre" size=50 placeholder=" Nombre"> <br><br>          
				<input type="text" name="apellido" size=50 placeholder=" Apellido"> <br><br>
				<input type="email" id="mail" name="user_mail"  placeholder=" Email de usuario" size=50 autofocus >         
				<br><br>
				          
				<p>Foto de perfil:          
				
				<input name="imagen" type="file" > <br><br></p>
				          
				<input type ="text" name="user_name" size= 50 placeholder=" Nombre usuario" minlength=6   pattern="[A-Za-z0-9]+" <br><br><br>
				          
				<input type ="password" name="clave" size=50  minlength="6" placeholder=" Clave"><br><br>
				          
				<input type="password" name="clave1" size=50   minlength= "6 " placeholder=" Confirmar Clave">
				
				<input type="checkbox" onclick="registrarsepassword()">Mostrar Contraseña<br><br>
				
				<input type="button" value="Enviar"  onclick="validacion()">
				<input type= "reset" value= "borrar">
			</form>
       </div>
   </div>

		<div class= "div_foot">
			<p> Made by : Amarillo Lujan & Echeverria Tomas  </p>
		</div>  
	</div>
</body>


</html>
