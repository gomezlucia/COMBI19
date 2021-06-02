<?php
  include "BD.php";// conectar y seleccionar la base de datos
  $link = conectar();
   // include "classLogin.php";
  //$usuario= new usuario();
  //$usuario ->id($id);
  $id_usuario=intval($_POST['id']);
  $cumpleF=false;
  $cumpleD=false;
  $cumpleM=true;#cumple con el formato de tarjeta mastercard
  $mensaje="";
  $id_usuario=$_POST['id'];


  if( (empty($_POST['numero'])) or (empty ($_POST['seguridad'])) or  (empty ($_POST['fecha'])) ){
    $mensaje="Por favor, complete todos los campos";
  }
  else{
     $numero=$_POST['numero'];
     $codigo_seguridad=$_POST['seguridad'];
     $primero = substr($numero, 0,1); 
     $primeros = substr($numero, 0,2); 
     if(($primeros<>37) and ($primeros<>34) and ($primero<>4) and ($primero<>5)){
      $mensaje="Solo se aceptan las siguientes tarjetas: american express, mastercard y visa";
     }
     else{
       if(($primeros==37) or ($primeros==34)){
          if((strlen($numero)<>15) or (!ctype_digit($numero))){
            $mensaje="el numero de tarjeta no es valido";
          }
          else{
            if((strlen($codigo_seguridad)<>4) or (!ctype_digit($codigo_seguridad))){
              $mensaje="el codigo de seguridad no es valido";
            }
            else{
              $cumpleF=true;
            }
          }
       }
       else{
         if((strlen($numero)<>16) or (!ctype_digit($numero))){
            $mensaje="el numero de tarjeta no es valido";
          }
          else{
            if((strlen($codigo_seguridad)<>3) or (!ctype_digit($codigo_seguridad))){
              $mensaje="el codigo de seguridad no es valido";
            }
            else{
              $cumpleF=true;
            }
          }
       }
     }
   }
       
    if($cumpleF){
        if($fechaActual=date("Y-m")>=$_POST['fecha']){
          $mensaje="Segun la fecha de fecha de vencimiento, la tarjeta que intenta ingresar ya caduco";
        }
        else{
          $fecha= $_POST['fecha'].'-01';
           $cumpleD=true;
        }
      }
        if((!$cumpleF) or (!$cumpleD)){
          echo "<script > alert('$mensaje');window.location='agregarTarjeta.php'</script>";
        }
        else{
           $consulta="INSERT INTO tarjetas (numero_tarjeta, codigo_seguridad, fecha_vencimiento) VALUES ('$numero', '$codigo_seguridad', '$fecha')";#por ahora
           $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida: ' .mysqli_error($link)));
           if($resultado){
           $id_tarjeta=mysqli_insert_id($link); 
           echo $id_tarjeta;
           echo $id_usuario;
           $consulta2="INSERT INTO tarjetas_clientes (id_tarjeta, id_cliente) VALUES ('$id_tarjeta', '$id_usuario')";
           $resultado2= (mysqli_query ($link, $consulta2) or die ('Consulta fallida: ' .mysqli_error($link)));

          echo "<script > alert('Modificacion exitosa');window.location='verPerfilDeUsuario.php'</script>";#por ahora

       } }
