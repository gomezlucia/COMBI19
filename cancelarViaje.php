<?php

    include "BD.php";// conectar y seleccionar la base de datos
    //  echo "DALEEE";
   $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    $id_viaje_original=$_POST['id_viaje'];
    $consulta0="SELECT cupo FROM viajes WHERE (id_viaje= '$id_viaje_original')";
    $result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));
  //  echo '1';
    if ($result0){
        $valores = mysqli_fetch_array($result0);
        //echo '2';
        $consulta1="SELECT id_viaje FROM viajes_servicios_adicionales WHERE (id_viaje= '$id_viaje_original')";
        $result1=mysqli_query ($link, $consulta1) or die ('Consuluta query1 fallida 11: ' .mysqli_error($link));
      //  echo "result0";
        //  echo "result0 cupo 0";
          if ($result1){
          //  echo '3';
          //  echo "valores1                     ";
            $valores1 = mysqli_fetch_array($result1);
            //var_dump($valores1);
            while (($valores1 = mysqli_fetch_array($result1)) ){
              //echo "valores1";
            $consulta="DELETE FROM viajes_servicios_adicionales WHERE id_viaje = '$id_viaje_original' ";
            $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida 18: ' .mysqli_error($link)));
          //  echo '4';
        }}
      //  echo $id_viaje_original;
      if ($valores['cupo']=='0'){
        $consulta3="DELETE FROM viajes WHERE id_viaje =  $id_viaje_original ";
        $resultado3= (mysqli_query ($link, $consulta3) or die ('Consulta fallida 13: ' .mysqli_error($link)));
        //echo '5';
      }
      else{
      $consulta4="UPDATE clientes_viajes set estado ='cancelado' WHERE id_viaje= '$id_viaje_original' " ;
        $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
        //echo '6';
        if ($result4){
          $consulta5="UPDATE viajes SET debaja='1' WHERE (id_viaje= '$id_viaje_original') " ;
            $result5 =mysqli_query ($link, $consulta5) or die ('Consuluta query4 fallida 15: ' .mysqli_error($link));
          //  echo '7';
        }
      }

    if (($resultado3) or ($result5)){

      echo "<script > alert('Viaje eliminado exitosamente');window.location='viajes.php'</script>";

        }
}else{
echo "<script > alert('El viaje no se pudo eliminar');window.location='viajes.php'</script>";
}
//return $exito;

?>
