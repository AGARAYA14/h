<?php
  $Tabla=ControladorMenu::$tabla;

   //Obtener el la configuracion del contenedor de vista
  
   $menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tabla,$_SESSION["idperfil"]);
  //Obtener rol de crear
   $rol_crear = ControladorContenedorVista::ctrObtenerRolCrearPerfil($Tabla,$_SESSION["idperfil"]);
   //Obtener permisos de perfil
   $rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($Tabla,$_SESSION["idperfil"]);
   //Obtener campos de tabla 
   $campos_tabla = ControladorContenedorVista::ctrObtenerCamposTabla($Tabla);

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

                  /*-== FORMULARIO ==*/
                  $Formulario_Agregar = p_formulario ($Tabla,AGREGAR);

                  /*-== Menu - CABEZA FORMULARIO AGREGAR ==*/
                  echo $Formulario_Agregar["Cabeza"];
          ?>  

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">
              <?php
                 //var_dump($campos_tabla);
                 echo p_campos_formulario($campos_tabla,AGREGAR);
              ?>
          </div>
        </div>

        <?php

          /*-== Menu - PIE FORMULARIO AGREGAR ==*/
          echo $Formulario_Agregar["Pie"];

          $crearMenu = new ControladorMenu();
          $crearMenu -> ctrCrearMenu();

          /*-== Menu - CIERRE FORMULARIO AGREGAR ==*/
          echo $Formulario_Agregar["Cierre"];
        ?>

        <?php   } }  ?>

<!--=====================================
MODAL MODIFICAR MENU
======================================-->
          <?php
          if (isset($rol_perfil)) {
          // Verificar si tiene el permiso de modificar
          $i = array_search("Menu_Modificar", array_column($rol_perfil, 2));
          //var_dump($i);
          if($i!==false){

                  /*-== FORMULARIO ==*/
                  $Formulario_Editar = p_formulario ($Tabla,MODIFICAR);

                  /*-== Menu - CABEZA FORMULARIO MODIFICAR ==*/
                  echo $Formulario_Editar["Cabeza"];
        ?>

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">
                  <div class="box-body">
                    
                  <?php
                  // Pintar los campos de formulario
                   echo p_campos_formulario($campos_tabla,MODIFICAR);
                  ?>
                    
                  </div>
                </div>

        <?php
            /*-== Menu - PIE FORMULARIO EDITAR ==*/
            echo $Formulario_Editar["Pie"];

            /*-== EJECUCION ==*/
            $editarMenu = new ControladorMenu();
            $editarMenu -> ctrModificarMenu();

            /*-== Menu - CIERRE FORMULARIO EDITAR ==*/
            echo $Formulario_Editar["Cierre"];
          ?> 

        <?php } } ?>

<!--=====================================
ELIMINAR MENU
======================================-->

<?php

  $borrarMenu = new ControladorMenu();
  $borrarMenu -> ctrBorrarMenu();

?>


<!--=====================================
MODAL IMPORTAR MENU
======================================-->
<?php  
if (isset($rol_perfil)) {
$b = array_search("Menu_Importar", array_column($rol_crear, 2));
//var_dump($i);
if($b!==false){


          /*-== FORMULARIO DE IMPORTAR ==*/
          $VistaImportar = p_importar($Tabla);
          echo $VistaImportar["Cuerpo"];

          /*-== EJECUCION ==*/
          $importarMenu = new ControladorMenu();
          $importarMenu -> ctrImportarMenu();

          /*-== CIERRE DE FORMULARIO ==*/
          echo $VistaImportar["Cierre"];
   } 
 }         
?>

<!--=====================================
MODAL EXPORTAR MENU
======================================-->
<?php  
if (isset($rol_perfil)) {
$c = array_search("Menu_Exportar", array_column($rol_crear, 2));

if($c!==false){

          /*-== FORMULARIO DE EXPORTAR ==*/
          $VistaExportar = p_exportar($Tabla,$_SESSION["idperfil"]);
          echo $VistaExportar["Cuerpo"];

 }  
}
?>
