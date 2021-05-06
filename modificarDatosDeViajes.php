<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
  //$usuario= new usuario();
  //$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
  //$usuario ->id($id);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Modificar Viajes</title>
</head>
<body>
   <?php 
   // try {
    //	$usuario -> iniciada($usuarioID);
    $consulta="SELECT id_combi,id_chofer,origen,destino,precio,fecha_hora_salida,fecha_hora_llegada FROM viajes WHERE id_viaje=1 ";
    $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
    $viaje=mysqli_fetch_array ($resultado); 
    $origen=$viaje['origen'];
    $destino=$viaje['destino'];
    $precio=$viaje['precio'];
    $id_combi=$viaje['id_combi'];
    $id_chofer=$viaje['id_chofer'];
    $fecha_hora_salida=$viaje['fecha_hora_salida'];
    $fecha_hora_llegada=$viaje['fecha_hora_llegada'];
    $id_viaje=1;
	//	if (isset ($_GET['error'])){
	//		$error=$_GET['error'];
	//		if($error){
	//		$email=$_SESSION['emailf'];
	//		$nombre=$_SESSION['nombref'];
	//		$apellido=$_SESSION['apellidof'];
	//		}
	//	}
  ?><center>
     <h2>Modificar datos del viaje</h2>
	 <form name="editar" method="post" action="validarModificacionViaje.php" >
       <input type="hidden" name="id_viaje" value="<?php echo $id_viaje ?>"> <br><br> 
	   Origen  <input type="text"  name="origen"  placeholder="Origen viaje" size=50 value="<?php echo $origen; ?>" required ></input><br><br>  
		 Destino <input type ="text" name="destino" size=50 placeholder="Destino viaje" value="<?php echo $destino; ?>" required></input><br><br> 
		 Precio $ <input type ="number" name="precio" size=50 placeholder="Precio viaje" value="<?php echo $precio; ?>" required></input><br><br> 
		 <?php $consulta= "SELECT id_combi,patente,chasis,modelo FROM combis WHERE id_combi not in (SELECT id_combi from viajes WHERE not ('$fecha_hora_salida' BETWEEN fecha_hora_salida and fecha_hora_llegada) or ('$fecha_hora_llegada' BETWEEN fecha_hora_salida and fecha_hora_llegada))";
          $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
	       if (mysqli_num_rows($resultado)==0){ ?>
               <p>No hay combis disponibles</P>
		 <?php    } else { ?>
		 <select name= 'combis'>
             <option value="0">Seleccione combi</option>
             <?php while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option value="' . $valores["id_combi"] . '">' . $valores["patente"] ." ". $valores["chasis"]."  ". $valores["modelo"] .  '</option>';}?>
         </select> <br><br> <?php } ?>
         <?php $consulta= "SELECT id_usuario,nombre,apellido FROM usuarios WHERE tipo_usuario='chofer' and id_usuario not in (SELECT id_chofer from viajes WHERE not ('$fecha_hora_salida' BETWEEN fecha_hora_salida and fecha_hora_llegada) or ('$fecha_hora_llegada' BETWEEN fecha_hora_salida and fecha_hora_llegada))";
          $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
	      if (mysqli_num_rows($resultado)==0){ ?>
               <p>No hay choferes disponibles</P>
		 <?php    } else { ?>
		 <select name= 'choferes'>
             <option value="0">Seleccione chofer</option>
             <?php while ($valores = mysqli_fetch_array($resultado)) {
                 echo '<option value="' . $valores["id_usuario"] . '">' . $valores["nombre"] ." ". $valores["apellido"].'</option>';}?>
         </select> <br><br> <?php } ?>
         <input type="submit" value="Editar">
     </form>	
  </center>
</body>
 <?php  //} catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
          //       $mensaje=$e->getMessage(); 
            //     echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
  //   }?>
</html>