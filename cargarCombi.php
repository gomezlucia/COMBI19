<?php
  include "BD.php";// conectar y seleccionar la base de datos
  $link = conectar();
       include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     include "menu.php";
?>
  <html>
  <head>
    <title>Registro de combi</title>
<link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
  </head>
  <body>
 <header>
       <a href="home.php" >  
           <img src="logo_is.png" class="div_icono">  
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>                       
       <hr>     
     </header> 
    <center>
    <form action="procesarCargaCombi.php" method="post">
     <h1> Registrar combi </h1>   
				<input type="text" name="patente" size=50 placeholder=" Patente"> <br><br>          
				<input type="text" name="chasis" size=50 placeholder=" Numero de chasis"> <br><br>
				<input type="text" name="modelo" size=50 placeholder=" Modelo"> <br><br>          
      <select name= 'tipo_de_combi'>
        <option value="0">Tipo de combi</option>
        <?php
          $consulta= "SELECT * FROM tipos_combi";
          $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
          while ($valores = mysqli_fetch_array($resultado)) {
            echo '<option value="' . $valores["id_tipo_combi"] . '">' . $valores["nombre_tipo"] . '</option>';
          }
        ?>
      </select>
       <br><br>
				<input type="submit" value="Guardar">
				<input type= "reset" value= "Borrar">
    </form>
    </center>
  </body>
</html>
