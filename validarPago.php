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
 // $mensaje="";
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
    
  if( (!empty($_POST['numero_tarjeta'])) and (!empty ($_POST['clave'])) ) {
     $numero=$_POST['numero_tarjeta'];
     $codigo_seguridad=$_POST['clave'];
     if(!validarTarjeta($numero,$codigo_seguridad,$tarjetaValida)){
         $_SESSION['tarjeta_ingresada']=$numero;
         $_SESSION['viaje']=$_POST['id_viaje'];
         echo "<script> alert('Numero de tarjeta invalido');window.location='/COMBI19-main/comprarPasaje.php?p=$pag'</script>";
     }
 }else{
     $numero=$_POST['tarjetas']; 
 }
 if (substr($numero,-1,1)!=3) {
	 if (substr($numero,-1,1)!=8) {
	     if (!empty($_POST['chkl'])) {
             $checkbox1 = $_POST['chkl'];
             $adicionalesSeleccionados=""; 
             $precioAdicional=0;
             foreach($checkbox1 as $valor) { 
                 $consulta="SELECT nombre_servicio,precio FROM servicios_adicionales WHERE id_servicio_adicional='$valor'";  
                 $resultado=mysqli_query($link,$consulta)  or die ('Consulta fallida: ' .mysqli_error());
                 $valores = mysqli_fetch_array($resultado);
                 $adicionalesSeleccionados=$valores['nombre_servicio']."/".$adicionalesSeleccionados;
                 $precioAdicional=$precioAdicional+$valores['precio'];
  		     } 
  			 $precio=$precioAdicional + $_POST['precio'];
  			 $consulta="INSERT INTO clientes_viajes(id_cliente, id_viaje, estado, servicios_adicionales, tarjeta_utilizada, total) VALUES ('$id','$_POST[id_viaje]','pendiente','$adicionalesSeleccionados','$numero','$precio')";	 
             $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error()); 
             $actualizarCupo="UPDATE viajes SET cupo=cupo+1 WHERE id_viaje='$_POST[id_viaje]'";
             $resultado=mysqli_query($link,$actualizarCupo) or  die ('Consulta actualizarCupo fallida: ' .mysqli_error()); 
             echo "<script> alert('Compra exitosa');window.location='$pag'</script>";
         }//no compro adicionales
	 	     $consulta="INSERT INTO clientes_viajes(id_cliente, id_viaje, estado,tarjeta_utilizada, total) VALUES ('$id','$_POST[id_viaje]','pendiente','$numero','$_POST[precio]')";
	 	     $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error()); 
             $actualizarCupo="UPDATE viajes SET cupo=cupo+1 WHERE id_viaje='$_POST[id_viaje]'";
             $resultado=mysqli_query($link,$actualizarCupo) or  die ('Consulta actualizarCupo fallida: ' .mysqli_error()); 
             echo "<script> alert('Compra exitosa');window.location='$pag'</script>";
	 }else{ //sin saldo (termina en 8)
	     $_SESSION['tarjeta_ingresada']=$numero;
	     $_SESSION['viaje']=$_POST['id_viaje'];
             echo "<script> alert('La tarjeta no posee saldo suficiente');window.location='/COMBI19-main/comprarPasaje.php?p=$pag'</script>";
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
 	 <h2>No se pudo establecer la conexión con el servidor</h1>
 	 <a href="">Por favor vuelva a intertalo</a>
 </center>
</body>
</html>
<?php } 
?>


