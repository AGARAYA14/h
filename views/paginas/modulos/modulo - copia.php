<?php
    //Obtener el la configuracion del contenedor de vista
    $Tipo='Modulo';
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
          //Asignar Boton de creación
          if($rol_crear)
          {
                echo '<button class="'.$rol_crear["tipo_boton"].'" data-toggle="modal" data-target="#'.$rol_crear["modal"].'">         
                      '.$rol_crear["descripcion"].'
                      </button>';
          }
        ?>

      </div>

    <div class="box-body">
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
                    echo '<td class="text-uppercase">'.$mq[$z["nombresql"]].'</td>';
                  }
                  else 
                  {
                    echo '<td class="text-uppercase"> -- </td>';
                  }
              
            }
               echo '<td>
                    <div class="btn-group">';
          //Recorrer cada permiso para colocarlo en boton
                  if($rol_perfil)
                  {
                    foreach ($rol_perfil as $x => $p) 
                    {     
                            echo '<spam data-toggle="tooltip" data-placement="top" title="'.$p["descripcion"].'">';
                            echo '<button class="'.$p["tipo_boton"].' '.$p["nombre_boton"].'" id'.$p["tipo"].'="'.var_encripta($mq["id"]).'"';
                            if($p["modal"]<>'') // Modificar
                                {
                                 echo ' data-toggle="modal" data-target="#'.$p["modal"].'"><i class="'.$p["icono"].'"></i></button> </spam>';   
                                } 
                            else //Acceso Eliminar
                                {
                                  echo '> <i class="'.$p["icono"].'"></i></button> </spam>';
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
MODAL AGREGAR MODULO
======================================-->
<?php   if($rol_crear){  ?>  

<div id="modalAgregarModulo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Modulo</h4>
        </div>

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

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Modulo</button>
        </div>

        <?php
          $crearModulo = new ControladorModulo();
          $crearModulo -> ctrCrearModulo();
        ?>

      </form>
    </div>
  </div>
</div>

<?php   }   ?>

<!--=====================================
MODAL EDITAR MODULO
======================================-->
<?php
// Verificar si tiene el permiso de modificar
$i = array_search("Modulo_Modificar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalEditarModulo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Módulo</h4>
        </div>

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

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

      <?php
          $editarModulo = new ControladorModulo();
          $editarModulo -> ctrEditarModulo();
        ?> 

      </form>
    </div>
  </div>
</div>
<?php }  ?>

<!--=====================================
ELIMINAR MODULO
======================================-->

<?php

  $borrarModulo = new ControladorModulo();
  $borrarModulo -> ctrBorrarModulo();

?>


