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
    } }

    if((!isset($resultado)) or (!isset($resultado2))) {
    	echo "<script > alert('La tajeta no se pudo eliminar');window.location='verPerfilDeUsuario.php'</script>";
    }
?>
