<?php 
class registro {


    /*=============================================
    OBTENER LA VISTA ADMINISTRATIVA DEL TIPO
    =============================================*/
    public static function vistaAdm ($menu_usuario, $rol_crear, $Tipo) :string
    {
        $resultado ='';

        if (isset($menu_usuario) && isset($rol_crear)) 
        {
            $resultado .='
                <div class="content-wrapper" style="min-height: 717px;">
                  <section class="content-header">
                    <div class="container-fluid">

                      <div class="row mb-2">

                        <div class="col-sm-6">
                          <h1>'.$menu_usuario["descripcion"].'</h1>
                        </div>

                        <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
                            <li class="breadcrumb-item active">'.$Tipo.'</li>
                          </ol>
                        </div>

                      </div>

                    </div><!-- /.container-fluid -->

                  </section>

                  <!-- Main content -->

                  <section class="content">

                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-12">
                          <!-- Default box -->
                          <div class="card card-info card-outline">
                            <div class="card-header " id="'.$Tipo.'" vista="'.$menu_usuario["IDConfigVista"].'">';

                //Asignar Boton de creación - importacion - exportacion
                if($rol_crear)
                {
                             foreach ($rol_crear as $x => $p) 
                             {     
                                $resultado .='<spam> <button class="';
                                $resultado .= $p["tipo_boton"].' '.$p["nombre_boton"].'  btn-sm "';

                                $resultado .= ' data-toggle="modal" data-target="#'.$p["modal"].'" ';                                    
                                $resultado .=' >';
                                $resultado .= $p["descripcion"];
                                $resultado .= '</button> </spam>';   

                             }  
                }

                // COLUMNAS 
                // Obtener nombre de columnas configuradas
                $menu_columnas = ControladorContenedorVista::ctrObtenerColumnasVista($menu_usuario["IDConfigVista"]);
                // Para realizar el combo de la columnas para ocultar y mostrar
                $resultado .= helper::columnasFiltro($menu_columnas);

                 // FILTRO 
                $resultado .=  helper::botonFiltro($Tipo); 
                // ----------------


                $resultado .='</div>
                            <!-- /.card-header -->';


                    
                    // --------------------------------------------------------------------

                $resultado .='<div class="card-body">      
                              <table class="table table-bordered table-striped dt-responsive etabla tabla'.$Tipo.'" width="100%">      
                                <thead>
                                  <tr>';
                $resultado .=   '<th style="width:10px">#</th>';


                        
                                foreach ($menu_columnas as $key => $mc) 
                                {
                                    //Obtener cabeceras
                                    $resultado .='<th style="width:'.$mc["ancho"].'px">'.$mc["texto"].'</th>'; 
                                }
        
         
                $resultado .=   '<th>Acciones</th>
                                          </tr> 
                                      </thead>
                                      <tbody>
                                      </tbody>
                                  </table>

                              </div>
                              <!-- /.card-body -->
                              <div class="card-footer">
                              </div>
                              <!-- /.card-footer-->
                            </div>
                            <!-- /.card -->
                          </div>
                        </div>
                      </div>
                    </section>
                    <!-- /.content -->
                  </div>';

        }
        else
        {
          // Cuando no encuentra resultad sobre vista administrativa
          $resultado .='
                      <div class="content-wrapper" style="min-height: 717px;">
                        <section class="content-header">
                          <div class="container-fluid">
                            <div class="row mb-2">
                              <div class="col-sm-6">
                                <h1>NO ENCONTRADO</h1>
                              </div>
                              <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                                  <li class="breadcrumb-item active">No Encontrado</li>
                                </ol>
                              </div>
                            </div>
                          </div><!-- /.container-fluid -->
                        </section>

                        <!-- Main content -->

                        <section class="content">

                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-12">
                                <!-- Default box -->
                                <div class="card card-info card-outline">
                                  <!-- /.card-header -->

                                  <div class="card-body">
                                    
                                    <table class="table table-bordered table-striped dt-responsive" width="100%">
                                      
                                      <thead>
                                        <tr>
                                        </tr>
                                      </thead>

                                      <tbody>
                                      </tbody>

                                    </table>

                                  </div>
                                  <!-- /.card-body -->
                                  <div class="card-footer">
                                  </div>
                                  <!-- /.card-footer-->
                                </div>
                                <!-- /.card -->
                              </div>

                            </div>

                          </div>

                        </section>
                        <!-- /.content -->

                      </div>';
        }

        return  $resultado;
    }




}