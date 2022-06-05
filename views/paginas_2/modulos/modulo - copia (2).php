<?php
  $Tabla=ControladorModulo::$tabla;

   //Obtener el la configuracion del contenedor de vista
  
   $menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tabla,$_SESSION["idperfil"]);
  //Obtener rol de crear
   $rol_crear = ControladorContenedorVista::ctrObtenerRolCrearPerfil($Tabla,$_SESSION["idperfil"]);
   //var_dump($rol_crear);
   //Obtener permisos de perfil
   $rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($Tabla,$_SESSION["idperfil"]);
   //Obtener campos de tabla 
   $campos_tabla = ControladorContenedorVista::ctrObtenerCamposTabla($Tabla);

/*-=====================================
VISTA ADMINISTRATIVA MODULO
======================================*/
   if ($menu_usuario) 
   { 
    $VistaPrincipal = registro::vista($menu_usuario,$rol_crear,$rol_perfil);
    echo $VistaPrincipal;
   }
  else { helper::error(); } 

?>

<!--=====================================
MODAL AGREGAR MODULO
======================================-->
        <?php  
        //if (isset($rol_perfil)) {
        if (helper::esValido($rol_perfil))
        {
        // Verificar si tiene el permiso de crear
        //$a = array_search("Modulo_Crear", array_column($rol_crear, 2));
        //helper::siTiene($Tabla,'Crear',$rol_crear);
        //var_dump($i);
          if(helper::siTiene($Tabla,'Crear',$rol_crear)!==false)
          {
              /*-== FORMULARIO ==*/
              $Formulario_Agregar = formulario::cabecera($Tabla,AGREGAR);

              /*-== MODULO - CABEZA FORMULARIO AGREGAR ==*/
              echo $Formulario_Agregar["Cabeza"];
        ?>  

              <!--=====================================
              CUERPO DEL MODAL
              ======================================-->

              <div class="modal-body">
                <div class="box-body">                 
              <?php
                 //var_dump($campos_tabla);
                 echo formulario::campos($campos_tabla,AGREGAR);
              ?>
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
MODAL MODIFICAR MODULO
======================================-->
        <?php
        if (helper::esValido($rol_perfil)) {
        // Verificar si tiene el permiso de modificar
        //$i = array_search("Modulo_Modificar", array_column($rol_perfil, 2));
        //var_dump($i);
        if(helper::siTiene($Tabla,'Modificar',$rol_perfil)!==false)
        {
        //if($i!==false){

                  /*-== FORMULARIO ==*/
                  $Formulario_Editar = formulario::cabecera ($Tabla,MODIFICAR);

                  /*-== MODULO - CABEZA FORMULARIO EDITAR ==*/
                  echo $Formulario_Editar["Cabeza"];
        ?>

                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->

                <div class="modal-body">
                  <div class="box-body">
                    
                  <?php
                  // Pintar los campos de formulario
                   echo formulario::campos($campos_tabla,MODIFICAR);
                  ?>
                    
                  </div>
                </div>

        <?php
            /*-== MODULO - PIE FORMULARIO EDITAR ==*/
            echo $Formulario_Editar["Pie"];

            /*-== EJECUCION ==*/
            $editarModulo = new ControladorModulo();
            $editarModulo -> ctrModificarModulo();

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

