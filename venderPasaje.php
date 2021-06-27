<?php 
include "BD.php";// conectar y seleccionar la base de datos
$link = conectar();
include "validarLogin.php";
$usuario= new usuario();
$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
$usuario ->id($id);
include "menu.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
    </style>
     <script   src="https://code.jquery.com/jquery-3.1.1.min.js"  ></script>

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
<?php if (isset($_POST['id_viaje']) and isset($_POST['precio'])  ) {
         $id_viaje=$_POST['id_viaje']; 
         $precio=$_POST['precio']; 
     } 
     if (isset($_POST['nombreUsuario'])) {
         $nombreU=$_POST['nombreUsuario'];
     }else{
          $nombreU="";
     } ?>     
     <form action="" method="POST">
         <input type="text" name="nombreUsuario" id="nombreUsuario" size="30" value="<?php echo $nombreU ?>" placeholder="Ingrese un nombre de usuario" required="">
          <input type="hidden" name="id_viaje" value="<?php echo $id_viaje ?>" >
           <input type="hidden" name="precio" value="<?php echo $precio ?>" >
         <input type="submit"  name="boton" value="Buscar">
     </form> 
 <?php
     if (isset($_POST['nombreUsuario'])) {
          $consulta="SELECT id_usuario,nombre,apellido,mail,DNI FROM usuarios  WHERE nombre_usuario='$_POST[nombreUsuario]' and tipo_usuario='cliente' and tiene_covid=0 and id_usuario not in (SELECT id_cliente FROM clientes_viajes WHERE id_viaje='$_POST[id_viaje]' and (estado='en curso' or estado='ausente'))";
          $resultado= mysqli_query($link,$consulta) or die ('Consulta proximoViaje fallida: ' .mysqli_error($link));
          if (mysqli_num_rows($resultado)==0) {
               echo " <font color='red'><b><p>El usuario no existe o se encuentra en el viaje</p></b></font>"; 
           }else{ 
          $usuario=mysqli_fetch_array ($resultado)?>
          <p>
             <b>Nombre de Usuario:</b> <?php echo $_POST['nombreUsuario']." ";?>
             <b>Nombre:</b> <?php echo $usuario['nombre']." ";?>
             <b>Apellido:</b> <?php echo $usuario['apellido']." ";?>
             <b>Mail:</b><?php echo $usuario['mail']?>
             <b>DNI:</b> <?php echo $usuario['DNI'];?><br>
         </p> 
         <form action="venderExistente.php" method="POST">
             <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario'] ?>" >
              <input type="hidden" name="id_viaje" value="<?php echo $_POST['id_viaje'] ?>" >
              <input type="hidden" name="precio" value="<?php echo $_POST['precio'] ?>" >
             <input type="submit"  name="boton" value="Vender">
     </form> 
  <?php  } 
     }
 ?>    

</center>
</body>
</html>







