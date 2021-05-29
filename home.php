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
       <style type="text/css">
         li{
            list-style: none;
            padding: 20px;
         }
       </style>
     </head>
     <?php try {
             $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?> 
     <body>               
         <center>
            <h1>COMBI-19</h1> 
                <?php $consulta="SELECT tipo_usuario FROM usuarios WHERE id_usuario='$id'"; 
                $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
                $usuario=mysqli_fetch_array ($resultado); 
                 if ($usuario['tipo_usuario']=='cliente'){ ?> 
                     <div id="menu">
                          <li><a href="listarViajes.php"> Ver listado de viajes</a></li>
                          <li><a href="verPerfilDeUsuario.php"> Perfil</a></li>
                          <li><a href="cerrarSesion.php"> Cerrar Sesion </a></li> 
                     </div>	

         <?php } elseif ($usuario['tipo_usuario']=='chofer') { ?>
                     <div>
                         <li><a href="cerrarSesion.php"> Cerrar Sesion </a></li> 
                     </div>
         <?php } else { ?>
             <div id="menu">
		     <li><a href="verListadoDeRutas.php"> Ver listado de rutas </a></li>
                   <li><a href="cargarRuta.php"> Cargar ruta </a></li>
                 <li><a href="verListadoDeCombis.php"> Ver listado de combis </a></li>
                 <li><a href="cargarCombi.php"> Cargar combis  </a></li>
                 <li><a href="registrarChoferes.php"> Registrar Chofer  </a></li>
                 <li><a href="verListadoDeChoferes.php"> Ver listado de choferes  </a></li>
                 <li><a href="cargarViaje.php"> Cargar viaje  </a></li>
                 <li><a href="listarViajes.php"> Ver listado de viajes  </a></li>
                 <li><a href="cerrarSesion.php"> Cerrar Sesion </a></li>
             </div>
            <?php  }	?>
		 </center>       	
	 </body>
	 <?php  } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
           	     $mensaje=$e->getMessage(); 
           	     echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                	//redirige a la pagina inicioSesion y muestra una mensaje de error
     }?>
</html>
