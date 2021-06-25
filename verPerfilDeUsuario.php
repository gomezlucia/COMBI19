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
  <script type="text/javascript">
    function eliminarVIP(frm){
  var opcion = confirm('¿Esta seguro que desea eliminar su membresía? Dejará de obtener los descuentos en cada compra');
      if(opcion == true){
          frm.submit();
      }else{
          return false;
      }
}
  </script>
  <script type="text/javascript">
    function SubmitForm(frm){
    var opcion = confirm('¿Desea eliminar esta tarjeta de su cuenta ?');
        if(opcion == true){
            frm.submit();
        }else{
            return false;
        }
}
  </script>
  <script type="text/javascript">
    function SubmitFormVip(frm){
    var opcion = confirm('Esta tarjeta esta asociada a su membresia. Si la elimina, se asociara otra tarjeta registrada ¿ Aun desea eliminar esta tarjeta de su cuenta ?');
        if(opcion == true){
            frm.submit();
        }else{
            return false;
        }
}
  </script>

  <script type="text/javascript">
    function SubmitFormVipSin(frm){
    var opcion = confirm('Esta tarjeta esta asociada a su membresia. Para eliminarla primero registre otra tarjeta en su cuenta o de de baja su membresía');
        if(opcion == true){
            frm.submit();
        }else{
            return false;
        }
}
  </script>

      <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
</head>
<body>
 <header>
       <a href="home.php" >
           <img src="logo_is.png" class="div_icono">
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>

<?php $consulta00= "SELECT u.vip FROM usuarios u WHERE u.id_usuario=$id";
      $resultado00= mysqli_query($link,$consulta00) or die ('Consulta fallida: 00 ' .mysqli_error($link));
      $es_vip = mysqli_fetch_array($resultado00);
      // var_dump($es_vip) ;
      if ($es_vip['vip']=='0'){
?>
       <hr>
     </header>
     <center>
        <h1>Perfil</h1>
     <?php }else{ ?>
       <hr>
     </header>
     <center>
        <h1>Cliente VIP</h1>
    <?php }
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
                           <input type="submit" value="Modificar datos"><br><br>
                        </form>
                        <?php if ($es_vip['vip']=='0'){ ?>
                        <form action="registrarVIP.php" method="post">
                           <input type="submit" value="Registrarse como cliente VIP"><br><br>
                            <input type="hidden"name="id" value="<?php echo $id;?>">

                        </form>
                      <?php }else { ?>
                        <form action="darDebajaVIP.php" method="post">
                           <input type="submit" value="Dar de baja membresía " class="btn_buscar" onclick="return eliminarVIP(this.form)"><br><br>
                            <input type="hidden"name="id" value="<?php echo $id;?>">
                        </form>

                <?php       }  ?>
                </p>
              </div>
                   <?php }
        $consulta= "SELECT t.id_tarjeta, t.numero_tarjeta, tc.vip FROM tarjetas t NATURAL JOIN tarjetas_clientes tc WHERE tc.id_cliente=$id";
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
             $tarj_vip=$valores['vip'];
             ?>
                <div>
                    <hr>
                    <p>
            <?php          if ($tarj_vip==1){
               if(mysqli_num_rows($resultado) > 1){ ?>
                  <form action="borrarTarjeta.php" method="post">
                    <font color="blue">  <b></b> <?php echo $primeros.(str_repeat('*',$cantidad)).$ultimos;?>    <input type="hidden"name="id_tarjeta" value="<?php echo $id_tarjeta;?>">
                        <input type="submit" value="Eliminar" class="btn_buscar"  onclick="return SubmitFormVip(this.form)"> </font>
                          </form>
                      <?php } else { ?>
                        <form action="verPerfilDeUsuario.php" method="post">
                          <font color="blue">  <b></b> <?php echo $primeros.(str_repeat('*',$cantidad)).$ultimos;?>    <input type="hidden"name="id_tarjeta" value="<?php echo $id_tarjeta;?>">
                        <input type="submit" value="Eliminar" class="btn_buscar"  onclick="return SubmitFormVipSin(this.form)"> </font>
                    </form>

                  <?php   } }else { ?>
                    <form action="borrarTarjeta.php" method="post">
                       <b></b> <?php echo $primeros.(str_repeat('*',$cantidad)).$ultimos;?>    <input type="hidden"name="id_tarjeta" value="<?php echo $id_tarjeta;?>">
                           <input type="submit" value="Eliminar" class="btn_buscar"  onclick="return SubmitForm(this.form)">
                    </form>
              <?php     }  ?>
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
