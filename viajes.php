<?php
     include("BD.php");// conectar y seleccionar la base de datos
     $link=conectar();
     include "validarLogin.php";
     $usuario= new usuario();
     $usuario -> session ($nombreUsuario); //guarda en $nombreUsuario el valor que tiene la sesion (lo pasa por referencia)
     $usuario ->id($id);
     include "listarViajes.php";
     include "buscarCualquierViaje.php";
     include "menu.php";
     //muestra todos los viajes para eladministrador
?>
<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript" src="seguir.js"></script>
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
 <center>
      <h1>Viajes</h1>
     <?php
         try {
             $usuario -> iniciada($nombreUsuario); ?>
             <div  class="buscador_admi">
              <?php     
                 if(!empty($_GET['fecha_inicial'])){
                     $fecha_inicial=$_GET['fecha_inicial'];}
                 else{
                     $fecha_inicial="";
                 }
                 if(!empty($_GET['fecha_final'])){
                     $fecha_final=$_GET['fecha_final'];
                 }else{
                     $fecha_final="";
                 }
                 if (!empty($_GET['ruta'])) {
                        $ruta=$_GET['ruta'];
                 }else{
                    $ruta="";
                 }   
                
           echo buscar($link, $fecha_inicial, $fecha_final,$ruta); ?>
                
             </div>

     <?php       echo listarViajes($link,$usuario,$nombreUsuario,$id,false); ?>
                 </center>
            
</body>
<?php } catch (Exception $e) {
             $mensaje=$e->getMessage(); 
             echo "<script> alert('$mensaje');window.location='/COMBI19-main/inicioSesion.php'</script>";
                  //redirige a la pagina inicioSesion y muestra una mensaje de error
         }?>
</html>      
                 
        
           
                 
        
         
