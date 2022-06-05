<?php
require_once "ajax.php";
require_once "../controllers/modulo.controlador.php";
require_once "../models/modulo.modelo.php";

require_once "../core/funciones.php";

class AjaxModulo extends Ajax{

	protected static $ID = 'pkid';
	public $idModulo;
	private $idModulo_vista;
	public $idusuario;

	/*=============================================
	Funcion Constructor
	=============================================*/
	public function __construct ($idvista=0){
		$this->idModulo_vista=$idvista;
		parent::__construct($this->idModulo_vista);
	}

	/*=============================================
	MODIFICAR MODULO
	=============================================*/	
	public function ajaxModificarModulo(){

		$valor = funciones::get_id_num($this->idModulo);
		$respuesta = ControladorModulo::ctrMostrarModulo(self::$ID, $valor);
		echo json_encode($respuesta);

	}
}

/*=============================================
MODIFICAR MODULO
=============================================*/	
if(isset($_POST["idmodulo"])){

	$modulo = new AjaxModulo();
	$modulo -> idModulo = $_POST["idmodulo"];
	$modulo -> ajaxModificarModulo();
}
/*=============================================
EXPORTAR MODULO
=============================================*/	
if(isset($_POST["idvista_exportar"])){
	$valor = funciones::get_id_num($_POST["idvista_exportar"]); // Desencritar id
	$modulo2 = new AjaxModulo($valor);
	$modulo2 -> columnasEntidad();
}
/*=============================================
FILTRO : OBTENER LOS FILTROS POR USUARIO
=============================================*/	
if(isset($_POST["idvista_entidad"]) && isset($_POST["idusuario"])){
	$valor_idvista = funciones::get_id_num($_POST["idvista_entidad"]);
	$valor_idusuario = funciones::get_id_num($_POST["idusuario"]);

	$modulo3 = new AjaxModulo($valor_idvista);
	$modulo3 -> filtro($valor_idusuario);
}
/*=============================================
FILTRO : OBTENER LOS CAMPOS DE LA ENTIDAD
=============================================*/	
if(isset($_POST["vista_id"])){
	$valor = funciones::get_id_num($_POST["vista_id"]);
	$modulo4 = new AjaxModulo($valor);
	$modulo4 -> columnasEntidad();
}


if(isset($_GET["op"])){

	switch($_GET["op"]){


		case "filtro":
			$id_vista = funciones::get_id_num($_POST["idVista"]);
			$id_filtro = funciones::get_id_num($_POST["idFiltro"]);
			$id_usuario = funciones::get_id_num($_POST["idUsuario"]);
			$flag = 0;
			//$enlace=null;
			$datos = array();
			//$enviar = array();
			$n1=count($_POST["f_campo"]);

			$bl_IDVista   = funciones::esNumero ($id_vista);
			$bl_IDfiltro = funciones::esNumero ($id_filtro);

			if($bl_IDVista && $bl_IDfiltro)
			{

				for($i=0;$i<$n1;$i++) 
				{ 
					$tipoDato = funciones::limpiar_cadena($_POST["f_opcion"][$i]);
					switch ($tipoDato) {
						case "Entero": $flag = 0; break;
						case "Texto": $flag = 1; break;
						case "Fecha": $flag = 1; break;
						case "Entero": $flag = 0; break;

						
						default:
							// code...
							break;
					}
				    $campo = funciones::limpiar_cadena($_POST["f_campo"][$i]);
				    $condicion = $_POST["f_condicion"][$i];
				    $valor = funciones::limpiar_cadena($_POST["f_valor"][$i]);
				    $enlace = $_POST["f_enlace"][$i];

				    if ($enlace==='0') {
				    	$enlace = "";
				    } 
				   
					$datos [] = array(
									"campo"=> $campo,
									"condicion"=> $condicion,
									"valor"=> $valor,
									"opcion"=> $flag,
									"enlace"=> $enlace
						           );
				} 	
			}

			$modulo5 = new AjaxModulo($id_vista);			
			$modulo5 -> registrarFiltro($id_filtro,$id_usuario, $datos);

		break;


		case 'Sinfiltro':
			$id_vista = funciones::get_id_num($_POST["idVista"]);
			$id_filtro = funciones::get_id_num($_POST["idFiltro"]);
			$id_usuario = funciones::get_id_num($_POST["idUsuario"]);
			$datos = array();

			$modulo5 = new AjaxModulo($id_vista);			
			$modulo5 -> registrarFiltro($id_filtro,$id_usuario, $datos);

		break;

		case "activarydesactivar":
		break;


		case "listar":
		break;

		case "eliminar_categoria":
		break;


	}

 }