<?php function menu($id,$link){
         $consulta="SELECT tipo_usuario,nombre_usuario FROM usuarios WHERE id_usuario='$id'"; 
         $resultado=mysqli_query($link,$consulta) or  die ('Consulta fallida: ' .mysqli_error());
         $usuario=mysqli_fetch_array ($resultado); ?>  
     <div class="btn-menu">
          <label for="btn-menu">☰</b></p></label>
    </div>
     <input type="checkbox" id="btn-menu">
     <div class="container-menu">
         <div class="cont-menu">
         <label for="btn-menu">✖️</label>
<?php    
         if ($usuario['tipo_usuario']=='cliente'){ ?> 
             <nav>
                 <a href="verHistorialViajes.php"> Historial de viajes </a>
                 <a href="verPerfilDeUsuario.php"> Perfil</a>
                 <a href="cerrarSesion.php"> Cerrar Sesion </a> 
             </nav> 
<?php    } elseif ($usuario['tipo_usuario']=='chofer') { ?>
             <nav>
                 <a href="cerrarSesion.php"> Cerrar Sesion </a> 
             </nav>
<?php     } else { ?>
             <nav>
                 <a href="verListadoDeRutas.php"> Ver listado de rutas </a>
                 <a href="cargarRuta.php"> Cargar ruta </a>
                 <a href="verListadoDeCombis.php"> Ver listado de combis </a>
                <a href="verListadoDeAdicionales.php"> Ver listado de adicionales </a>
                 <a href="cargarCombi.php"> Cargar combis  </a>
                 <a href="registrarChoferes.php"> Registrar Chofer  </a>
                 <a href="verListadoDeChoferes.php"> Ver listado de choferes  </a>
                 <a href="cargarViaje.php"> Cargar viaje  </a>
                 <a href="viajes.php"> Ver listado de viajes  </a>
                 <a href="cerrarSesion.php"> Cerrar Sesion </a>
             <nav>
<?php    }    ?>       
    </div>
    </div>
<?php } ?>
