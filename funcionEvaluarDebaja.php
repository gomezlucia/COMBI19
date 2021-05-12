
 <?php

 include("BD.php");// conectar y seleccionar la base de datos
 $link=conectar();

if ($_POST['tipo']=="combi"){

$mensaje= "La combi fue dada de baja exitosamente" ;

$id_combi_act = $_POST['id_combi'];

  $consulta= "SELECT id_combi from viajes where (now()<=fecha_hora_salida) and id_combi='$id_combi_act'";

  $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));

  if ($resultado){

       if (mysqli_num_rows($resultado)>0){
          $mensaje='No se puede dar de baja las combis que tengan viajes asignados, por favor primero modifique los datos de esos viajes o cancele el viaje en caso de que tenga pasajes vendidos';
       }
       else{
      $consuluta="UPDATE combis SET debaja= '1' WHERE id_combi='$id_combi_act'";
      $resultado= (mysqli_query ($link, $consuluta) or die ('Consulta fallida: ' .mysqli_error($link)));

       }
     }

   echo "<script > alert( '$mensaje' );window.location='verListadoDeCombis.php'</script>";

}
else{

  $mensaje= "El chofer fue dada de baja exitosamente" ;

  $id_chofer_act = $_POST['id_chofer'];

    $consulta= "SELECT id_chofer from viajes where (now()<=fecha_hora_salida) and id_chofer='$id_chofer_act'";

    $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida40: ' .mysqli_error($link));

    if ($resultado){

         if (mysqli_num_rows($resultado)>0){
            $mensaje='No se puede dar de baja a choferes que tengan viajes asignados, por favor primero modifique los datos de esos viajes o cancele el viaje en caso de que tenga pasajes vendidos';
         }
         else{
        $consuluta="UPDATE usuarios SET debaja= '1' WHERE id_usuario='$id_chofer_act'";
        $resultado= (mysqli_query ($link, $consuluta) or die ('Consulta fallida49: ' .mysqli_error($link)));

         }
       }

     echo "<script > alert( '$mensaje' );window.location='verListadoDeChoferes.php'</script>";

}

?>
