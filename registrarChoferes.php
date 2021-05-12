<html>
  <head>
    <title>Registro de Choferes</title>
  </head>
  <body>
	   <a href="home.php" >Volver al home </a>   
    <form action="registrarse.php" method="post">
     <h1> Registrar chofer </h1>
				<input type="text" name="nombre" size=50 placeholder=" Nombre"> <br><br>
				<input type="text" name="apellido" size=50 placeholder=" Apellido"> <br><br>
				<input type="text" name="nombre_usuario" size=50 placeholder=" Nombre de usuario"> <br><br>
        <input type="email" name="mail" size=50 placeholder=" Email"> <br><br>
        <input type="text" name="legajo" size=50 placeholder=" Legajo"> <br><br>
				<input type="password" name="contraseña" size=50 placeholder=" Contraseña"> <br><br>
        <input type="password" name="clave1" size=50   minlength= "8 " placeholder=" Confirmar Contraseña"> <br><br>
	    <input type="hidden" name="tipo_usuario" value='chofer'> <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
    </form>
  </body>
</html>

