<?php
    //Obtener el la configuracion del contenedor de vista
    $Tipo='Perfil';
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
                    //echo '<td class="text-uppercase">'.$mq[$z["nombresql"]].'</td>';

                    if($z["nombresql"]=="activo")
                    {
                      if($mq[$z["nombresql"]]==0)
                      {
                        echo '<td class="text-uppercase"><span estado="0" class="label label-danger">Desactivado</span></td>';

                      }else{
                        echo '<td class="text-uppercase"><span estado="1" class="label label-success">Activado</span></td>';

                      }
                    }
                    else {
                      echo '<td class="text-uppercase">'.$mq[$z["nombresql"]].'</td>';
                    }



                  }
                  else 
                  {
                    echo '<td class="text-uppercase"> -- </td>';
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
MODAL AGREGAR PERFIL
======================================-->
  <?php   
       if (isset($rol_perfil)) {
              if($rol_crear){  

  ?>  

<div id="modalAgregarPerfil" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Perfil</h4>
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
                  <input type="text" class="form-control input-lg" name="nuevoCodigo" placeholder="Codigo" required>
                </div>
              </div>
              <!-- ENTRADA PARA LA DESCRIPCION -->
              <div class="col-xs-6">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoPerfil" placeholder="Ingresar Perfil" required>
                </div>
              </div>  
               <!-- CHECK DE ACTIVO -->
              <div class="col-xs-2">
                <div class="form-group">  
                <label>
                      <input type="checkbox" class="minimal" name="nuevoEstado" checked> Activo              
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
          $crearPerfil = new ControladorPerfil();
          $crearPerfil -> ctrCrearPerfil();
        ?>

      </form>
    </div>
  </div>
</div>

  <?php   } }  ?>

<!--=====================================
MODAL EDITAR PERFIL
======================================-->
<?php
if (isset($rol_perfil)) {

// Verificar si tiene el permiso de modificar
$i = array_search("Perfil_Modificar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalModificarPerfil" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modificar Perfil</h4>
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
                  <input type="text" class="form-control input-lg" name="modificarCodigo" id="modificarCodigo" placeholder="Codigo" required>
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
      
          $editarPerfil = new ControladorPerfil();
          $editarPerfil -> ctrModificarPerfil();
          
        ?> 

      </form>
    </div>
  </div>
</div>
<?php } } ?>

<!--=====================================
MODAL ASIGNAR PERMISOS AL PERFIL
======================================-->
<?php
if (isset($rol_perfil)) {

// Verificar si tiene el permiso de modificar
$i = array_search("Perfil_Asignar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalAsignarPerfil" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Asignar permisos al perfil</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">

                  <div class="col-xs-4">
                    <label for="sel1">Lista de Roles: </label>
                    <select class="form-control" name="origen[]" id="origen" multiple="multiple" size="25" style="overflow:scroll;">                    
                    </select>

                  </div>
                  <div class="col-xs-4" style="text-align: center">
                    <input type="button" class="btn btn-primary pasar izq" value="Pasar »" style="margin: 25px 1px 0 1px" >
                    <input type="button" class="btn btn-primary quitar der" value="« Quitar" style="margin: 25px 1px 0 1px">
                    <br />
                    <input type="button" class="btn btn-info pasartodos izq" value="Todos »" style="margin: 25px 1px 0 1px">
                    <input type="button" class="btn btn-info quitartodos der" value="« Todos" style="margin: 25px 1px 0 1px">
                  </div>

                  <div class="col-xs-4">
                    <label for="sel1">Asignados</label>
                    <select class="form-control"  name="destino[]" id="destino" multiple="multiple" size="25" style="overflow:scroll;">

                    </select>

                  </div>
                    <input type="hidden"  name="idPerfilp" id="idPerfilp" required>
            </div>

          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary guardarpermisos">Guardar cambios</button>
        </div>

      <?php
      
          $asignarPermisosPerfil = new ControladorPerfil();
          $asignarPermisosPerfil -> ctrAsignarPermisosPerfil();
      
        ?> 

      </form>
    </div>
  </div>
</div>
<?php } } ?>


<!--=====================================
MODAL ASIGNAR MENU AL PERFIL
======================================-->
<?php
if (isset($rol_perfil)) {

// Verificar si tiene el permiso de modificar
$i = array_search("Perfil_AsignarMenu", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalAsignarMenuPerfil" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Asignar menú al perfil</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">

                  <div class="col-xs-4">
                    <label for="sel1">Lista de Menus: </label>
                    <select class="form-control" name="morigen[]" id="morigen" multiple="multiple" size="25" style="overflow:scroll;">                    
                    </select>

                  </div>
                  <div class="col-xs-4" style="text-align: center">
                    <input type="button" class="btn btn-primary mpasar izq" value="Pasar »" style="margin: 25px 1px 0 1px" >
                    <input type="button" class="btn btn-primary mquitar der" value="« Quitar" style="margin: 25px 1px 0 1px">
                    <br />
                    <input type="button" class="btn btn-info mpasartodos izq" value="Todos »" style="margin: 25px 1px 0 1px">
                    <input type="button" class="btn btn-info mquitartodos der" value="« Todos" style="margin: 25px 1px 0 1px">
                  </div>

                  <div class="col-xs-4">
                    <label for="sel1">Asignados</label>
                    <select class="form-control"  name="mdestino[]" id="mdestino" multiple="multiple" size="25" style="overflow:scroll;">

                    </select>

                  </div>
                    <input type="hidden"  name="idPerfilm" id="idPerfilm" required>
            </div>

          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary mguardarpermisos">Guardar cambios</button>
        </div>

      <?php
      
          $asignarMenuPerfil = new ControladorPerfil();
          $asignarMenuPerfil -> ctrAsignarMenuPerfil();
      
        ?> 

      </form>
    </div>
  </div>
</div>
<?php } } ?>



<!--=====================================
ELIMINAR PERFIL
======================================-->

<?php

  $borrarPerfil = new ControladorPerfil();
  $borrarPerfil -> ctrBorrarPerfil();

?>


