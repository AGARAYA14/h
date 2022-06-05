<?php
require_once "../core/funciones.php";
require_once "../core/globales.php";
require_once "../core/util.php";
require_once "../controllers/contenedor_vista.controlador.php";
require_once "../models/contenedor_vista.modelo.php";


abstract class Tabla{
	
	private $tabla;
	private $idusuario;
/*=============================================
Funcion Constructor
=============================================*/
	public function __construct ($tabla,$usuario){
		$this->tabla=$tabla;
		$this->idusuario=$usuario;
	}
/*=============================================
Funcion para devolver el formato de campo
=============================================*/
public function tipo_campo ($valor, $tipoDato){
  $resultado = null;
  /*
  1. Texto
  2. Entero
  3. Decimal
  4. Fecha
  5. Imagen
  6. Boolean

  ucfirst() -- La primera letra la primera letra
  lcfirst() - Pasa a minúscula el primer caracter de un string
  strtolower() - Convierte una cadena a minúsculas
  strtoupper() - Convierte un string a mayúsculas
  ucwords() - Convierte a mayúsculas el primer caracter de cada palabra de una cadena
   */
  switch ($tipoDato) {
  	case "Texto":		$resultado = ucfirst($valor); break; 
  	case "Texto-m":		$resultado = strtolower($valor); break; 
  	case "Texto-M":		$resultado = strtoupper($valor); break; 
  	case "Texto-p":		$resultado = ucwords($valor); break; 
  	case "Entero":		$resultado = round($valor); break;
  	case "Decimal":		$resultado = number_format($valor); break;
  	case "Decimal-2":	$resultado = number_format($valor, 2, ',', '.'); break;
  	case "Decimal-3":	$resultado = number_format($valor, 3, ',', '.'); break;
  	case "Fecha":		$resultado = $valor; break;
  	case "Imagen":		$resultado = "<img src='".$valor."' class='rounded-circle' width='50px'>"; break;
  			//			$img = 	 "<img src='".$value["img"]."' class='img-fluid rounded-circle' width='100px'>";
  	case "Boolean": $resultado = ucfirst($valor); break;
  	default: $resultado = $valor;	break;
  }

  return $resultado;

}

/*=============================================
Funcion para devolver el formato json
=============================================*/
	public function formato_json (){

    //Obtener permisos de perfil
    $rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($this->tabla,$this->idusuario);
    //Obtener el la configuracion del contenedor de vista
    $menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($this->tabla,$this->idusuario);
    // Obtener Consulta
    $menu_query = ControladorContenedorVista::ctrObtenerConsultaVista($menu_usuario["consulta"]);
    //echo '<pre>'; print_r($menu_query); echo '</pre>';
    // Obtener Columnas
    $menu_columnas = ControladorContenedorVista::ctrObtenerColumnasVista($menu_usuario["IDConfigVista"]);    

      if(count($menu_query) == 0 || $menu_query==ERROR) {
      	return $datosJson = '{"data":[]}';
      }
      else 
      {
      	$Botonera ="";

    		$datosJson = '{
    						"data":[  ';

        //------------------------------------------------------------------------
                   	//Recorrer cada query
                        foreach ($menu_query as $key => $mq_valor) 
                        {
                        	$datosJson .=' [ 
                        					"'.($key+1).'",';
                        	// Recorre cada columna para comparar con el nombre de la columna					
                           foreach ($menu_columnas as $y_key => $mc_valor) 
                           {
                                 if (isset($mq_valor[$mc_valor["nombresql"]]))
                                 {
                                 	$datosJson .='"'.$this->tipo_campo($mq_valor[$mc_valor["nombresql"]],$mc_valor["opcion"]).'",';
                                 	//$datosJson .='"'.ucfirst($mq_valor[$mc_valor["nombresql"]]).'",';
                                 }
                                 else 
                                 {
                                  $datosJson .='"---",';
                                 }                    
                           }
                          // ------------------------------------------------------------------------------------------------------------------
                           $Botonera .= "<div class='btn-group'>";
                           
                         //Recorrer cada permiso para colocarlo en boton
                                 if($rol_perfil)
                                 {
                                   foreach ($rol_perfil as $x_key => $p) 
                                   {     
                                      $Botonera .= "<spam data-toggle='tooltip' data-placement='top' title='".$p["descripcion"]."'>";
                                      $Botonera .= "<button class='".$p["tipo_boton"]." ".$p["nombre_boton"]." 'id".$p["tipo"]." ='".funciones::var_encripta($mq_valor["id"])."'";
                                           if($p["modal"]<>'') // Modificar
                                               {
                                                  $Botonera .= "data-toggle='modal' data-target='#".$p["modal"]."'><i class='".$p["icono"]."'></i></button> </spam>";   
                                               } 
                                           else //Acceso Eliminar
                                               {
                                                  $Botonera .= "> <i class='".$p["icono"]."'></i></button> </spam>";
                                               }                           
                                   }
                                   // ----------------------------------------------------------------------------------------------------------------
                                 }
               
                           $Botonera.= "</div>";
                           $datosJson .='"'.$Botonera.'"
                       					],';
                       	// Limpiar la cadena de botonera
                       	$Botonera = "";
                         }


      		$datosJson = substr($datosJson, 0, -1);
      		$datosJson .= ']
            						}';

  		  return $datosJson;
      // ---FIN DEL BUCLE DE LAS CONSULTAS------------------------------------------------------------
      }
      

	}










}


