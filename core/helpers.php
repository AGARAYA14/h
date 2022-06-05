<?php

class helper {

    /*=============================================
    Funcionalidad para tener el menú activo
    =============================================*/
    public static function menuActivo($menu): string
    {
      $resultado = '';

      $resultado .='<script>  
        const amenu = document.querySelector("a.menu.'.$menu.'");
        amenu_padre = amenu.parentElement.parentElement.parentElement;
        amenu_hijo = amenu_padre.children[0];

        if (amenu.tagName=="A") {
            amenu.classList.add("active");
            if(amenu_hijo.tagName=="A"){
                amenu_hijo.classList.add("active");
                if(amenu_padre.tagName=="LI"){ amenu_padre.classList.add("menu-open"); }
            }
          } 
        </script>';

      return  $resultado;
    }

    /* VISIBILIDAD DE COLUMNAS */
    /*=============================================
    Boton para el filtro de la entidad
    =============================================*/
    public static function botonFiltro ($tipo): string {
        $resultado ='';

        if (isset($tipo)) {
        $resultado .= '<spam> <button class="btn btn-primary  btn-sm btnFiltro'.$tipo.'" data-toggle="modal" data-target="#modalfiltro'.$tipo.'" >Filtro</button></spam>';}

        return $resultado;

    }

    /*=============================================
    Realizar el combo para el filtro
    =============================================*/

    public static function columnasFiltro ($columnas): string {
        $resultado ='';

        if (isset($columnas)) 
        {
                  
            $resultado .= '<div class="btn-group">
                            <button type="button" class="btn btn-primary  btn-sm">Columnas</button>
                            <button type="button" class="btn btn-primary  btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                              <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, 37px, 0px);">';
                              foreach ($columnas as $key => $mc) {
                                  $resultado .= '<a class="dropdown-item columnas" data-column="'.($key+1).'">'.$mc["texto"].'</a>';
                              }
                                    
            $resultado .= '</button>
                          </div>';
          
        }

            return $resultado;

    }


    /*=============================================
    Evalua si cada variable es número o texto           =
    =============================================*/

    public static function evaluar_datos ($variables){
      $errores = array();

        if(count($variables) > 0)
        {
            foreach ($variables as $k => $value) 
          {

            switch ($value[1]) 
            {
              case TEXTO:
                          if (!funciones::esTexto($value[0]))  $errores[] = funciones::notifica_mensaje ($value[0],$value[1]);
                          break;

              case NUMERO:
                          if (!funciones::esNumero($value[0])) $errores[] = funciones::notifica_mensaje ($value[0],$value[1]);
                          break;
              default:
                // code...
                break;
            }

          }
        }
      return $errores;
    }

    /*=============================================
    OBTENER ARRAY DE MENSAJE
    =============================================*/
    public static function array_rspta ($r){
        $rspta = array();
        switch ($r) {
            case OK:
            $rspta [] = array(
              "r"=> $r,
              "texto"=> "Operación Completa",
              "titulo"=> "Exito!"
            );
            break;      
            case OK2:
            $rspta [] = array(
              "r"=> $r,
              "texto"=> "Operación Parcial, revisar...",
              "titulo"=> "Cuidado!"
            );
            break;      

            case ERROR:
            $rspta [] = array(
              "r"=> $r,
              "texto"=> "Hubo un problema",
              "titulo"=> "Error!"
            );
            break;

            default:
            // code...
            break;
        }
        echo json_encode($rspta);
    }



    /*=============================================
    OBTENER EL MENSAJE A MOSTRAR
    =============================================*/

    public static function notificar ($Tabla, $Respuesta, $Accion, $Notificacion, $Crud='',$Opcion='') :string {
            $alerta = array();


            switch ($Respuesta)
            {
                case OK: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="success";
                        $alerta["Titulo"]= $Tabla;
                        switch ($Crud)
                        {
                            case 'Crear': $alerta["Texto"]= "La entidad ".$Tabla." ha sido creada"; break;
                            case 'Editar': $alerta["Texto"]= "La entidad ".$Tabla." ha sido modificada"; break;
                            case 'Eliminar': $alerta["Texto"]= "La entidad ".$Tabla." ha sido borrada"; break;
                        }
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Posicion"]="top";
                        break;

                case ERROR: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        $alerta["Titulo"]= $Tabla;
                        switch ($Crud)
                        {
                            case 'Crear': $alerta["Texto"]= "Ocurrio un error al crear la entidad ".$Tabla; break;
                            case 'Editar': $alerta["Texto"]= "Ocurrio un error al editar la entidad ".$Tabla; break;
                            case 'Eliminar': $alerta["Texto"]= "Ocurrio un error al eliminar la entidad ".$Tabla; break;
                        }
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Posicion"]="top";
                        break;

                case INFO: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="info";
                        $alerta["Titulo"]=$Tabla."!!!!";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]="Tener en cuenta ".$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case QUESTION: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="question";
                        $alerta["Titulo"]=$Tabla." ¿¿??";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case WARNING: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="warning";
                        $alerta["Titulo"]="¡¡¡ ".$Tabla." !!!";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case INVALIDO: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        //$alerta["Titulo"]="¡La entidad".$Tabla." no puede ir vacío o llevar caracteres especiales!";
                        $alerta["Titulo"]="<em><h2> ¡La entidad ".$Tabla." presenta observaciones! </h2><em>" ;
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case PESO_INVALIDO: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        $alerta["Titulo"]=$Tabla." : el peso del archivo es demasiado grande!!!!";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case TIPO_INVALIDO: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        $alerta["Titulo"]=$Tabla." : la extensión del archivo no es permitida!!!!";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case ERROR_DESCONOCIDO: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        $alerta["Titulo"]="¡En la entidad ".$Tabla." ha ocurrido un error desconocido!";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case IMPORTAR: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="success";
                        $alerta["Titulo"]= $Tabla;
                        $alerta["Texto"]= "Los registros han sido creados"; 
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Posicion"]="top";
                        break;

                case ERROR_IMPORTACION: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="warning";
                        $alerta["Titulo"]="¡No se completó la importación! Hubieron observaciones";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]="Revisar filas: ".$Opcion;
                        $alerta["Posicion"]="top";
                        break;

                case COLUMNA_INVALIDA: 
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        $alerta["Titulo"]="Ocurrió un error en la importación, una de las columnas no pertenece a la entidad ";
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break;
                default:
                        $alerta["Accion"]=$Accion;
                        $alerta["Tipo"]="error";
                        $alerta["Titulo"]=$Respuesta;
                        $alerta["Entidad"]=strtolower($Tabla);
                        $alerta["Texto"]=$Opcion;
                        $alerta["Posicion"]="top";
                        break; 
            }

            /*
            const SWEET = "sweet";
            const TOAST = "toast";
            const NOTIFY = "notify";
            const NOTIE = "notie";
             */
            $Mensaje =''; 
            switch ($Notificacion) {
              case SWEET:   $Mensaje = alerta::sweet_alert ($alerta); break;
              case TOAST:   $Mensaje = alerta::toast ($alerta);       break;
              case NOTIFY:  $Mensaje = alerta::notify ($alerta);      break;
              case NOTIE:   $Mensaje = alerta::notie ($alerta);       break;
            }



            return $Mensaje;

    }


    /*=============================================
    Funcion para obtener consulta a exportar 
    =============================================*/
    public static function Consulta_Exportar ($select,$consulta,$where='',$orden=''):string{
        $resultado='';

        if(isset($consulta)){

                $pos = strpos($consulta["consulta"], 'from');
                $consulta_desde_from = substr($consulta["consulta"],$pos);
                $resultado = $select.$consulta_desde_from.$where.$orden; 
        }

            return $resultado;
    }

}