<?php

require_once "../controllers/contenedor_vista.controlador.php";
require_once "../models/contenedor_vista.modelo.php";
require_once "../core/funciones.php";
require_once "../core/globales.php";

class AjaxContenedor{

	protected static $ID = 'pkid';
	protected static $tabla = 'ContenedorVista';
	public $idContenedor;

	/*=============================================
	EDITAR CONTENEDOR VISTA
	=============================================*/	

	public function ajaxModificarContenedor()
	{

			if (is_numeric($this->idContenedor)){
				$valor=$this->idContenedor;
			}else {
				$valor = (int) var_desencripta($this->idContenedor); // Desencritar id
			}

		$respuesta = ControladorContenedorVista::ctrMostrarContenedorVista(self::$ID, $valor);
		echo json_encode($respuesta);
	}
	/*=============================================
	RECUPERAR COLUMNAS DEL CONTENEDOR VISTA
	=============================================*/	

	public function ajaxRecuperarColumnasContenedor()
	{

		$valor = (int) var_desencripta($this->idContenedor); // Desencritar id
		$respuesta = ControladorContenedorVista::ctrRecuperarColumnasContenedorVista($valor);
		echo json_encode($respuesta);
	}


	}

/*=============================================
EDITAR CONTENEDOR VISTA
=============================================*/	
if(isset($_POST["idcontenedor"]))
{

	$contenedor = new AjaxContenedor();
	$contenedor -> idContenedor = $_POST["idcontenedor"];
	$contenedor -> ajaxModificarContenedor();
}
/*=============================================
RECUPERAR COLUMNAS CONTENEDOR VISTA
=============================================*/	
if(isset($_POST["ContenedorID"]))
{

	$contenedor2 = new AjaxContenedor();
	$contenedor2 -> idContenedor = $_POST["ContenedorID"];
	$contenedor2 -> ajaxRecuperarColumnasContenedor();
}







