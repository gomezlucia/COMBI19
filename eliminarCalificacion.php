
 <?php
     include "BD.php";// conectar y seleccionar la base de datos
     $link = conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);

     $id_viaje=$_POST['id_viaje'];
     $consulta0="SELECT id_calificacion, id_viaje_calificacion, id_viaje, id_cliente FROM viaje_calificacion WHERE (id_viaje= '$_POST[id_viaje]') and (id_cliente = '$id') ";
     $result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 12: ' .mysqli_error($link));
     if ($result0){
         $valores = mysqli_fetch_array($result0);
           $id_calificacion= $valores['id_calificacion'];
           $id_viaje_calificacion=$valores['id_viaje_calificacion'];
     $consulta="DELETE FROM viaje_calificacion WHERE id_viaje_calificacion = $id_viaje_calificacion";
     $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida 18: ' .mysqli_error($link)));
     if($resultado){
     	    $consulta2="DELETE FROM calificaciones WHERE id_calificacion = $id_calificacion";
             $resultado2= (mysqli_query ($link, $consulta2) or die ('Consulta fallida 21: ' .mysqli_error($link)));
             if($resultado2){
             echo "<script > alert('Calificacion eliminada exitosamente');window.location='verHistorialViajes.php'</script>";
         }
     }
     if((!$resultado) or (!$resultado2)){
     	echo "<script > alert('La calificacion no se pudo eliminar');window.location='verHistorialViajes.php'</script>";
     }

 }else{
   echo "<script > alert('La calificacion no se pudo eliminar');window.location='verHistorialViajes.php'</script>";
 }
 ?>

