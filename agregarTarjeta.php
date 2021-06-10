<?php
    include "BD.php";// conectar y seleccionar la base de datos
    $link = conectar();
    include "validarLogin.php";
    $usuario= new usuario();
    $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
    $usuario ->id($id);
    include "menu.php";

?>

  <html>
  <head>
    <title>Agregar tarjeta</title>
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

 <?php     
                 if(!empty($_GET['numero'])){
                     $numero=$_GET['numero'];}
                 else{
                     $numero="";
                 }
                 if(!empty($_GET['seguridad'])){
                     $seguridad=$_GET['seguridad'];
                 }else{
                     $seguridad="";
                 }
                 if (!empty($_GET['fecha'])) {
                        $fcha=$_GET['fecha'];
                 }else{  
           $fcha = date("Y-m");}?>
    <center>
    <form action="validarDatosTarjeta.php" method="post">
     <h1>Nueva tarjeta </h1>   
        <input type="text" name="numero" size=50 placeholder="Numero de tarjeta" value="<?php echo $numero ?>" required="" ><br><br>          
        <input type="password" name="seguridad" size=50 placeholder="Codigo de seguridad " value="<?php echo $seguridad ?>" required=""><br><br>
        <input type="month" name="fecha" id="fecha" class="form-control" value="<?php echo $fcha ?>" required=""><br><br>
        <input type="hidden"name="id" value="<?php echo $id;?>">      
        <input type="submit" value="Guardar">
        <input type= "reset" value= "Borrar">
        <input type="button" name="Cancelar" value="Cancelar" onClick="location.href='verPerfilDeUsuario.php'"> 
    </form>
</center>

  </body>
</html>

