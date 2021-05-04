<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
    include "validarLogin.php";
	$usuario= new usuario();
	$usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
	$usuario ->id($id);
?>
<html>
	<head>
		<title> COMBI-19</title>
     </head>
     <?php try {
    	     $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?> 
	 <body>	
				<h1>Bienvenid@  <?php echo " ".$nombreUsuario;  ?></h1>
                <?php $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
                $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
                $usuario=mysqli_fetch_array ($resultado); 
                 if ($usuario['tipo_usuario']=='cliente'){ ?> 

                     <a href="listarViajes.php"> Ver listado de viajes  </a><br> 	

         <?php } elseif ($arregloConTipoUsuario['tipo_usuario']=='chofer') { ?>

                 	 <a href="">  </a>

         <?php } else { ?>

                     <a href="verListadoDeCombis.php"> Ver listado de combis </a><br> 
                     <a href="cargarCombi.php"> Cargar combis  </a><br>
                     <a href="registrarChoferes.php"> Registrar Chofer  </a><br>
                     <a href="listarViajes.php"> Ver listado de viajes  </a><br>
            <?php  }
                 	?>
			     <a href="cerrarSesion.php"> Cerrar Sesion </a>  	
	 </body>
	 <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
           	     $mensaje=$e->getMessage(); 
           	     echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                	//redirige a la pagina inicioSesion y muestra una mensaje de error
     }?>
</html>
