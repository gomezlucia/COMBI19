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
        <h1>Perfil</h1> 
     <?php
        $consulta= "SELECT u.nombre, u.apellido, u.nombre_usuario, u.mail, u.fecha_nacimiento, u.DNI FROM usuarios u WHERE u.id_usuario=$id";
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: 14 ' .mysqli_error($link));

        if ($resultado){
        	$valores = mysqli_fetch_array($resultado);
        	 $nombre = $valores['nombre'];
             $apellido = $valores['apellido'];
             $nombre_usuario = $valores['nombre_usuario'];
             $mail = $valores['mail'];
             $fecha_nacimiento = $valores['fecha_nacimiento'];
             $dia=substr($fecha_nacimiento, -2);
             $mes=substr($fecha_nacimiento, -5,2);
             $year=substr($fecha_nacimiento, 0,4);
             $DNI = $valores['DNI'];
             ?>
             	<div>
                    <hr>
             		<p>
             			      <b>Nombre:</b> <?php echo $nombre;?><br>
             			      <b>Apellido:</b> <?php echo $apellido;?><br>
                        <b>Nombre de usuario:</b> <?php echo $nombre_usuario;?><br>
                        <b>Email:</b> <?php echo $mail;?><br>
                        <b>Fecha de nacimiento:</b> <?php  echo $dia."/".$mes."/".$year;;?><br>
                        <b>D.N.I:</b> <?php echo $DNI;?><br>
                        <form action="modificarDatosCliente.php" method="post"> 
                           <input type="submit" value="Modificar datos">
                        </form>

                </p>
              </div>
                   <?php }
        $consulta= "SELECT t.id_tarjeta, t.numero_tarjeta FROM tarjetas t NATURAL JOIN tarjetas_clientes tc WHERE tc.id_cliente=$id";
        $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: 14 ' .mysqli_error($link));?>

    <h2>Tarjetas</h2>
    <?php
        if ($resultado){
            while (($valores = mysqli_fetch_array($resultado)) ){
             $id_tarjeta=$valores['id_tarjeta'];
             $numero_tarjeta = $valores['numero_tarjeta'];
             $primeros = substr($numero_tarjeta, 0,2); 
             $ultimos =substr($numero_tarjeta, -4); 
             $cantidad=(strlen($numero_tarjeta))-strlen($primeros)-strlen($ultimos);
             ?>
                <div>
                    <hr>
                    <p>

                   
                     <form action="borrarTarjeta.php" method="post"> 
                       <b>Numero de tarjeta:</b> <?php echo $primeros.(str_repeat('*',$cantidad)).$ultimos;?>    <input type="hidden"name="id_tarjeta" value="<?php echo $id_tarjeta;?>">
                           <input type="submit" value="Eliminar">
                    </form>
                </p>
              </div>
            <?php } 
                if(mysqli_num_rows($resultado)==0){
            ?>
            <div>
                 <p>
                   <b>Aun no hay tarjetas guardadas en la pagina</b><br><br>
            </div>
            <?php

    }?>
 <form action="agregarTarjeta.php" method="post"> 
                           <input type="submit" value="Agregar tarjeta">
                        </form>
                    <?php }?>
                </center>
            </body>
            </html>
