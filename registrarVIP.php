<?php

     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     include "menu.php";
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Registrarse como cliente VIP</title>
    <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
    <script   src="https://code.jquery.com/jquery-3.1.1.min.js"  ></script>
    <script type="text/javascript">
      function ocultarIngresoTarjeta(){
         var selectBox = document.getElementById("tarjetas");
         var selectedValue = selectBox.options[selectBox.selectedIndex].value;
       if (selectedValue !=0) {
         selectBox.disabled=false;
         document.getElementById("numero_tarjeta").disabled= true;
         document.getElementById("clave").disabled= true;
        document.getElementById("fecha").disabled= true;
       }else{

         document.getElementById("numero_tarjeta").disabled= false;
         document.getElementById("clave").disabled= false;
           document.getElementById("fecha").disabled= false;

       }
     }
     function ocultarSeleccionarTarjeta(){

        var num=document.getElementById("numero_tarjeta").value;
        var clave=document.getElementById("clave").value;
         var selectBox = document.getElementById("tarjetas");
         var fecha=document.getElementById("fecha").value;
       if ( (num != "") || (clave!= "") || (fecha!= "") ){

          selectBox.disabled=true;
       }else{

         selectBox.disabled=false;
         num.disabled= true;
         clave.disabled= true;
         fecha.disabled= true;
       }
     }
    </script>
 </head>
  <?php try {
             $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?>
 <body>
    <?php
          $usuarioVip=false;
         	 if (!isset($_POST['id_viaje'])) {
         	 	 $id_viaje=$_SESSION['viaje'];
             $total=$_SESSION['total'];
             $tarjetas_select=$_SESSION['tarjetas'];
             $fecha=$_SESSION['fecha'];
             $numero_tarjeta=$_SESSION['numero_tarjeta'];
             $adicionales_seleccionados=$_SESSION['adicionales_seleccionados'];
         	 }else{
               $total=$_POST['total'];
         	     $id_viaje=$_POST['id_viaje'];
         	     $tarjetas_select="";
               $numero_tarjeta="";
               $fecha="";
               $adicionales_seleccionados=$_POST['adicionales_seleccionados'];
         	 }

           if(!empty($tarjetas_select)){
            $tieneTarjetas="SELECT t.numero_tarjeta FROM usuarios c INNER JOIN tarjetas_clientes tc ON (c.id_usuario=tc.id_cliente) INNER JOIN tarjetas t ON (tc.id_tarjeta= t.id_tarjeta) WHERE id_usuario='$id' and t.numero_tarjeta<>'$tarjetas_select'  and t.fecha_vencimiento>=now()";
           }
           else{
            $tieneTarjetas="SELECT t.numero_tarjeta FROM usuarios c INNER JOIN tarjetas_clientes tc ON (c.id_usuario=tc.id_cliente) INNER JOIN tarjetas t ON (tc.id_tarjeta= t.id_tarjeta) WHERE id_usuario='$id'  and t.fecha_vencimiento>=now()";
           }

           $resultadoTarjetas=mysqli_query($link,$tieneTarjetas) or  die ('Consulta tiieneTarjetas fallida: ' .mysqli_error());

           if(isset($_POST['volverA'])){
               $volverA=$_POST['volverA'];
           }else{
               #$volverA=$_GET['p'];
           }?>
               <header>
       <a href="home.php" >
           <img src="logo_is.png" class="div_icono">
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>
       <hr>
     </header>
         	 <center>
         	 	 <p>
                   <form action="validarRegistroVIP.php" method="post">
                    <div id="seleccionarT">
          <?php
                       if(mysqli_num_rows($resultadoTarjetas)!=0){
                        if( (!empty($numero_tarjeta)) or (!empty($fecha)) ){ //significa que volvio del validar pago con una tarjeta ingresada en el input
                          ?>
                          <b>Mis Tarjetas:</b><br>
                         <select name= "tarjetas" id="tarjetas" disabled="" onchange="ocultarIngresoTarjeta();">
                           <option value="0">Seleccionar Tarjeta:</option>
             <?php         while ($tarjetas = mysqli_fetch_array($resultadoTarjetas)) {
                             echo '<option value="' . $tarjetas["numero_tarjeta"] . '">' . $tarjetas["numero_tarjeta"] . '</option>';
                           } ?>
                           </select> <br><br>
  <?php                 } else{ ?>
                          <b>Mis Tarjetas:</b><br>
                         <select name= "tarjetas" id="tarjetas" onchange="ocultarIngresoTarjeta();">
                           <option value="0">Seleccionar Tarjeta:</option>
             <?php        if(!empty($tarjetas_select)){
                            echo '<option selected="true" value="' . $tarjetas_select . '" select="" >' . $tarjetas_select . '</option>';
             }
                          while ($tarjetas = mysqli_fetch_array($resultadoTarjetas)) {
                             echo '<option value="' . $tarjetas["numero_tarjeta"] . '">' . $tarjetas["numero_tarjeta"] . '</option>';
                           } ?>
                            </select> <br><br>
 <?php     }
  }?>
                     </div>
                      <div id="ingresarT">
                     <?php if(!empty($tarjetas_select)){
                                           ?>
                     <b>Numero de tarjeta: </b><input type="text" name="numero_tarjeta"  maxlength="16"  disabled="" onchange="ocultarSeleccionarTarjeta()" id="numero_tarjeta"> </input><br><br>
                     <b>Clave de seguridad: </b><input type="password" name="clave" id="clave" maxlength="4" disabled="" onchange="ocultarSeleccionarTarjeta()" value=""></input><br><br>
                     <b>Fecha de vencimiento: </b><input type="month" name="fecha" id="fecha" disabled="" class="form-control" onchange="ocultarSeleccionarTarjeta()"><br><br>


                     <?php }
                     else{
                       ?>
                     <b>Numero de tarjeta: </b><input type="text" name="numero_tarjeta"  maxlength="16" value="<?php echo $numero_tarjeta ?>"  onchange="ocultarSeleccionarTarjeta()" id="numero_tarjeta"> </input><br><br>
                     <b>Clave de seguridad: </b><input type="password" name="clave" id="clave" maxlength="4"  value="" onchange="ocultarSeleccionarTarjeta()"></input><br><br>
                     <b>Fecha de vencimiento: </b><input type="month" name="fecha" id="fecha" value="<?php echo $fecha ?>" class="form-control" onchange="ocultarSeleccionarTarjeta()"><br><br>
                     <?php
                     } ?>
                     </div>
                          <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='home.php'">
                          <input type="submit" name="Submit" value="Registrarse">
                          <input type="hidden" name="volverA" value="<?php echo  $volverA;?>">


                     </form>
         	 </center>
 <?php

    ?>

 </body>
 <?php   } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage();
                 echo "<script> alert('Por favor, inicie sesión en COMBI-19 o regístrese como nuevo usuario para realizar la compra');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
         }?>
</html>
