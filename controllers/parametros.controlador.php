<?php
libxml_use_internal_errors(true);

class ControladorParametros{

public static $tabla = 'Parametros';

	/*=============================================
	PARAMETROS : Recuperar los parametros del sistema
	=============================================*/

	static public function ctrParametros(){

		$respuesta = ModeloParametros::mdlParametros();
		return funciones::get_array($respuesta,'Parametro','Valor');
	}

	/*=============================================
	PAGINAS : Recuperar los paginas habilitadas (lista blanca)
	=============================================*/
	static public function ctrPaginas(){

		$respuesta = ModeloParametros::mdlPaginas();
		return funciones::get_array($respuesta,'link');
	}


	static public function render_pagina($view) {

		if (is_file(PAGINAS.$view.'.php')) {
			include PAGINAS.$view.'.php';
		}
		else if (is_file(MODULOS.$view.'.php')) {
			include MODULOS.$view.'.php';
		}
		else if (is_file(REPORTES.$view.'.php')) {
			include REPORTES.$view.'.php';
		}
		else {
			die();
		}


}



}