<?php
     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id); 
  $tarjetaValida=false;
   $pag=$_POST['volverA'];
  include "menu.php"; 
  #echo "vacio tar ingresada". empty($_POST['numero_tarjeta'])."<br>";
  #echo "isset tar ingresada". isset($_POST['numero_tarjeta'])."<br>";
  #echo "vacio tar lista". empty($_POST['tarjetas'])."<br>";
  #echo "isset tar lista". isset($_POST['tarjetas'])."<br>";
  $cumple=false;
  $mensaje="";
 function validarTarjeta($numero,$codigo_seguridad,$tarjetaValida){
     $primero = substr($numero, 0,1); 
     $primeros = substr($numero, 0,2); 
     if(($primeros==37) or ($primeros==34) or ($primero==4) or ($primero==5)){
         if(($primeros==37) or ($primeros==34)){
             if((strlen($numero)==15)){
                 if((strlen($codigo_seguridad)==4) ){
                     $tarjetaValida=true;
                 }//else{ $mensaje="el codigo de seguridad no es valido"; } 
             }//else{ $mensaje="el numero de tarjeta no es valido";    }
         }else{
             if(strlen($numero)==16){
                 if((strlen($codigo_seguridad)==3)){
                     $tarjetaValida=true;
                 }//else{ $mensaje="el codigo de seguridad no es valido"; }
             }//else{  $mensaje="el numero de tarjeta no es valido"; }
         } 
     }//else{ $mensaje="Solo se aceptan las siguientes tarjetas: american express, mastercard y visa"; }
     return $tarjetaValida;
 } 
    

  if( ((empty($_POST['numero_tarjeta'])) or (empty ($_POST['clave'])) or (empty($_POST['fecha']))) and (!((empty($_POST['numero_tarjeta'])) and (empty($_POST['clave'])) and (empty($_POST['fecha'])))) ) {
      $mensaje= "Por favor, ingrese los datos de su tarjeta completos";
       $numero=$_POST['numero_tarjeta'];
     $codigo_seguridad=$_POST['clave'];
  }
  elseif( (empty($_POST['numero_tarjeta'])) and (empty($_POST['clave'])) and (empty($_POST['fecha'])) and (empty($_POST['tarjetas'])) ){
        $numero=$_POST['numero_tarjeta'];
     $codigo_seguridad=$_POST['clave'];
        $mensaje= "Por favor ingrese una tarjeta para realizar el pago";
  }
  elseif( (!empty($_POST['numero_tarjeta'])) and (!empty($_POST['clave'])) and (!empty($_POST['fecha'])) ){
      $numero=$_POST['numero_tarjeta'];
     $codigo_seguridad=$_POST['clave'];
     $fecha=$_POST['fecha'];
     if(!validarTarjeta($numero,$codigo_seguridad,$tarjetaValida)){
        $mensaje="La tarjeta ingresada es invalida";
     }
     else{
        if($fechaActual=date("Y-m")>=$_POST['fecha']){
          $mensaje="Segun la fecha de fecha de vencimiento, la tarjeta que intenta ingresar ya caduco";
        }
        else{
          $fecha= $_POST['fecha'].'-01';
            $cumple=true;
        }
      
        
     }
    
  }
  else{
    $numero=$_POST['tarjetas'];
    $cumple=true;
  }

if(!$cumple){//falla y tengo que devolver atributos
  
     if( (!isset($_POST['tarjetas'])) and (!isset($_POST['numero_tarjeta'])) ) {
            $_SESSION['tarjetas']="";
            $_SESSION['numero_tarjeta']="";
       }
     else{
                  if(!isset($_POST['tarjetas'])){
           $_SESSION['tarjetas']="";
           $_SESSION['numero_tarjeta']=$_POST['numero_tarjeta'];
           $_SESSION['fecha']=$_POST['fecha'];
        }
        else{
            $_SESSION['tarjetas']=$_POST['tarjetas'];
            $_SESSION['numero_tarjeta']="";
        }
        }
         $_SESSION['adicionales_seleccionados']=$_POST['adicionales_seleccionados'];
         $_SESSION['viaje']=$_POST['id_viaje'];
         $_SESSION['total']=$_POST['total'];
   echo "<script > alert('$mensaje');window.location='comprarPasaje.php'</script>";
}
else{
    $total=$_POST['total'];
    if($_POST['usuarioVip']){
       $descuento=0.1; #descuento del 10%
       $cobro=$total - ($total* $descuento);
    }
    else{
        $cobro=$total;
    }
    if (substr($numero,-1,1)!=3) {
     if (substr($numero,-1,1)!=8) {
         if (!empty($_POST['adicionales_seleccionados'])) { 
            $adicionales_seleccionados=$_POST['adicionales_seleccionados'];
             $consulta="INSERT INTO clientes_viajes(id_cliente, id_viaje, estado, servicios_adicionales, tarjeta_utilizada, total) VALUES ('$id','$_POST[id_viaje]','pendiente','$adicionales_seleccionados','$numero','$cobro')";   
             $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error()); 
             $actualizarCupo="UPDATE viajes SET cupo=cupo+1 WHERE id_viaje='$_POST[id_viaje]'";
            $resultado=mysqli_query($link,$actualizarCupo) or  die ('Consulta actualizarCupo fallida: ' .mysqli_error()); 
             echo "<script > alert('Compra exitosa');window.location='home.php'</script>";
            
         }
         else{//no compro adicionales
             $consulta="INSERT INTO clientes_viajes(id_cliente, id_viaje, estado,tarjeta_utilizada, total) VALUES ('$id','$_POST[id_viaje]','pendiente','$numero','$cobro')";
             $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error()); 
             $actualizarCupo="UPDATE viajes SET cupo=cupo+1 WHERE id_viaje='$_POST[id_viaje]'";
             $resultado=mysqli_query($link,$actualizarCupo) or  die ('Consulta actualizarCupo fallida: ' .mysqli_error()); 
             
             echo "<script> alert('Compra exitosa');window.location='home.php'</script>";
     }
     }else{ //sin saldo (termina en 8)
        if( (!isset($_POST['tarjetas'])) and (!isset($_POST['numero_tarjeta'])) ) {
            $_SESSION['tarjetas']="";
            $_SESSION['numero_tarjeta']="";
       }
     else{
                  if(!isset($_POST['tarjetas'])){
           $_SESSION['tarjetas']="";
           $_SESSION['numero_tarjeta']=$_POST['numero_tarjeta'];
             $_SESSION['fecha']=$_POST['fecha'];
        }
        else{
            $_SESSION['tarjetas']=$_POST['tarjetas'];
            $_SESSION['numero_tarjeta']="";
             $_SESSION['fecha']="";
        }
        }
         $_SESSION['adicionales_seleccionados']=$_POST['adicionales_seleccionados'];
         $_SESSION['viaje']=$_POST['id_viaje'];
         $_SESSION['total']=$_POST['total'];
             echo "<script> alert('La tarjeta no posee saldo suficiente');window.location='comprarPasaje.php'</script>";
     } 
}else{ //fallo la conexion (termina 3)?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
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
     <h2>No se pudo establecer la conexión con el servidor</h2>
     <a href="">Por favor vuelva a intertalo</a>
 </center>
</body>
</html>

<?php } }
?> 

