<?php 
require_once "tabla.ajax.php";
require_once "../controladores/perfil.controlador.php";

class TablaPerfil extends Tabla{

	public $IDUsuario;

	// Constructor
	public function __construct ($id){
		// ID Perfil
		$usuario = is_numeric($id) ? $id : (int) funciones::var_desencripta($id);
		$this->IDUsuario=$usuario;
		// Tabla
		parent::__construct(ControladorPerfil::$tabla,$this->IDUsuario);
	}

}

/*=============================================
EXPORTAR PERFIL
=============================================*/	
if(isset($_POST["idperfil"]))
{
$Tabla_Perfil = new TablaPerfil($_POST["idperfil"]);
echo $Tabla_Perfil->formato_json();
}


