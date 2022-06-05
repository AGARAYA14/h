<?php
//require_once "../core/funciones.php";
//require_once "../core/globales.php";

class ControladorModulo{

protected static $tabla = 'Modulo';

	/*=============================================
	CREAR MODULO
	=============================================*/

	static public function ctrCrearModulo(){

		if(isset($_POST["nuevoModulo"]))
		{
			$accion="guardar";

			$NewModulo=limpiar_cadena($_POST["nuevoModulo"]);
			$NewOrden=limpiar_cadena($_POST["nuevoOrden"]);

			$bl_modulo = var_valida_texto ($NewModulo);
			$bl_orden = var_valida_numero ($NewOrden);

			//$tabla = "Modulo";
			if($bl_modulo && $bl_orden)
			{


				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden
					           );


				$respuesta = ModeloModulo::mdlIngresarModulo(self::$tabla, $datos);
				$alerta = array();


				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Módulo ha sido creado";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);
				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un error al guardar";
							$alerta["Entidad"]=strtolower(self::$tabla);
							echo sweet_alert ($alerta);
						}


			}else{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="error";
					$alerta["Titulo"]="¡El Módulo no puede ir vacío o llevar caracteres especiales!";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);

			}

		}

	}

	/*=============================================
	MOSTRAR MODULO
	=============================================*/

	static public function ctrMostrarModulo($item, $valor){

		//$tabla = "Modulo";
		$respuesta = ModeloModulo::mdlMostrarModulo(self::$tabla, $item, $valor);
		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarModulo(){


		if(isset($_POST["editarModulo"])){

			$accion="guardar";

			$NewModulo=limpiar_cadena($_POST["editarModulo"]);
			$NewOrden=limpiar_cadena($_POST["editarOrden"]);
			$id=$_POST["idModulo"];

			$bl_modulo = var_valida_texto ($NewModulo);
			$bl_orden = var_valida_numero ($NewOrden);

			//$tabla = "Modulo";
			if($bl_modulo && $bl_orden)
			{


				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden,
					           	"id" => $id
					           );


				$respuesta = ModeloModulo::mdlEditarModulo(self::$tabla, $datos);
				$alerta = array();
				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Módulo ha sido modificado correctamente";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);
				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un error al modificar";
							$alerta["Entidad"]=strtolower(self::$tabla);
							echo sweet_alert ($alerta);
						}


			}else{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="error";
					$alerta["Titulo"]="¡El Módulo no puede ir vacío o llevar caracteres especiales!";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);

			}
			}
		


	}

	/*=============================================
	BORRAR MODULO
	=============================================*/

	static public function ctrBorrarModulo(){

		if(isset($_GET["idModulo"])){

			$accion="guardar";

			$idModulo = (int) var_desencripta ($_GET["idModulo"]);
			$bl_id = var_valida_numero ($idModulo);

			if($bl_id)
			{

				//$tabla ="Modulo";
				//$datos = $idModulo //$_GET["idModulo"];

				$respuesta = ModeloModulo::mdlBorrarModulo(self::$tabla, $idModulo);

				$alerta = array();

				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Módulo ha sido borrado correctamente";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);
				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un error al eliminar";
							$alerta["Entidad"]=strtolower(self::$tabla);
							echo sweet_alert ($alerta);
						}


			}else{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="error";
					$alerta["Titulo"]="¡El Módulo no puede ser eliminado!";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);

			}
			

		}
		
	}
}
