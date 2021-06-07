<?php
    include "BD.php";// conectar y seleccionar la base de datos
    $link = conectar();
    include "validarLogin.php";
  //    echo "<script > alert('Viaje eliminado exitosamente');window.location='darDebajaRuta.php'</script>";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    $debaja = false;
    $id_ruta_original=$_POST['ruta'];
    echo $id_ruta_original."<br>";
    $consulta0="SELECT id_viaje  FROM viajes WHERE (id_ruta= '$id_ruta_original')";
    $result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));
    echo 'hola1';
    if ($result0){
        echo '3';
        var_dump($result0);
        while($valores = mysqli_fetch_array($result0)){
          $id_viaje=$valores['id_viaje'];
          echo '4';
    //      echo date("Y"), date("m"), date("d");
        //  echo $hoy;
        $consulta2="SELECT estado FROM clientes_viajes WHERE (id_viaje= '$id_viaje')";
        $result2=mysqli_query ($link, $consulta2) or die ('Consuluta query1 fallida 12: ' .mysqli_error($link));
        echo '5';
        while (($valores1 = mysqli_fetch_array($result2)) and ($debaja== false)){
          echo '6';
          if ($valores1['estado']=='en curso'){
              echo "<script > alert('La ruta no puede ser eliminada ya que hay un viaje en curso por dicha ruta');window.location='listarRutas.php'</script>";
          } else {
          echo '7';
          $debaja= true;
        }
      }
      }
} else {
  $consulta1="DELETE FROM rutas WHERE id_ruta = '$id_ruta_original' ";
  $resultado1= (mysqli_query ($link, $consulta1) or die ('Consulta fallida 11: ' .mysqli_error($link)));
  echo "<script > alert('ruta eliminada de la base de datos');window.location='listarRutas.php'</script>";
}
if ($debaja== true){
  echo '8';
  echo $id_viaje;
  $hecho = cancelarViaje($id_viaje);
    echo '9';
  $consulta4="UPDATE rutas set debaja ='1' WHERE id_ruta= '$id_ruta_original' " ;
    $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
      echo "<script > alert('ruta dada de baja en la bd');window.location='listarRutas.php'</script>";
}

function cancelarViaje($id_viaje_original){
//    $id_viaje_original=$_POST['id_viaje'];
  echo '1funnnnnnnnnnnnnnnn';
  $consulta0f="SELECT cupo FROM viajes WHERE (id_viaje= '$id_viaje_original')";
  var_dump($consulta0f);
  $result0f= (mysqli_query ($link, $consulta0f) or die ('Consuluta query4 fallida 10: ' .mysqli_error($link))) ;

  echo '2funnnnnnnnnnnnnnnn';
  var_dump($result0f);

  if ($result0f){
      $valoresf = mysqli_fetch_array($result0f);
      //echo '2';
      $consulta1f="SELECT id_viaje FROM viajes_servicios_adicionales WHERE (id_viaje= '$id_viaje_original')";
      $result1f=mysqli_query ($link, $consulta1f) or die ('Consuluta query1 fallida 11: ' .mysqli_error($link));
    //  echo "result0";
      //  echo "result0 cupo 0";
        if ($result1f){
        //  echo '3';
        //  echo "valores1                     ";
          $valores1f = mysqli_fetch_array($result1f);
          //var_dump($valores1);
          while (($valores1f = mysqli_fetch_array($result1f)) ){
            //echo "valores1";
          $consultaf="DELETE FROM viajes_servicios_adicionales WHERE id_viaje = '$id_viaje_original' ";
          $resultadof= (mysqli_query ($link, $consultaf) or die ('Consulta fallida 18: ' .mysqli_error($link)));
        //  echo '4';
      }}
    //  echo $id_viaje_original;
    if ($valoresf['cupo']=='0'){
      $consulta3f="DELETE FROM viajes WHERE id_viaje =  $id_viaje_original ";
      $resultado3f= (mysqli_query ($link, $consulta3f) or die ('Consulta fallida 13: ' .mysqli_error($link)));
      //echo '5';
    }
    else{
    $consulta4f="UPDATE clientes_viajes set estado ='cancelado' WHERE id_viaje= '$id_viaje_original' " ;
      $result4f=mysqli_query ($link, $consulta4f) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
      //echo '6';
      if ($result4f){
        $consulta5f="UPDATE viajes SET debaja='1' WHERE (id_viaje= '$id_viaje_original') " ;
          $result5f =mysqli_query ($link, $consulta5f) or die ('Consuluta query4 fallida 15: ' .mysqli_error($link));
        //  echo '7';
      }
    }
  if ((isset($resultado3f)) or (isset($result5f))) {
    $exito= true;
      }
}else{
$exito= false;
}
return $exito;
}

?>
