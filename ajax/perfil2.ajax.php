<?php

require_once "../controladores/perfil.controlador.php";
require_once "../modelos/perfil.modelo.php";
require_once "../core/funciones.php";
require_once "../core/globales.php";

class AjaxPerfil{

	protected static $ID = 'pkid';
	protected static $tabla = 'Perfil';
	public $idPerfil;

	/*=============================================
	EDITAR PERFIL
	=============================================*/	

	public function ajaxModificarPerfil()
	{

		$valor = (int) var_desencripta($this->idPerfil); // Desencritar id
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
EDITAR PERFIL
=============================================*/	
if(isset($_POST["idperfil"]))
{

	$perfil_e = new AjaxPerfil();
	$perfil_e -> idPerfil = $_POST["idperfil"];
	$perfil_e -> ajaxModificarPerfil();
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