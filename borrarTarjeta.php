<?php
    include "BD.php";// conectar y seleccionar la base de datos
    $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    $id_tarjeta=$_POST['id_tarjeta'];
    $estado= $_POST['vip'];
    $aux= true;
    if (!$estado){
    $consulta="DELETE FROM tarjetas_clientes WHERE id_tarjeta = $id_tarjeta";
    $resultado= (mysqli_query ($link, $consulta) or die ('Consulta fallida: ' .mysqli_error($link)));
    if($resultado){
    	    $consulta2="DELETE FROM tarjetas WHERE id_tarjeta = $id_tarjeta";
            $resultado2= (mysqli_query ($link, $consulta2) or die ('Consulta fallida: ' .mysqli_error($link)));
            if($resultado2){
            echo "<script > alert('La tajeta fue eliminada exitosamente');window.location='verPerfilDeUsuario.php'</script>";
        }
    }}
    else{
      $consulta3= "SELECT id_tarjeta FROM tarjetas_clientes where (id_cliente= $id) " ;
      $resultado3= mysqli_query($link,$consulta3) or die ('Consulta fallida 22: ' .mysqli_error($link));
      echo '24';
      echo $id;
      echo '----';
      echo $id_tarjeta;
      if ($resultado3){
        echo '26    ';
      //  var_dump($resultado3);
        while (($valores = mysqli_fetch_array($resultado3)) and ($aux) ){
          echo '28';
          if ($valores['id_tarjeta']<> $id_tarjeta){
            echo '30';
            $aux= false;
            $tarjeta_nueva= $valores['id_tarjeta'];
            $consulta5="UPDATE tarjetas_clientes SET vip='1' WHERE (id_tarjeta = $tarjeta_nueva) " ;
              $resultado5 =mysqli_query ($link, $consulta5) or die ('Consulta alta vip fallida: ' .mysqli_error($link));

              $consulta11="DELETE FROM tarjetas_clientes WHERE id_tarjeta = $id_tarjeta";
              $resultado11= (mysqli_query ($link, $consulta11) or die ('Consulta fallida: ' .mysqli_error($link)));
              if($resultado11){
              	    $consulta20="DELETE FROM tarjetas WHERE id_tarjeta = $id_tarjeta";
                      $resultado20= (mysqli_query ($link, $consulta20) or die ('Consulta fallida: ' .mysqli_error($link)));
                      if($resultado20){
                      echo "<script > alert('La tajeta fue eliminada exitosamente');window.location='verPerfilDeUsuario.php'</script>";
                  }
              }
          }
          }
    }
  }
    if((!$resultado) or (!$resultado2)){
    	echo "<script > alert('La tajeta no se pudo eliminar');window.location='verPerfilDeUsuario.php'</script>";
    }
?>
