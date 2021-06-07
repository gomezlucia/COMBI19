<?php
    include "BD.php";// conectar y seleccionar la base de datos
    $link = conectar();
    include "validarLogin.php";
    include "cancelarViaje.php";
  //    echo "<script > alert('Viaje eliminado exitosamente');window.location='darDebajaRuta.php'</script>";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);

    $debaja = false;
    $id_ruta_original=$_POST['id_ruta'];

    $consulta0="SELECT id_viaje  FROM viajes WHERE (id_ruta= '$id_ruta_original')";
    $result0=mysqli_query ($link, $consulta0) or die ('Consuluta query1 fallida 10: ' .mysqli_error($link));
    echo 'hola1';
    if ($result0){
        echo '3';
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
          }
        else {
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
  $hecho = cancelarViaje($id_viaje);
    echo '9';
  $consulta4="UPDATE rutas set debaja ='1' WHERE id_ruta= '$id_ruta_original' " ;
    $result4=mysqli_query ($link, $consulta4) or die ('Consuluta query4 fallida 14: ' .mysqli_error($link));
      echo "<script > alert('ruta dada de baja en la bd');window.location='listarRutas.php'</script>";
}
?>
