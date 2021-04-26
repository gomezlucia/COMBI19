<?php
	include "BD.php";// conectar y seleccionar la base de datos
	$link = conectar();
?>
<!DOCTYPE html>
<html>
<head>
	<title>prueba</title>
	<h1>Prueba combi 19</h1>
</head>
<body>
    
    <p>Tipos de combis
      <select>
        <option value="0">Seleccione:</option>
        <?php
          $consulta= "SELECT * FROM tipos_combi";
          $resultado= mysqli_query($link,$consulta) or die ('Consulta fallida: ' .mysqli_error($link));
          while ($valores = mysqli_fetch_array($resultado)) {
            echo '<option value="' . $valores["id_tipo_combi"] . '">' . $valores["nombre_tipo"] . '</option>';
          }
        ?>
      </select>
</body>
</html>