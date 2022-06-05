<?php
  $Tabla=ControladorMenu::$tabla;

   //Obtener el la configuracion del contenedor de vista
  
   $menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tabla,$_SESSION["idperfil"]);
  //Obtener rol de crear
   $rol_crear = ControladorContenedorVista::ctrObtenerRolCrearPerfil($Tabla,$_SESSION["idperfil"]);
   //Obtener permisos de perfil
   $rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($Tabla,$_SESSION["idperfil"]);

/*-=====================================
VISTA ADMINISTRATIVA MENU
======================================*/
   if ($menu_usuario) 
   { 

    $VistaPrincipal = p_vista($menu_usuario,$rol_crear,$rol_perfil);
    echo $VistaPrincipal;

   }
  else {
    include "404.php";
  } 

?>


<!--=====================================
MODAL AGREGAR MENU
======================================-->
  <?php  
if (isset($rol_perfil)) {
 
  // Verificar si tiene el permiso de crear
  $a = array_search("Menu_Crear", array_column($rol_crear, 2));
  //var_dump($i);
  if($a!==false){


  ?>  

<div id="modalAgregarMenu" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Menú</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

        <!-- ENTRADA PARA EL MODULO -->
            <div class="form-group">             
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg" id="nuevoModulo" name="nuevoModulo" required>                  
                  <option value="">Selecionar Modulo</option>
                    <?php
                    // Obtener los modulos del sistema  
                    $item = null;
                    $valor = null;
                    $modulos = ControladorModulo::ctrMostrarModulo($item, $valor);
                    foreach ($modulos as $key => $v) 
                    {
                      echo '<option value="'.var_encripta($v["pkid"]).'">'.$v["modulo"].'</option>';
                    }

                    ?>
  
                </select>
              </div>
            </div>
        <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">             
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-angle-right"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoMenu" placeholder="Ingresar Menu" required>
              </div>
            </div>
        <!-- ENTRADA PARA LOS LINKS E ICONOS -->           
            <div class="form-group row">
              <!-- ENTRADA PARA EL LINK -->
              <div class="col-xs-6">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-link"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevolink" placeholder="Ingresar Link acceso" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL ICONO -->
              <div class="col-xs-6">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-hand-o-right"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoIcono" placeholder="Ingresar icono fa" required>
                </div>
              </div>  
            </div>
        <!-- ENTRADA PARA LA DESCRIPCION -->
            <div class="form-group">             
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-indent"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar Descripcion" required>
              </div>
            </div>
        <!-- ENTRADA PARA EL CONTENEDOR VISTA -->
            <div class="form-group">             
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg" id="nuevoContenedor" name="nuevoContenedor" required>                  
                  <option value="">Selecionar Contenedor</option>
                    <?php
                    // Obtener los modulos del sistema  
                    $item = null;
                    $valor = null;
                    $modulos = ControladorContenedorvista::ctrMostrarContenedorVista($item, $valor);
                    foreach ($modulos as $key => $v) 
                    {
                      echo '<option value="'.var_encripta($v["pkid"]).'">'.$v["Configuracion"].'</option>';
                    }

                    ?>
  
                </select>
              </div>
            </div>

          </div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Menú</button>
        </div>

        <?php
          $crearMenu = new ControladorMenu();
          $crearMenu -> ctrCrearMenu();
        ?>

      </form>
    </div>
  </div>
</div>

<?php   } }  ?>

<!--=====================================
MODAL EDITAR MENU
======================================-->
<?php
if (isset($rol_perfil)) {

// Verificar si tiene el permiso de modificar
$i = array_search("Menu_Modificar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalModificarMenu" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modificar Menú</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

        <!-- ENTRADA PARA EL MODULO -->
            <div class="form-group">             
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg seleccionarModulo" id="modificarIDModulo" name="modificarIDModulo" required>                  
                  <option class="modificarModulo"></option>
                    <?php
                    
                    // Obtener los modulos del sistema  
                    $item = null;
                    $valor = null;
                    $modulos = ControladorModulo::ctrMostrarModulo($item, $valor);
                    foreach ($modulos as $key => $v) 
                    {
                      echo '<option value="'.var_encripta($v["pkid"]).'">'.$v["modulo"].'</option>';
                    }
                    
                    ?>
                </select>
              </div>
            </div>
        <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">             
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-angle-right"></i></span> 
                <input type="text" class="form-control input-lg" name="modificarMenu" id="modificarMenu" placeholder="Ingresar Menu" required>
                <input type="hidden"  name="idMenu" id="idMenu" required>
              </div>
            </div>
        <!-- ENTRADA PARA LOS LINKS E ICONOS -->           
            <div class="form-group row">
              <!-- ENTRADA PARA EL LINK -->
              <div class="col-xs-6">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-link"></i></span> 
                  <input type="text" class="form-control input-lg" name="modificarLink" id="modificarLink" placeholder="Ingresar Link" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL ICONO -->
              <div class="col-xs-6">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-hand-o-right"></i></span> 
                  <input type="text" class="form-control input-lg" name="modificarIcono" id="modificarIcono" placeholder="Ingresar icono" required>
                </div>
              </div>  
            </div>
        <!-- ENTRADA PARA LA DESCRIPCION -->
            <div class="form-group">             
              <div class="input-group">          
                <span class="input-group-addon"><i class="fa fa-indent"></i></span> 
                <input type="text" class="form-control input-lg" name="modificarDescripcion" id="modificarDescripcion" placeholder="Ingresar Descripcion" >
              </div>
            </div>
        <!-- ENTRADA PARA EL CONTENEDOR VISTA -->
            <div class="form-group">             
              <div class="input-group">              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <select class="form-control input-lg seleccionarContenedor" id="modificarIDContenedor" name="modificarIDContenedor" required>                  
                  <option class="modificarContenedor"></option>
                    <?php
                    
                    // Obtener los modulos del sistema  
                    $item = null;
                    $valor = null;
                    $modulos = ControladorContenedorvista::ctrMostrarContenedorVista($item, $valor);
                    foreach ($modulos as $key => $v) 
                    {
                      echo '<option value="'.var_encripta($v["pkid"]).'">'.$v["Configuracion"].'</option>';
                    }
                    
                    ?>
                </select>
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
          $editarMenu = new ControladorMenu();
          $editarMenu -> ctrModificarMenu();
        ?> 

      </form>
    </div>
  </div>
</div>

<?php } } ?>

<!--=====================================
ELIMINAR MENU
======================================-->

<?php

  $borrarMenu = new ControladorMenu();
  $borrarMenu -> ctrBorrarMenu();

?>


