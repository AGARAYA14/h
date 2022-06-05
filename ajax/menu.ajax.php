<?php

require_once "../controllers/menu.controlador.php";
require_once "../models/menu.modelo.php";
require_once "../core/funciones.php";
require_once "../core/globales.php";

class AjaxMenu{

	protected static $ID = 'pkid';
	public $idMenu;
	public $idMenu_vista;

	/*=============================================
	EDITAR MENU
	=============================================*/	

	public function ajaxModificarMenu(){

		if (is_numeric($this->idMenu)){
			$valor=$this->idMenu;
		}else {
			$valor = (int) var_desencripta($this->idMenu); // Desencritar id
		}

		$respuesta = ControladorMenu::ctrMostrarMenu($item, $valor);
		echo json_encode($respuesta);

	}

	/*=============================================
	EXPORTAR MODULO
	=============================================*/		
	public function ajaxColumnasMenu(){

		$valor = $this->idMenu_vista; // Desencritar id
		$respuesta = ControladorMenu::ctrRecuperaColumnasMenu($valor);
		echo json_encode($respuesta);

	}
}

/*=============================================
MODIFICAR MENU
=============================================*/	
if(isset($_POST["idmenu"])){

	$menu = new AjaxMenu();
	$menu -> idMenu = $_POST["idmenu"];
	$menu -> ajaxModificarMenu();
}
/*=============================================
EXPORTAR MODULO
=============================================*/	
if(isset($_POST["idmenuvista"])){

	$menu2 = new AjaxMenu();
	$menu2 -> idMenu_vista = $_POST["idmenuvista"];
	$menu2 -> ajaxColumnasMenu();
}