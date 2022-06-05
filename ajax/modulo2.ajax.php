<?php
require_once "ajax.php";
require_once "../controladores/modulo.controlador.php";
require_once "../modelos/modulo.modelo.php";
// require_once "../core/funciones.php";
// require_once "../core/globales.php";

class AjaxModulo extends Ajax{

	protected static $ID = 'pkid';
	public $idModulo;
	public $idModulo_vista;
	public $idusuario;

	/*=============================================
	Funcion Constructor
	=============================================*/
	public function __construct ($usuario){
		$this->tabla=$tabla;
		$this->idusuario=$usuario;
	}

	/*=============================================
	MODIFICAR MODULO
	=============================================*/	
	public function ajaxModificarModulo(){

		$valor = funciones::get_id_num($this->idModulo);
		$respuesta = ControladorModulo::ctrMostrarModulo(self::$ID, $valor);
		echo json_encode($respuesta);

	}
	/*=============================================
	EXPORTAR MODULO
	=============================================*/		
	public function ajaxColumnasModulo(){

		$valor = $this->idModulo_vista; // Desencritar id
		$respuesta = ControladorModulo::ctrRecuperaColumnasModulo($valor);
		echo json_encode($respuesta);

	}
	/*=============================================
	FILTRO MODULO
	=============================================*/		
	public function ajaxFiltro(){

		// Cuando viene de la entidad utiliza la encriptación, cuando va hacia el combo viaja en entero
		$valor_idvista = funciones::get_id_num($this->idModulo_vista);
		$valor_idusuario = funciones::get_id_num($this->idusuario);

		$respuesta = ControladorModulo::ctrMostrarFiltroModulo($valor_idvista, $valor_idusuario);
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

	$modulo2 = new AjaxModulo();
	$modulo2 -> idModulo_vista = $_POST["idvista_exportar"];
	$modulo2 -> ajaxColumnasModulo();
}
/*=============================================
FILTRO : OBTENER LOS FILTROS POR USUARIO
=============================================*/	
if(isset($_POST["idvista_entidad"]) && isset($_POST["idusuario"])){

	$modulo3 = new AjaxModulo();
	$modulo3 -> idModulo_vista = $_POST["idvista_entidad"];
	$modulo3 -> idusuario = $_POST["idusuario"];
	$modulo3 -> ajaxFiltro();
}
/*=============================================
FILTRO : OBTENER LOS CAMPOS DE LA ENTIDAD
=============================================*/	
if(isset($_POST["vista_id"])){
	$modulo4 = new AjaxModulo();
	$modulo4 -> idModulo_vista = $_POST["vista_id"];
	$modulo4 -> ajaxColumnasModulo();
}


if(isset($_GET["op"])){
    
	switch($_GET["op"]){


		case "filtro":

		$n1=count($_POST["f_campo"]);
		// $n2=count($_POST["f_condicion"]);
		// $n3=count($_POST["f_valor"]);
		// $n4=count($_POST["f_enlace"]);

		$id_vista = $_POST["idVista"];
		$id_filtro = $_POST["idFiltro"];

		$bl_IDVista   = funnciones::esNumero ($id_vista);
		$bl_IDfiltro = funnciones::esNumero ($id_filtro);

		if($bl_IDVista && $bl_IDfiltro)
		{
				$r1 = ModeloContenedorVista::mdlEliminarColumnasVista ($IDCV);
				if($r1 == "ok") {

				}
		}

		$datos = array(
			"campo" => $_POST["f_campo"][0],
			"condicion" => $_POST["f_condicion"][0],
			"valor" => $_POST["f_valor"][0],
			"enlace" => $_POST["f_enlace"][0],
			"filtro_id" => $id_filtro,
			"vista_id" => $id_vista

		);

		echo json_encode ($datos);


		break;


		case 'mostrar':
		break;

		case "activarydesactivar":
		break;


		case "listar":
		break;

		case "eliminar_categoria":
		break;


	}

 }