<?php



function p_vista ($menu_usuario, $rol_crear, $rol_perfil) :string
{
    $resultado ='';

    if (isset($menu_usuario) && isset($rol_crear)) 
    {
        $resultado .='
                        
        <div class="content-wrapper">
            <section class="content-header">

            <h1>'.$menu_usuario["descripcion"].'</h1>

            <ol class="breadcrumb"> 
                <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>  
                <li class="active">Administrar '.$Tipo.'</li>
            </ol>

            </section>

            <section class="content">
                <div class="box">
                <div class="box-header with-border">';

                //Asignar Boton de creación
                    if($rol_crear)
                    {

                        
                        $resultado .='<button class="'.$rol_crear["tipo_boton"].'" data-toggle="modal" data-target="#'.$rol_crear["modal"].'">         
                                '.$rol_crear["descripcion"].'
                                </button>';
                    }
            

                    $resultado .='</div>';

            // ------------------------------------------------------------------------------------------------------------------------------------------------------------

            $resultado .='<div class="box-body">
                            <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                <thead>
                                <tr>';
     

                            // Obtener Consulta
                            $menu_query = ControladorContenedorVista::ctrObtenerConsultaVista($menu_usuario["consulta"]);
                    
                            // Obtener Columnas
                            $menu_columnas = ControladorContenedorVista::ctrObtenerColumnasVista($menu_usuario["IDConfigVista"]);
                    
                            foreach ($menu_columnas as $key => $mc) 
                            {
                                //Obtener cabeceras
                                $resultado .='<th style="width:'.$mc["ancho"].'px">'.$mc["texto"].'</th>'; 
                            }
    
     
            $resultado .='<th>ACCIONES</th>
                        </tr> 
                        </thead>
                        <tbody>';
             // ------------------------------------------------------------------------------------------------------------------------------------------------------------
             //Recorrer cada query
                      foreach ($menu_query as $k => $mq) 
                      {
                         $resultado .= '<tr>';
                         //Recorrer cada columna
                         foreach ($menu_columnas as $y => $z) 
                         {
                               if (isset($mq[$z["nombresql"]]))
                               {
                                $resultado .= '<td class="">'.ucfirst($mq[$z["nombresql"]]).'</td>';
                               }
                               else 
                               {
                                $resultado .= '<td class="text-uppercase"> -- </td>';
                               }
                           
                         }
                        // -----------------------------------------------------------------------------------------------------------------------------------
                         $resultado .= '<td>
                                        <div class="btn-group">';
                       //Recorrer cada permiso para colocarlo en boton
                               if($rol_perfil)
                               {
                                 foreach ($rol_perfil as $x => $p) 
                                 {     
                                    $resultado .= '<spam data-toggle="tooltip" data-placement="top" title="'.$p["descripcion"].'">';
                                    $resultado .= '<button class="'.$p["tipo_boton"].' '.$p["nombre_boton"].'" id'.$p["tipo"].'="'.var_encripta($mq["id"]).'"';
                                         if($p["modal"]<>'') // Modificar
                                             {
                                                $resultado .= ' data-toggle="modal" data-target="#'.$p["modal"].'"><i class="'.$p["icono"].'"></i></button> </spam>';   
                                             } 
                                         else //Acceso Eliminar
                                             {
                                                $resultado .= '> <i class="'.$p["icono"].'"></i></button> </spam>';
                                             }                           
                                 }
                                 // -----------------------------------------------------------------------------------------------------------------------------------
                               }
             
                         $resultado .= '</div>  
                                        </td>  
                                    </tr>';
                       }
             
                       $resultado .='
                                    </tbody>
                                    </table>
                                    </div>
                                    </div>
                                    </section>
                                    </div>';

    }
    else {
        $resultado .='
                        
        <div class="content-wrapper">
            <section class="content-header">

            <h1> NO ENCONTRADO </h1>

            <ol class="breadcrumb"> 
                <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>  
                <li class="active"> NO ENCONTRADO </li>
            </ol>

            </section>

            <section class="content">
                <div class="box">               
                </div>'; 
        // ------------------------------------------------------------------------------------------------------------------------------------------------------------

        $resultado .='<div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
            <thead>
            <tr>
            </tr> 
            </thead>
            <tbody>
            </tbody>
            </table>
            </div>
            </div>
            </section>
            </div>';
    }

return  $resultado;
    

}



function Leer_Sweet ($Tabla, $Respuesta, $Accion, $Crud) :string {
$alerta = array();

if($Respuesta == "ok")
{
    $alerta["Accion"]=$Accion;
    $alerta["Tipo"]="success";
    
    switch ($Crud)
    {
        case 'Crear': $alerta["Titulo"]= "La entidad ".$Tabla." ha sido creada"; break;
        case 'Editar': $alerta["Titulo"]= "La entidad ".$Tabla." ha sido modificada"; break;
        case 'Eliminar': $alerta["Titulo"]= "La entidad ".$Tabla." ha sido borrada"; break;
    }
    $alerta["Entidad"]=strtolower($Tabla);
    return sweet_alert ($alerta);
    
} else if($Respuesta == "error")
{
$alerta["Accion"]=$Accion;
$alerta["Tipo"]="error";
    switch ($Crud)
    {
        case 'Crear': $alerta["Titulo"]= "Ocurrio un error al crear la entidad ".$Tabla; break;
        case 'Editar': $alerta["Titulo"]= "Ocurrio un error al editar la entidad ".$Tabla; break;
        case 'Eliminar': $alerta["Titulo"]= "Ocurrio un error al eliminar la entidad ".$Tabla; break;
    }
$alerta["Entidad"]=strtolower($Tabla);
return sweet_alert ($alerta);
} else if($Respuesta == "invalido")
{
$alerta["Accion"]=$Accion;
$alerta["Tipo"]="error";
$alerta["Titulo"]="¡La entidad".$Tabla." no puede ir vacío o llevar caracteres especiales!";
$alerta["Entidad"]=strtolower($Tabla);
return sweet_alert ($alerta);
}


}


?>