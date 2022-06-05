<?php 
// Establecer la clase activo en el menu
$ruta_menu =$_GET["ruta"];
echo helper::menuActivo($ruta_menu);

$Tabla=ControladorPerfil::$tabla;

//Obtener el la configuracion del contenedor de vista
$menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tabla,$_SESSION["idusuario"]);

//Obtener roles de la botonera.
$rol_principal = ControladorContenedorVista::ctrObtenerRolCrearPerfil($Tabla,$_SESSION["idperfil"]);


 // Campos de la tabla
$campos_tabla = ControladorContenedorVista::ctrObtenerCamposTabla($Tabla);



/*-=====================================
VISTA ADMINISTRATIVA PERFIL
======================================*/
if ($menu_usuario) 
{ 
  // $VistaPrincipal;
  echo registro::vistaAdm($menu_usuario,$rol_principal,$Tabla);        
  // Modal Filtro
  echo formulario::modalFiltro($Tabla);

}
else { funciones::error(); } 


        if (funciones::esValido($GLOBALS['roles']))
        {

          /*----------  MODAL AGREGAR PERFIL ----------*/

          // Verificar si tiene el permiso de crear
          if(funciones::siTiene($Tabla,'Crear',$GLOBALS['roles'])!==false)
          {
              // Obtener si el permiso es auditable
              $auditable = funciones::esAuditable($Tabla,'Crear',$GLOBALS['roles']);

              /*-== FORMULARIO: Obtener Estructura de modal ==*/
              $Formulario_Agregar = formulario::modal($Tabla,AGREGAR);

              /*-== PERFIL - CABEZA FORMULARIO AGREGAR ==*/
              echo $Formulario_Agregar["Cabeza"];

              /*-== PERFIL - CUERPO FORMULARIO AGREGAR ==*/
              echo DIV_MODAL;
              echo formulario::campos($campos_tabla,AGREGAR);
              echo DIV_CLOSE;

              /*-== PERFIL - PIE FORMULARIO AGREGAR ==*/
              echo $Formulario_Agregar["Pie"];

              $crearPerfil = new ControladorPerfil();
              $crearPerfil -> ctrCrearPerfil($auditable);

              /*-== PERFIL - CIERRE FORMULARIO AGREGAR ==*/
              echo $Formulario_Agregar["Cierre"];
          }


          /*----------  MODAL MODIFICAR PERFIL ----------*/
          // Verificar si tiene el permiso de modificar
          if(funciones::siTiene($Tabla,'Modificar',$GLOBALS['roles'])!==false)
          {
                // Obtener si el permiso es auditable
                $auditable = funciones::esAuditable($Tabla,'Modificar',$GLOBALS['roles']);

                /*-== FORMULARIO: Obtener Estructura de modal ==*/
                $Formulario_Editar = formulario::modal($Tabla,MODIFICAR);

                /*-== PERFIL - CABEZA FORMULARIO EDITAR ==*/
                echo $Formulario_Editar["Cabeza"];


                /*-== PERFIL - CUERPO FORMULARIO AGREGAR ==*/
                echo DIV_MODAL;
                echo formulario::campos($campos_tabla,MODIFICAR);
                echo DIV_CLOSE;

                /*-== PERFIL - PIE FORMULARIO EDITAR ==*/
                echo $Formulario_Editar["Pie"];

                /*-== EJECUCION ==*/
                $editarPerfil = new ControladorPerfil();
                $editarPerfil -> ctrModificarPerfil($auditable);

                /*-== PERFIL - CIERRE FORMULARIO EDITAR ==*/
                echo $Formulario_Editar["Cierre"];
          }

          /*----------  ELIMINAR PERFIL ----------*/
          // Verificar si tiene el permiso de modificar
          if(funciones::siTiene($Tabla,'Eliminar',$GLOBALS['roles'])!==false){
            // Obtener si el permiso es auditable
            $auditable = funciones::esAuditable($Tabla,'Eliminar',$GLOBALS['roles']);

            $borrarPerfil = new ControladorPerfil();
            $borrarPerfil -> ctrBorrarPerfil($auditable);
          }

          /*----------  IMPORTAR PERFIL ----------*/
          if(funciones::siTiene($Tabla,'Importar',$GLOBALS['roles'])!==false) {

            /*-== FORMULARIO DE IMPORTAR ==*/
            $VistaImportar = formulario::importar($Tabla);
            echo $VistaImportar["Cuerpo"];

            /*-== EJECUCION ==*/
            $importarPerfil = new ControladorPerfil();
            $importarPerfil -> ctrImportarPerfil();

            /*-== CIERRE DE FORMULARIO ==*/
            echo $VistaImportar["Cierre"];
          }


          /*----------  EXPORTAR PERFIL ----------*/
          if(funciones::siTiene($Tabla,'Exportar',$GLOBALS['roles'])!==false) {

            /*-== FORMULARIO DE EXPORTAR ==*/
             $VistaExportar = formulario::exportar($Tabla,$_SESSION["idperfil"]);
             echo $VistaExportar["Cuerpo"];
          }



        // fin de validación de perfil
        }

?>































