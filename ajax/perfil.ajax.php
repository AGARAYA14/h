<?php
require_once "ajax.php";
require_once "../controllers/perfil.controlador.php";
require_once "../models/perfil.modelo.php";
require_once "../core/funciones.php";

class AjaxPerfil extends Ajax{

	protected static $ID = 'pkid';
	//protected static $tabla = 'Perfil';
	public $idPerfil;
	private $idPerfil_vista;
	public $idusuario;

	/*=============================================
	Funcion Constructor
	=============================================*/
	public function __construct ($idvista=0){
		$this->idPerfil_vista=$idvista;
		parent::__construct($this->idPerfil_vista);
	}

	/*=============================================
	EDITAR PERFIL
	=============================================*/	

	public function ajaxModificarPerfil()
	{
		$valor = funciones::get_id_num($this->idPerfil);
		$respuesta = ControladorPerfil::ctrMostrarPerfil(self::$ID, $valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	ACTIVAR PERFIL
	=============================================*/	

	public function ajaxActivarPerfil()
	{

		$valor = (int) var_desencripta($this->idPerfil); // Desencritar id
		$respuesta = ModeloPerfil::mdlActualizarPerfil($valor);
 		echo json_encode($respuesta);
	}
	/*=============================================
	PERMISOS ASIGNADOS DEL PERFIL
	=============================================*/	

	public function ajaxPermisosPerfil()
	{

		$valor = (int) var_desencripta($this->idPerfil); // Desencritar id
		$respuesta = ControladorPerfil::ctrMostrarPermisosPerfil($valor);
		echo json_encode($respuesta);
	}
		/*=============================================
	PERMISOS POR ASIGNAR DEL PERFIL
	=============================================*/	

	public function ajaxPermisosPendientesPerfil()
	{

		$valor = (int) var_desencripta($this->idPerfil); // Desencritar id
		$respuesta = ControladorPerfil::ctrMostrarPermisosPendientesPerfil($valor);
		echo json_encode($respuesta);
	}

	/*=============================================
	MENUS ASIGNADOS DEL PERFIL
	=============================================*/	

	public function ajaxMenuPerfil()
	{

		$valor = (int) var_desencripta($this->idPerfil); // Desencritar id
		$respuesta = ControladorPerfil::ctrMostrarMenuPerfil($valor);
		echo json_encode($respuesta);
	}
		/*=============================================
	MENUS POR ASIGNAR DEL PERFIL
	=============================================*/	

	public function ajaxMenuPendientesPerfil()
	{

		$valor = (int) var_desencripta($this->idPerfil); // Desencritar id
		$respuesta = ControladorPerfil::ctrMostrarMenuPendientesPerfil($valor);
		echo json_encode($respuesta);
	}

}

/*=============================================
MODIFICAR PERFIL
=============================================*/	
if(isset($_POST["idperfil"]))
{

	$perfil_e = new AjaxPerfil();
	$perfil_e -> idPerfil = $_POST["idperfil"];
	$perfil_e -> ajaxModificarPerfil();
}
/*=============================================
EXPORTAR PERFIL
=============================================*/	
if(isset($_POST["idvista_exportar"])){
	$valor = funciones::get_id_num($_POST["idvista_exportar"]); // Desencritar id
	$perfil2 = new AjaxPerfil($valor);
	$perfil2 -> columnasEntidad();
}
/*=============================================
FILTRO : OBTENER LOS FILTROS POR USUARIO
=============================================*/	
if(isset($_POST["idvista_entidad"]) && isset($_POST["idusuario"])){
	$valor_idvista = funciones::get_id_num($_POST["idvista_entidad"]);
	$valor_idusuario = funciones::get_id_num($_POST["idusuario"]);

	$perfil3 = new AjaxPerfil($valor_idvista);
	$perfil3 -> filtro($valor_idusuario);
}
/*=============================================
FILTRO : OBTENER LOS CAMPOS DE LA ENTIDAD
=============================================*/	
if(isset($_POST["vista_id"])){
	$valor = funciones::get_id_num($_POST["vista_id"]);
	$perfil4 = new AjaxPerfil($valor);
	$perfil4 -> columnasEntidad();
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

			$perfil5 = new AjaxPerfil($id_vista);			
			$perfil5 -> registrarFiltro($id_filtro,$id_usuario, $datos);

		break;


		case 'Sinfiltro':
			$id_vista = funciones::get_id_num($_POST["idVista"]);
			$id_filtro = funciones::get_id_num($_POST["idFiltro"]);
			$id_usuario = funciones::get_id_num($_POST["idUsuario"]);
			$datos = array();

			$perfil5 = new AjaxPerfil($id_vista);			
			$perfil5 -> registrarFiltro($id_filtro,$id_usuario, $datos);

		break;

		case "activarydesactivar":
		break;


		case "listar":
		break;

		case "eliminar_categoria":
		break;


	}

 }

/*=============================================
ACTIVAR PERFIL
=============================================*/	

if(isset($_POST["PerfilID"])){
	$perfil_a = new AjaxPerfil();
	$perfil_a -> idPerfil = $_POST["PerfilID"];
	$perfil_a -> ajaxActivarPerfil();
}

/*=============================================
ROLES ASIGNADOS AL PERFIL
=============================================*/	

if(isset($_POST["idperfil_asignar"])){
	$perfil_a1 = new AjaxPerfil();
	$perfil_a1 -> idPerfil = $_POST["idperfil_asignar"];
	$perfil_a1 -> ajaxPermisosPerfil();
}
/*=============================================
ROLES POR ASIGNAR AL PERFIL
=============================================*/	

if(isset($_POST["idperfil_pendiente"])){
	$perfil_a2 = new AjaxPerfil();
	$perfil_a2 -> idPerfil = $_POST["idperfil_pendiente"];
	$perfil_a2 -> ajaxPermisosPendientesPerfil();
}

/*=============================================
MENUS ASIGNADOS AL PERFIL
=============================================*/	

if(isset($_POST["idperfil_asignarm"])){
	$perfil_a3 = new AjaxPerfil();
	$perfil_a3 -> idPerfil = $_POST["idperfil_asignarm"];
	$perfil_a3 -> ajaxMenuPerfil();
}
/*=============================================
MENUS POR ASIGNAR AL PERFIL
=============================================*/	

if(isset($_POST["idperfil_pendientem"])){
	$perfil_a4 = new AjaxPerfil();
	$perfil_a4 -> idPerfil = $_POST["idperfil_pendientem"];
	$perfil_a4 -> ajaxMenuPendientesPerfil();
}