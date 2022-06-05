<?php

  $Tabla=ControladorModulo::$tabla;

   //Obtener el la configuracion del contenedor de vista

   $menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tabla,$_SESSION["idperfil"]);
  //Obtener rol de crear
   $rol_crear = ControladorContenedorVista::ctrObtenerRolCrearPerfil($Tabla,$_SESSION["idperfil"]);
   //Obtener permisos de perfil
   $rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($Tabla,$_SESSION["idperfil"]);
//var_dump($menu_usuario);
/*-=====================================
VISTA ADMINISTRATIVA MODULO
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
MODAL AGREGAR MODULO
======================================-->
<?php
if (isset($rol_perfil)) {
// Verificar si tiene el permiso de crear
$a = array_search("Modulo_Crear", array_column($rol_crear, 2));
//var_dump($i);
if($a!==false){


          /*-== FORMULARIO ==*/
          $Formulario_Agregar = p_formulario ($Tabla,AGREGAR);

          /*-== MODULO - CABEZA FORMULARIO AGREGAR ==*/
          echo $Formulario_Agregar["Cabeza"];
?>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">
                            <!-- ENTRADA PARA LA DESCRIPCION -->
                            <div class="col-xs-6">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoModulo" placeholder="Ingresar Modulo" required>
                              </div>
                            </div>
                            <!-- ENTRADA PARA EL ORDEN -->
                            <div class="col-xs-6">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                <input type="number" class="form-control input-lg" name="nuevoOrden" placeholder="Ingresar Orden" required>
                              </div>
                            </div>
                          </div>

          </div>
        </div>

        <?php

          /*-== MODULO - PIE FORMULARIO AGREGAR ==*/
          echo $Formulario_Agregar["Pie"];

          $crearModulo = new ControladorModulo();
          $crearModulo -> ctrCrearModulo();

          /*-== MODULO - CIERRE FORMULARIO AGREGAR ==*/
          echo $Formulario_Agregar["Cierre"];
        ?>



<?php   } }  ?>

<!--=====================================
MODAL EDITAR MODULO
======================================-->
<?php
if (isset($rol_perfil)) {
// Verificar si tiene el permiso de modificar
$i = array_search("Modulo_Modificar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){


          /*-== FORMULARIO ==*/
          $Formulario_Editar = p_formulario ($Tabla,EDITAR);

          /*-== MODULO - CABEZA FORMULARIO EDITAR ==*/
          echo $Formulario_Editar["Cabeza"];
?>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">
              <!-- ENTRADA PARA LA DESCRIPCION -->
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg" name="editarModulo" id="editarModulo" placeholder="Ingresar Modulo" required>
                  <input type="hidden"  name="idModulo" id="idModulo" required>
                </div>
              </div>
              <!-- ENTRADA PARA EL ORDEN -->
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                  <input type="number" class="form-control input-lg" name="editarOrden" id="editarOrden" placeholder="Ingresar Orden" required>
                </div>
              </div>
            </div>

          </div>
        </div>

      <?php
          /*-== MODULO - PIE FORMULARIO EDITAR ==*/
          echo $Formulario_Editar["Pie"];

          /*-== EJECUCION ==*/
          $editarModulo = new ControladorModulo();
          $editarModulo -> ctrEditarModulo();

          /*-== MODULO - CIERRE FORMULARIO EDITAR ==*/
          echo $Formulario_Editar["Cierre"];
        ?>

<?php } } ?>

<!--=====================================
ELIMINAR MODULO
======================================-->

<?php

  $borrarModulo = new ControladorModulo();
  $borrarModulo -> ctrBorrarModulo();

?>


<!--=====================================
MODAL IMPORTAR MODULO
======================================-->
<?php
if (isset($rol_perfil)) {
$b = array_search("Modulo_Importar", array_column($rol_crear, 2));
//var_dump($i);
if($b!==false){


          /*-== FORMULARIO DE IMPORTAR ==*/
          $VistaImportar = p_importar($Tabla);
          echo $VistaImportar["Cuerpo"];

          /*-== EJECUCION ==*/
          $importarModulo = new ControladorModulo();
          $importarModulo -> ctrImportarModulo();

          /*-== CIERRE DE FORMULARIO ==*/
          echo $VistaImportar["Cierre"];
   }
 }
?>

<!--=====================================
MODAL EXPORTAR MODULO
======================================-->
<?php
if (isset($rol_perfil)) {
$c = array_search("Modulo_Exportar", array_column($rol_crear, 2));

if($c!==false){

          /*-== FORMULARIO DE EXPORTAR ==*/
          $VistaExportar = p_exportar($Tabla,$_SESSION["idperfil"]);
          echo $VistaExportar["Cuerpo"];

 }
}
?>
