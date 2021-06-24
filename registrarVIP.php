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
   <script   src="https://code.jquery.com/jquery-3.1.1.min.js"  ></script>

       <script type="text/javascript">
       function ocultarIngresoTarjeta(){
          var selectBox = document.getElementById("tarjetas");
          var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if (selectedValue !=0) {
          selectBox.disabled=false;
          document.getElementById("numero_tarjeta").disabled= true;
          document.getElementById("clave").disabled= true;

        }else{

          document.getElementById("numero_tarjeta").disabled= false;
          document.getElementById("clave").disabled= false;

        }
      }
      function ocultarSeleccionarTarjeta(){
         var num=document.getElementById("numero_tarjeta").value;
         var clave=document.getElementById("clave").value;
          var selectBox = document.getElementById("tarjetas");
        if (num != "") {
           selectBox.disabled=true;
        }else{

          selectBox.disabled=false;
          num.disabled= true;
          clave.disabled= true;
        }
      }
       </script>
 	<title>Registrarse como cliente VIP</title>
    <link rel="stylesheet" type="text/css" href="estilos.css" media="all" > </link>
 </head>

  <?php try {
             $usuario -> iniciada($nombreUsuario); //entra al body si el usuario tenia una sesion iniciada
     ?>
 <body>
    <?php

                    if(!empty($_GET['numero_tarjeta'])){
                        $numero_tarjeta=$_GET['numero_tarjeta'];}
                    else{
                        $numero_tarjeta="";
                    }
                    if(!empty($_GET['clave'])){
                        $clave=$_GET['clave'];
                    }else{
                        $clave="";
                    }
                    if (!empty($_GET['fecha'])) {
                           $fcha=$_GET['fecha'];
                    }else{
              $fcha = date("Y-m");}

           $tieneTarjetas="SELECT t.numero_tarjeta, t.id_tarjeta, tc.id_cliente FROM usuarios c INNER JOIN tarjetas_clientes tc ON (c.id_usuario=tc.id_cliente) INNER JOIN tarjetas t ON (tc.id_tarjeta= t.id_tarjeta) WHERE id_usuario='$id'";
           $resultadoTarjetas=mysqli_query($link,$tieneTarjetas) or  die ('Consulta tiieneTarjetas fallida: ' .mysqli_error());

          ?>
               <header>
       <a href="home.php" >
           <img src="logo_is.png" class="div_icono">
       </a>
       <b><?php echo $nombreUsuario; ?></b>
<?php           echo menu($id,$link); ?>
       <hr>
     </header> <center>
         <h1>Registrarse como cliente VIP</h1>
         	 <center>

                   <form action="validarPago.php" method="post">
          <?php
                       if(mysqli_num_rows($resultadoTarjetas)!=0){?>
                          <b>Seleccione una de sus tarjetas o ingrese una nueva para completar el registro. Se le cobrará un monto mensual por la membresía</b><br><br>
                         <select name= "tarjetas" id="tarjetas" onchange="ocultarSeleccionarTarjeta()">
                           <option value="0">Seleccionar Tarjeta:</option>
             <?php         while ($tarjetas = mysqli_fetch_array($resultadoTarjetas)) {
                             echo '<option value="' . $tarjetas["numero_tarjeta"] . '">' . $tarjetas["numero_tarjeta"] . '</option>';
                           } ?>
                           </select> <br><br>
  <?php
                       }?>

                     <b>Numero de tarjeta: </b><input type="number" id="numero_tarjeta" name="numero_tarjeta"  maxlength="16" value="<?php echo $numero_tarjeta?>" onchange="ocultarSeleccionarTarjeta()" ></input><br><br>
                     <b>Clave de seguridad: </b><input type="password" name="clave"  id="clave" maxlength="4"  value=""></input><br><br>
                     <b>Fecha de vencimiento: </b><input type="month" name="fecha" id="fecha" class="form-control" value="<?php echo $fcha ?>"></input><br><br>
                         <input type="submit" name="Submit" value="Registrarse como cliente VIP"></input>
                         <input type="hidden"name="id" value="<?php echo $id;?>">
                         <input type="hidden"name="tarjeta" value="<?php echo true ;?>">
                          <input type="reset" name="cancelar" value="Cancelar"></input><br><br>

                     </form>
         	 </center>

 </body>
 <?php   } catch (Exception $e) { //entra a esta parte solo si no tenia una sesion iniciada
                 $mensaje=$e->getMessage();
                 echo "<script> alert('Por favor, inicie sesión en COMBI-19 o regístrese como nuevo usuario para realizar la compra');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
         }?>
</html>
