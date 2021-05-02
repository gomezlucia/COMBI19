<html>
  <head>
    <title>Registro de Usuarios</title>
  </head>
  <body>
    <form action="registrarse.php" method="post">
     <h1> Registrar usuario </h1>
				<input type="text" name="nombre" size=50 placeholder=" Nombre"> <br><br>
				<input type="text" name="apellido" size=50 placeholder=" Apellido"> <br><br>
				<input type="date" name="fecha_nacimiento" size=50 placeholder=" Fecha de nacimiento"> <br><br>
				<input type="text" name="DNI" size=50 placeholder=" DNI sin puntos"> <br><br>
				<input type="email" name="mail" size=50 placeholder=" Email"> <br><br>
				<input type="text" name="nombre_usuario" size=50 placeholder=" Nombre de usuario"> <br><br>
				<input type="text" name="contraseña" size=50 placeholder=" Contraseña"> <br><br>
        <input type="text" name="clave1" size=50   minlength= "8 " placeholder=" Confirmar Contraseña"> <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
    </form>
  </body>
</html>

