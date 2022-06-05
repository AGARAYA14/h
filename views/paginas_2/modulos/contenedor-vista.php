<?php
error_reporting(error_reporting() & ~E_NOTICE & ~E_WARNING);
//error_reporting = E_ALL & ~E_NOTICE & ~E_WARNING;
    //Obtener el la configuracion del contenedor de vista
    $Tipo='ContenedorVista';
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
    /* ------------------------------------------------------------------------------------*/
?>


<!--=====================================
MODAL AGREGAR PERFIL
======================================-->
  <?php   
       if (isset($rol_perfil)) {
              if($rol_crear){  

  ?>  

<div id="modalAgregarContenedor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Contenedor Vista</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group row">
              <!-- ENTRADA PARA EL NOMBRE DEL CONTENEDOR -->
              <div class="col-xs-12">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoContenedor" placeholder="Ingresar Contenedor" required>
                </div>
              </div>  
            </div> 

            <div class="form-group row">
              <!-- ENTRADA PARA EL ADM -->
              <div class="col-xs-8">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="nuevoConfiguracionVista" placeholder="Configuracion Vista" required>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <!-- ENTRADA PARA LA DESCRIPCION -->
              <div class="col-xs-12">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <textarea class="form-control" rows="5" name="nuevoquery" placeholder="Ingresar consulta sql" required > </textarea>
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
          <button type="submit" class="btn btn-primary">Guardar Contenedor</button>
        </div>

        <?php
          $crearContenedor = new ControladorContenedorVista();
          $crearContenedor -> ctrCrearContenedorVista();
        ?>

      </form>
    </div>
  </div>
</div>

  <?php   } }  ?>

  <!--=====================================
MODAL EDITAR CONTENEDOR VISTA
======================================-->
<?php
if (isset($rol_perfil)) {

// Verificar si tiene el permiso de modificar
$i = array_search("ContenedorVista_Modificar", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalModificarContenedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modificar Contenedor Vista</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">


            <div class="form-group row">
              <!-- ENTRADA PARA EL NOMBRE DEL CONTENEDOR -->
              <div class="col-xs-12">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="modificarContenedor" id="modificarContenedor" placeholder="Ingresar Contenedor" required>
                  <input type="hidden"  name="idContenedor" id="idContenedor" required>
                </div>
              </div>  
            </div> 

			<div class="form-group row">
              <!-- ENTRADA PARA EL ADM -->
              <div class="col-xs-8">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <input type="text" class="form-control input-lg" name="modificarConfiguracionVista" id="modificarConfiguracionVista" placeholder="Configuracion Vista"  required>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <!-- ENTRADA PARA LA DESCRIPCION -->
              <div class="col-xs-12">
                <div class="input-group">              
                  <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                  <textarea class="form-control" rows="5" name="modificarquery" id="modificarquery" placeholder="Ingresar consulta sql"  required > </textarea>
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
      
          $editarContenedorVista = new ControladorContenedorVista();
          $editarContenedorVista -> ctrModificarContenedorVista();
          
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
$i = array_search("ContenedorVista_AsignarColumna", array_column($rol_perfil, 2));
//var_dump($i);
if($i!==false){

?>

<div id="modalAsignarColumnaContenedor" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Asignar Columnas al contenedor</h4>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          <div class="box-body">
			<div id="Contenedor"></div>
            <div class="form-group row">
              <!-- ENTRADA PARA LA TABLA -->
              <div class="col-xs-12">
                <div class="input-group">              
                	<label>Estructura de tabla
                	<div class="btn btn-success" id="btnNuevaFilaContenedor">Nuevo</div>
                	</label>

                	<table class="table table-bordered table-hover" id="NuevatablaContenedor">
                	<thead>
                		<tr>
                			<th>Texto</th>
                			<th>Ancho</th>
                			<th>Orden</th>
                			<th>Opcion</th>
                			<th>SQL Nombre</th>
                			<th>Visible</th>
                			<th>---</th>
                		</tr>
                	</thead>
                	<tbody>
                        <tr>
<!--                 		<td><input type="text" class="form-control"></td>
                			<td><input type="number" class="form-control"></td>
                			<td><input type="number" class="form-control"></td>
                			<td><input type="text" class="form-control"></td>
                			<td><input type="text" class="form-control"></td>
                			<td><input type="checkbox" class="minimal"></td> 
                			<td class="text-center"><div class="btn btn-danger">Eliminar</div></td>-->
                		</tr>		
                	</tbody>
	
                	</table>
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
          <button type="submit" class="btn btn-primary guardarpermisos">Guardar cambios</button>
        </div>

      <?php
      
          $ColumnasContenedor = new ControladorContenedorVista();
          $ColumnasContenedor -> ctrGuardarColumnasContenedorVista();
      
        ?> 

      </form>
    </div>
  </div>
</div>
<?php } } ?>

