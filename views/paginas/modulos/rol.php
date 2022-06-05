<?php
    //Obtener el la configuracion del contenedor de vista
    $Tipo='Rol';
    $menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tipo,$_SESSION["idperfil"]);
   //Obtener rol de crear
    $rol_crear = ControladorContenedorVista::ctrObtenerRolCrearPerfil($Tipo,$_SESSION["idperfil"]);
    //Obtener permisos de perfil
    $rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($Tipo,$_SESSION["idperfil"]);
    //var_dump($rol_perfil);

    if ($menu_usuario) {
     
  
?>


<div class="content-wrapper">
  <section class="content-header">
  
    <h1><?php echo $menu_usuario["descripcion"]; ?></h1>

    <ol class="breadcrumb"> 
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>  
      <li class="active">Administrar <?php echo $Tipo; ?></li>
    </ol>

  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <?php 
          if (isset($rol_crear)) 
          {
              
            if($rol_crear) //Asignar Boton de creación
            {
                  echo '<button class="'.$rol_crear["tipo_boton"].'" data-toggle="modal" data-target="#'.$rol_crear["modal"].'">         
                        '.$rol_crear["descripcion"].'
                        </button>';
            }
          }


        ?>

      </div>

    <div class="box-body" id="ta">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>

<?php
          // Obtener Consulta
          $menu_query = ControladorContenedorVista::ctrObtenerConsultaVista($menu_usuario["consulta"]);

          // Obtener Columnas
          $menu_columnas = ControladorContenedorVista::ctrObtenerColumnasVista($menu_usuario["IDConfigVista"]);

          foreach ($menu_columnas as $key => $mc) 
          {
            //Obtener cabeceras
            echo '<th style="width:'.$mc["ancho"].'px">'.$mc["texto"].'</th>'; 
          }
?>

           <th>ACCIONES</th>
         </tr> 
        </thead>
        <tbody>

<?php
//Recorrer cada query
         foreach ($menu_query as $k => $mq) 
         {
          echo '<tr>';
          //Recorrer cada columna
            foreach ($menu_columnas as $y => $z) 
            {
                  if (isset($mq[$z["nombresql"]]))
                  {
                    echo '<td>'.$mq[$z["nombresql"]].'</td>';
                  }
                  else 
                  {
                    echo '<td> -- </td>';
                  }
              
            }
               echo '<td>
                    <div class="btn-group">';
          //Recorrer cada permiso para colocarlo en boton
                  if (isset($rol_perfil)) 
                  { 
                    if($rol_perfil)
                    {
                      foreach ($rol_perfil as $x => $p) 
                      {     
                              echo '<spam data-toggle="tooltip" data-placement="top" title="'.$p["descripcion"].'">';
                              echo '<button class="'.$p["tipo_boton"].' '.$p["nombre_boton"].'" id'.$p["tipo"].'="'.var_encripta($mq["id"]).'"';
                              if($p["modal"]<>'') // Modificar
                                  {
                                   echo ' data-toggle="modal" data-target="#'.$p["modal"].'"> <i class="'.$p["icono"].'"></i></button> </spam>';
                                   
                                  } 
                              else //Acceso Eliminar
                                  {
                                    echo '> <i class="'.$p["icono"].'"></i></button> </spam>';
                                  }                           
                      }
                    }
                  }

               echo '</div>  
                    </td>  
                  </tr>';
          }


?>

        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>

<?php 

    }
    else {
      include "404.php";
    }
?>

<!--=====================================
MODAL AGREGAR ROL
======================================-->
  <?php   
       if (isset($rol_perfil)) {
              if($rol_crear){  

  ?>  

<div id="modalAgregarRol" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Rol</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">
              <!-- ENTRADA PARA EL CODIGO -->
              <div class="col-xs-3">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoCodigo" placeholder="Codigo" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL ROL -->
              <div class="col-xs-4">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoRol" placeholder="Rol" required>
                </div>
              </div> 
               <!-- ENTRADA PARA LA DESCRIPCION -->
              <div class="col-xs-5">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoDescripcion" placeholder="Ingresar Descripcion" required>
                </div>
              </div>

            </div>

            <div class="form-group row">
              <!-- ENTRADA PARA EL TIPO DE BOTON -->
              <div class="col-xs-3">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-edit"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoTipoBoton" placeholder="Tipo Boton" required>
                </div>
              </div>
              <!-- ENTRADA PARA NOMBRE BOTON -->
              <div class="col-xs-4">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-edit"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoBoton" placeholder="Nombre boton" required>
                </div>
              </div> 
               <!-- ENTRADA PARA EL MODAL -->
              <div class="col-xs-5">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-edit"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoModal" placeholder="Ingresar Modal" required>
                </div>
              </div>

            </div>

            <div class="form-group row">
              <!-- ENTRADA PARA EL ORDEN -->
              <div class="col-xs-3">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-cog"></i></span> 
                  <input type="number" class="form-control input-lg" name="nuevoOrden" placeholder="Orden" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL TIPO DE OBJETO-->
              <div class="col-xs-4">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-cogs"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoTipo" id="nuevoTipo" placeholder="Nombre Tipo" required>
                </div>
              </div>
               <!-- ENTRADA PARA EL NOMBRE ICONO  -->
              <div class="col-xs-5">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-cogs"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoIcono" placeholder="Ingresar Icono" required>
                </div>
              </div>

            </div>

            <div class="form-group row">

              <!-- CHECK DE ES CREACION -->
              <div class="col-xs-3">
                <div class="form-group">  
                <label>
                      <input type="checkbox" class="minimal" name="nuevoCreacion" checked> ES DE CREACIÓN              
                </label>            
                </div>
              </div> 

              <!-- CHECK DE AUDITABLE -->
              <div class="col-xs-3">
                <div class="form-group">  
                <label>
                      <input type="checkbox" class="minimal" name="nuevoAuditable" checked> ES AUDITABLE              
                </label>            
                </div>
              </div> 

            </div>

          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Perfil</button>
        </div>

        <?php
          $crearRol = new ControladorRol();
          $crearRol -> ctrCrearRol();
        ?>

      </form>
    </div>
  </div>
</div>

  <?php   } }  ?>

<!--=====================================
MODAL EDITAR ROL
======================================-->
<?php
if (isset($rol_perfil)) {

// Verificar si tiene el permiso de modificar
$i = array_search("Rol_Modificar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalModificarRol" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modificar Rol</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">
              <!-- ENTRADA PARA EL CODIGO -->
              <div class="col-xs-4">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="modificarCodigo" id="modificarCodigo"  placeholder="Codigo"  required>
                  <input type="hidden"  name="idPerfil" id="idPerfil" required>
                </div>
              </div>
              <!-- ENTRADA PARA LA DESCRIPCION -->
              <div class="col-xs-6">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="modificarPerfil"  id="modificarPerfil" placeholder="Ingresar Perfil" required>
                </div>
              </div>  
               <!-- CHECK DE ACTIVO -->
              <div class="col-xs-2">
                <div class="form-group">  
                <label>
                      <input type="checkbox"  class="minimal" name="modificarEstado" id="modificarEstado"> Activo              
                </label>            
                </div>
              </div> 

            </div>

          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

      <?php
      
          //$editarRol = new ControladorRol();
          //$editarRol -> ctrModificarRol();
          
        ?> 

      </form>
    </div>
  </div>
</div>
<?php } } ?>



<!--=====================================
ELIMINAR ROL
======================================-->

<?php

  //$borrarRol = new ControladorRol();
  //$borrarRol -> ctrBorrarRol();

?>


