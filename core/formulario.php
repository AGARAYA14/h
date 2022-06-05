<?php
class formulario {

/*=============================================
CABECERA  FORMULARIO
=============================================*/
public static function modal ($tabla,$operacion)
{
    $formulario = array();
    $formulario["Cabeza"]='
            <div id="modal'.$operacion.$tabla.'" class="modal fade">
              
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">

                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->
                    <div class="modal-header bg-info">
                      <h4 class="modal-title">'.$operacion.' '.$tabla.'</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>';

    $formulario["Pie"]='
            <!--=====================================
            PIE DEL MODAL
            ======================================-->
            <div class="modal-footer d-flex justify-content-between">
              <div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
              <div>
              <button type="submit" class="btn btn-primary">Guardar '.$tabla.'</button>
              </div>
            </div>';

    $formulario["Cierre"]='</form>
                </div>
              </div>
            </div>';


    return  $formulario;
}


/*=============================================
MOSTRAR CAMPO
=============================================*/
public static function mostrar_campo($parametros,$accion)
{

   $resultado ='';

    switch ($accion)
    {

    case AGREGAR:

          switch ($parametros['Objeto'])
          {

     
            case 'Input':
                          $resultado .='<div class="input-group mb-3">
                                       <div class="input-group-append input-group-text">

                                       <span class="'.$parametros["Icono"].' input-group-addon" data-toggle="tooltip" data-placement="top" title="Ingresar '.$parametros["Nombre"].'"></span>
                                       </div>
                                       <input type="'.$parametros["Input"].'" class="form-control lg" name="nuevo'.$parametros["Nombre"].'" placeholder="Ingresa '.$parametros["Nombre"].'" '.$parametros["Obligatorio"].'></div>'; 

                                        // <div class="col-xs-'.$parametros["Columna"].'">
                                        //   <div class="input-group">       
                                        //     <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ingresar '.$parametros["Nombre"].'" >
                                        //     <i class="'.$parametros["Icono"].'"></i></span> 
                                        //     <input type="'.$parametros["Input"].'" class="form-control input-lg" name="nuevo'.$parametros["Nombre"].'" 
                                        //     placeholder="Ingresar '.$parametros["Nombre"].'" '.$parametros["Obligatorio"].'>
                                        //   </div>
                                        // </div>';
            break;

            case 'Select':
                        $resultado .='
                                      <div class="input-group">              
                                        <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Selecciona '.$parametros["Nombre"].'" ><i class="'.$parametros["Icono"].'"></i></span> 
                                        <select class="form-control input-lg" id="nuevo'.$parametros["Nombre"].'" name="nuevo'.$parametros["Nombre"].'" '.$parametros["Obligatorio"].'>                  
                                          <option value="">Selecionar '.$parametros["Nombre"].'</option>';
                    
                    // Obtener la  entidad  del sistema  
                    $item = null;
                    $valor = null;
                    // Es para formar la cadena que llama a la consulta que trae para pintar en el combo.
                    $asociados = ' $mostrar =  Controlador'.$parametros["Asociado"].'::ctrMostrar'.$parametros["Asociado"].'($item,$valor);';
                    // Ejecutar la consulta formada
                    eval($asociados);

                    foreach ($mostrar as $key => $v) {
                      $resultado .= '<option value="'.var_encripta($v["pkid"]).'">'.$v["seleccion"].'</option>';
                    } 

                        $resultado .=' </select>
                                    </div>';

            break;

            case 'Check':
            $resultado .='';
            break;

          }

    break;


    case MODIFICAR:

          switch ($parametros['Objeto'])
          {

            case 'Input':
                          $resultado .='<div class="input-group mb-3">
                                       <div class="input-group-append input-group-text">

                                       <span class="'.$parametros["Icono"].' input-group-addon" data-toggle="tooltip" data-placement="top" title="Ingresar '.$parametros["Nombre"].'"></span>
                                       </div>
                                       <input type="'.$parametros["Input"].'" class="form-control lg" name="modificar'.$parametros["Nombre"].'" id="modificar'.$parametros["Nombre"].'" placeholder="Ingresa '.$parametros["Nombre"].'" '.$parametros["Obligatorio"].'>';
                                          if ($parametros["Nombre"]==$parametros["Tabla"]) { 
                                          $resultado .='<input type="hidden"  name="id'.$parametros["Nombre"].'" id="id'.$parametros["Nombre"].'" required>'; 
                                          } 
                          $resultado .='</div>';
            break;

            case 'Select':

                        $resultado .='
                                    <div class="input-group"> 
                                        <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Selecciona '.$parametros["Nombre"].'"><i class="'.$parametros["Icono"].'"></i></span> 
                                        <select class="form-control input-lg seleccionar'.$parametros["Nombre"].'" id="modificarID'.$parametros["Nombre"].'" name="modificarID'.$parametros["Nombre"].'" '.$parametros["Obligatorio"].'>                  
                                          <option class="modificar'.$parametros["Nombre"].'"></option>';
                        // Obtener la  entidad  del sistema  
                        $item = null;
                        $valor = null;
                        // Es para formar la cadena que llama a la consulta que trae para pintar en el combo.
                        $asociados = ' $mostrar =  Controlador'.$parametros["Asociado"].'::ctrMostrar'.$parametros["Asociado"].'($item,$valor);';
                        // Ejecutar la consulta formada
                        eval($asociados);

                        foreach ($mostrar as $key => $v) {
                        $resultado .= '<option value="'.var_encripta($v["pkid"]).'">'.$v["seleccion"].'</option>';
                        } 

                        $resultado .=' </select>
                                    </div>';

            break;
            
            case 'Check':
            $resultado .='';
            break;
          }

       
    break;

    }

    return  $resultado;

}


/*=============================================
MOSTRAR CAMPOS EN EL FORMULARIO
=============================================*/
public static function campos ($campos,$accion)
{

   $resultado ='';

   foreach ($campos as $datos => $a) 
   { 


        // Preparación de los parametros
                $parametros = array(
                                "Objeto" => $a['Objeto'],
                                "Columna" => $a["Columna"],
                                "Nombre" => $a["Nombre"],
                                "Icono" => $a["Icono"],
                                "Input" => $a["Input"],
                                "Tabla" => $a["Tabla"],
                                "Obligatorio" => $a["Obligatorio"],
                                "Asociado" => $a["Asociado"],
                                "Opciones" => $a["Opciones"]
                               );


    //var_dump( $a['Estructura']);
      switch ($a['Estructura'])
      {

        case 'INICIO':
        $resultado .='<div class="">';
        $resultado .=formulario::mostrar_campo($parametros,$accion);
        break;

        case 'CUERPO':
        $resultado .=formulario::mostrar_campo($parametros,$accion);
        break;

        case 'FIN':
        $resultado .=formulario::mostrar_campo($parametros,$accion);
        $resultado .='</div>';
        break;

        case 'FILA':
        $resultado .='<div class="form-group">';
        $resultado .=formulario::mostrar_campo($parametros,$accion);
        $resultado .='</div>';
        break;
      }

      //var_dump( $resultado);

   }

    return  $resultado;
}


/*=============================================
IMPORTAR  ENTIDAD
=============================================*/
public static function importar ($tabla)
{
    $formulario = array();
    $formulario["Cuerpo"] ='
    <div class="modal fade" id="modalImportar'.$tabla.'">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="post" enctype="multipart/form-data">

                <!-- Header -->
                <div class="modal-header bg-info">
                  <h4 class="modal-title">Importar '.$tabla.'</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- body -->
                <div class="modal-body">
                  <div class="box-body">

                    <div class="form-group row">
                      <div class="col-12">
                        <div id="file_archivo" class="input-group">
                          <input class="form-control" type="text" readonly="">
                          <label class="input-group-btn">
                            <input type="file" name="archivo" id="file'.$tabla.'" accept=".xls,.xlsx" style="display:none;">
                            <span class="btn btn-block btn-info">Seleccionar archivo...</span>
                          </label> 
                        </div>
                      </div>
                    </div>

                    <div id="mensaje_error_archivo"> 
                    </div>

                  </div>

                  <!-- footer -->
                  <div class="modal-footer d-flex justify-content-between">

                    <div>
                      <button type="button" class="btn btn-danger pull-left btn-lim" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div>
                      <a href="./'.EXP_PLANTILLA.'p_'.strtolower($tabla).'.php" class="btn btn-primary btn-plantilla" role="button">Plantilla</a>
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary btn-importar" disabled >Importar '.$tabla.'</button>
                    </div>
                    
                  </div>
                  </div>';

    $formulario["Cierre"]='</form>
                            </div>
                          </div>
                        </div>';


            // '.strtolower($tabla).'
            // 
            // '.$tabla.'

    return  $formulario;
}



/*=============================================
EXPORTAR  ENTIDAD
=============================================*/
public static function exportar($tabla,$id_perfil)
{
    $formulario = array();
    $formulario["Cuerpo"] ='
    <div id="modalExportar'.$tabla.'" class="modal fade">

      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="./'.EXP_DESCARGA.'d_'.strtolower($tabla).'.php"  enctype="multipart/form-data">

            <!-- Header -->
            <div class="modal-header bg-info">
              <h4 class="modal-title">Exportar '.$tabla.'</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- body -->
            <div class="modal-body">
              <div class="box-body">

                <div class="form-group row">
                  <div class="col-12">

                    <p class="text-light-blue"><h5>Seleccione campos a exportar:</h5></p>
                    <hr>
                    <div class="col-xs-12 checkbox" id="Lista_Campos"></div>
                    <hr>
                    <div> <p class="text-muted"><input type="checkbox" id="checkTodos"><i>Marcar/Desmarcar Todos</i></p></div>

                    <input type="hidden"  name="p_id" value='.$id_perfil.'   required>   

                  </div>
                </div>

              </div>

              <!-- footer -->
              <div class="modal-footer d-flex justify-content-between">

                <div>
                  <button type="button" class="btn btn-danger pull-left btn-lim" data-dismiss="modal">Cerrar</button>
                </div>
                <div>
                  <button type="submit" class="btn btn-primary btn-exportar" name="Enviar">Exportar '.$tabla.'</button>
                </div>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>';

    return  $formulario;
}


/*=============================================
Formulario Modal del Filtro
=============================================*/
public static function modalFiltro ($tabla)
{
    $formulario = '';
    $formulario.='<div class="modal fade" id="modalfiltro'.$tabla.'">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-info">

                      <form role="form" method="post" id="formulario" name=formularioModulo>
                        <!--=====================================
                        CABEZA DEL MODAL
                        ======================================-->
                      <div class="modal-header">
                        <h4 class="modal-title">Filtro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      </div>
                      <!--=====================================
                      CUERPO DEL MODAL
                      ======================================-->
                      <div class="modal-body">
                        <div class="box-body">
                          
                          <div class="form-group row">
                            <div class="col-xs-12">
                              <div class="input-group">
                                <label>Adicionar
                                <div class="btn btn-success" id="btnNuevoFiltro'.$tabla.'">Nuevo</div>
                                </label>
                                    <table class="table table-bordered table-hover" id="NuevoFiltro'.$tabla.'">
                                    <thead>
                                      <tr>
                                        <th>Campo</th>
                                        <th>Condicion</th>
                                        <th>Valor</th>
                                        <th>Y/O</th>
                                        <th>---</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
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
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Salir</button>
                        <button type="submit" id="SaveFiltro'.$tabla.'" class="btn btn-outline-light">Guardar</button>
                      </div>

                      </form>

                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>';

    return  $formulario;
}




}