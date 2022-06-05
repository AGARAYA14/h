<?php

require_once "../controllers/rol.controlador.php";
require_once "../models/rol.modelo.php";
require_once "../core/funciones.php";
require_once "../core/globales.php";

class AjaxRol
{
	/*=============================================
	ENCONTRAR TIPO
	=============================================*/	
	public $f_tipo;

	public function ajaxBuscarTipo()
	{

		$valor = limpiar_cadena($this->f_tipo); // validar texto
		$respuesta = ControladorRol::ctrBuscarTipo($valor);

		echo json_encode($respuesta);	


	}




	/*=============================================
	EDITAR ROL
	=============================================*/	
	public $idrol;
	public function ajaxEditarRol(){

	if(is_numeric($this->idrol)){
		$item = "pkid";
		$valor = $this->idrol; 
		$respuesta = Controladorrol::ctrMostrarrol($item, $valor);

		echo json_encode($respuesta);
	} else {

		$item = "pkid";
		$valor = (int) var_desencripta($this->idrol); // Desencritar id
		$respuesta = Controladorrol::ctrMostrarrol($item, $valor);

		echo json_encode($respuesta);	
	}



	}
}

/*=============================================
EDITAR rol
=============================================*/	
if(isset($_GET["B_Tipo"])){

	$b_tipo = new AjaxRol();
	$b_tipo -> f_tipo = $_GET["B_Tipo"];
	$b_tipo -> ajaxBuscarTipo();
}


/*=============================================
EDITAR rol
=============================================*/	
if(isset($_POST["idrol"])){

	$rol = new AjaxRol();
	$rol -> idrol = $_POST["idrol"];
	$rol -> ajaxEditarRol();
}