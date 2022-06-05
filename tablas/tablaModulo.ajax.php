<?php 
require_once "tabla.ajax.php";
// require_once "../core/funciones.php";
require_once "../controllers/modulo.controlador.php";

class TablaModulo extends Tabla{

	public $IDUsuario;

	// Constructor
	public function __construct ($id){
		// ID Perfil
		$usuario = is_numeric($id) ? $id : (int) funciones::var_desencripta($id);
		$this->IDUsuario=$usuario;
		// Tabla
		parent::__construct(ControladorModulo::$tabla,$this->IDUsuario);
	}

}

/*=============================================
EXPORTAR MODULO
=============================================*/	
if(isset($_POST["idperfil"]))
{
$Tabla_Modulo = new TablaModulo($_POST["idperfil"]);
echo $Tabla_Modulo->formato_json();
}


