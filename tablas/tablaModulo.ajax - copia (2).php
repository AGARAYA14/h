<?php 
require_once "../core/funciones.php";
//require_once "../core/helpers.php";
// require_once CORE."util.php";
// require_once CORE."funciones.php";
// require_once CORE."registros.php";

// require_once CONTROLADORES."contenedor_vista.controlador.php";
//require_once CONTROLADORES."modulo.controlador.php";

// require_once MODELOS."contenedor_vista.modelo.php";
// require_once MODELOS."modulo.modelo.php";
require_once "../core/globales.php";
require_once "../controladores/contenedor_vista.controlador.php";
require_once "../controladores/modulo.controlador.php";

require_once "../modelos/contenedor_vista.modelo.php";
// require_once "../modelos/modulo.modelo.php";

// require_once "../controladores/sesion.controlador.php";

class TablaModulo{

	//protected static $ID = 'pkid';
	//public $Tabla;
	public $IDPerfil;

	// Constructor
	public function __construct ($id){

		// ID Perfil
		$perfil = is_numeric($a) ? $id : (int) funciones::var_desencripta($id);
		$this->IDPerfil=$perfil;
		// Tabla
		parent::__construct(ControladorModulo::$tabla);
		//$this->Tabla=ControladorModulo::$tabla;
	}

	/*=============================================
	Tabla Administradores
	=============================================*/ 

	public function mostrarTabla($a){

		$Tabla=ControladorModulo::$tabla;


		if (is_numeric($a)){
			$valor=$a;
		}else {
			$valor = (int) funciones::var_desencripta($a); // Desencritar id
		}

	//Obtener permisos de perfil
	$rol_perfil = ControladorContenedorVista::ctrObtenerRolesPerfil($Tabla,$valor);
	//Obtener el la configuracion del contenedor de vista
	$menu_usuario = ControladorContenedorVista::ctrValidarContenedorVista($Tabla,$valor);
    // Obtener Consulta
    $menu_query = ControladorContenedorVista::ctrObtenerConsultaVista($menu_usuario["consulta"]);
    // Obtener Columnas
    $menu_columnas = ControladorContenedorVista::ctrObtenerColumnasVista($menu_usuario["IDConfigVista"]);    



// $arrar1 = array();
// $contenido = array();
$resultado1 ="";

		//$respuesta = ControladorModulo::ctrMostrarModulo(null, null);
		//$respuesta = $arrar1;
		//var_dump($respuesta);

		if(count($menu_query) == 0)
		{
			$datosJson = '{"data":[]}';
			echo $datosJson;
			return;
		}

		$datosJson = '{
	
		"data":[';
// ----------------------------------------------
	/*	foreach ($respuesta as $key => $value) 
		{
			$acciones = $value["Boton"];
			// $acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarAdministrador' data-toggle='modal' data-target='#editarAdministrador' idAdministrador='".$value["pkid"]."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarAdministrador' idAdministrador='".$value["pkid"]."'><i class='fas fa-trash-alt'></i></button></div>";
		
		$datosJson .='[
				      "'.($key+1).'",
				      "'.$value["modulo"].'",
				      "'.$value["orden"].'",
				      "'.$acciones.'"
				    ],';

		}
		*/
//------------------------------------------------------------------------
                 //Recorrer cada query
                      foreach ($menu_query as $k => $mq) 
                      {
                      	$datosJson .='[ 
                      					"'.($k+1).'",';
                         //$resultado .= '[';
                         //Recorrer cada columna
                         foreach ($menu_columnas as $y => $z) 
                         {
                               if (isset($mq[$z["nombresql"]]))
                               {
                               	$datosJson .='"'.ucfirst($mq[$z["nombresql"]]).'",';
                                //$resultado .= '"'.ucfirst($mq[$z["nombresql"]]).'",';
                                //$contenido[$z["nombresql"]] = ucfirst($mq[$z["nombresql"]]);
                                //$arrar1[] =  $contenido['Campo'];
                                //$arrar1[] = array ( $z["nombresql"] => ucfirst($mq[$z["nombresql"]]) );
                               }
                               else 
                               {
                                //$resultado .= '"--",';
                                // $arrar1[$k] = (array)"--";
                                $datosJson .='"---",';
                                // $contenido[$z["nombresql"]] = "--";
                               }
                           
                         }
                        // -----------------------------------------------------------------------------------------------------------------------------------
                         $resultado1 .= "<div class='btn-group'>";
                         
                       //Recorrer cada permiso para colocarlo en boton
                               if($rol_perfil)
                               {
                                 foreach ($rol_perfil as $x => $p) 
                                 {     
                                    $resultado1 .= "<spam data-toggle='tooltip' data-placement='top' title='".$p["descripcion"]."'>";
                                    $resultado1 .= "<button class='".$p["tipo_boton"]." ".$p["nombre_boton"]." 'id".$p["tipo"]." ='".funciones::var_encripta($mq["id"])."'";
                                         if($p["modal"]<>'') // Modificar
                                             {
                                                $resultado1 .= "data-toggle='modal' data-target='#".$p["modal"]."'><i class='".$p["icono"]."'></i></button> </spam>";   
                                             } 
                                         else //Acceso Eliminar
                                             {
                                                $resultado1 .= "> <i class='".$p["icono"]."'></i></button> </spam>";
                                             }                           
                                 }
                                 // ----------------------------------------------------------------------------------------------------------------
                               }
             
                         $resultado1.= "</div>";
                         //$contenido["Boton"] = $resultado1;
                         // $contenido["Boton"] = "<div class='btn-group'><button class='btn btn-warning btn-sm editarAdministrador' data-toggle='modal' data-target='#editarAdministrador' idAdministrador='1'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarAdministrador' idAdministrador='1'><i class='fas fa-trash-alt'></i></button></div>";
                         // $arrar1[] = $contenido;
                         // $resultado1 = "";
                         $datosJson .='"'.$resultado1.'"
                     	],';
                     	$resultado1 = "";
                       }




// ---------------------------------------------------------------
		$datosJson = substr($datosJson, 0, -1);

		$datosJson .= ']}';


		echo $datosJson;

	}

}

/*=============================================
Tabla Modelo
=============================================*/ 

$tabla = new TablaModulo();
$tabla -> mostrarTabla($_POST["idperfil"]);



