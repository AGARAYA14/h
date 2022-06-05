<?php
error_reporting(error_reporting() & ~E_NOTICE);

class ControladorPerfil{
	protected static $tabla = 'Perfil';

	/*=============================================
	CREAR PERFIL
	=============================================*/

	static public function ctrCrearPerfil(){

		if(isset($_POST["nuevoPerfil"]))
		{
			$accion="guardar";

			$NewCodigo=limpiar_cadena($_POST["nuevoCodigo"]);
			$NewPerfil=limpiar_cadena($_POST["nuevoPerfil"]);
			$NewEstado=var_check($_POST["nuevoEstado"]);		

			$bl_Codigo = var_valida_texto ($NewCodigo);
			$bl_Perfil = var_valida_texto ($NewPerfil);
			$bl_Estado = var_valida_numero ($NewEstado);
			
			if($bl_Codigo && $bl_Perfil && $bl_Estado)
			{


				$datos = array(
								"Codigo" => $NewCodigo,
					           	"Perfil" => $NewPerfil,
					           	"Estado" => $NewEstado
					           );


				$respuesta = ModeloPerfil::mdlIngresarPerfil(self::$tabla, $datos);
				$alerta = array();


				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Perfil ha sido creado";
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
					$alerta["Titulo"]="¡El Perfil no puede ir vacío o llevar caracteres especiales!";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);

			}
			

		}

	}

	/*=============================================
	MOSTRAR PERFIL
	=============================================*/

	static public function ctrMostrarPerfil($item, $valor){

		$respuesta = ModeloPerfil::mdlMostrarPerfil(self::$tabla, $item, $valor);
		return $respuesta;
	
	}

	/*=============================================
	MODIFICAR PERFIL
	=============================================*/

	static public function ctrModificarPerfil(){

		//var_dump($_POST["modificarPerfil"]);
		if(isset($_POST["modificarPerfil"]))
		{

			$accion="guardar";

			$NewCodigo=limpiar_cadena($_POST["modificarCodigo"]);
			$NewPerfil=limpiar_cadena($_POST["modificarPerfil"]);
			$NewEstado=var_check($_POST["modificarEstado"]);		
			$id=$_POST["idPerfil"];

			$bl_Codigo = var_valida_texto ($NewCodigo);
			$bl_Perfil = var_valida_texto ($NewPerfil);
			$bl_Estado = var_valida_numero ($NewEstado);

			if($bl_Codigo && $bl_Perfil && $bl_Estado)
			{


				$datos = array(
								"Codigo" => $NewCodigo,
					           	"Perfil" => $NewPerfil,
					           	"Estado" => $NewEstado,
					           	"id" => $id
					           );

				//var_dump($datos);
				$respuesta = ModeloPerfil::mdlModificarPerfil(self::$tabla, $datos);
				$alerta = array();

				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Perfil ha sido modificado correctamente";
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
					$alerta["Titulo"]="¡El Perfil no puede ir vacío o llevar caracteres especiales!";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);

				}
			
		}
		


	}

	/*=============================================
	BORRAR PERFIL
	=============================================*/

	static public function ctrBorrarPerfil(){

		if(isset($_GET["idPerfil"])){

			$accion="guardar";

			$idPerfil = (int) var_desencripta ($_GET["idPerfil"]);
			$bl_id = var_valida_numero ($idPerfil);

			if($bl_id)
			{

				$respuesta = ModeloPerfil::mdlBorrarPerfil(self::$tabla, $idPerfil);

				$alerta = array();

				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Perfil ha sido borrado correctamente";
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
					$alerta["Titulo"]="¡El Perfil no puede ser eliminado!";
					$alerta["Entidad"]=strtolower(self::$tabla);
					echo sweet_alert ($alerta);

			}
			

		}
		
	}

	/*=============================================
	MOSTRAR PERMISOS ASIGNADOS DEL PERFIL
	=============================================*/

	static public function ctrMostrarPermisosPerfil($valor){

		$respuesta = ModeloPerfil::mdlMostrarPermisosPerfil($valor);
		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR PERMISOS POR ASIGNAR DEL PERFIL
	=============================================*/

	static public function ctrMostrarPermisosPendientesPerfil($valor){

		$respuesta = ModeloPerfil::mdlMostrarPermisosPendientesPerfil($valor);
		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR MENU ASIGNADOS DEL PERFIL
	=============================================*/

	static public function ctrMostrarMenuPerfil($valor){

		$respuesta = ModeloPerfil::mdlMostrarMenuPerfil($valor);
		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR MENU POR ASIGNAR DEL PERFIL
	=============================================*/

	static public function ctrMostrarMenuPendientesPerfil($valor){

		$respuesta = ModeloPerfil::mdlMostrarMenuPendientesPerfil($valor);
		return $respuesta;
	
	}


	/*=============================================
	ASIGNAR PERMISOS AL PERFIL
	=============================================*/

	static public function ctrAsignarPermisosPerfil(){

		//var_dump($_POST["modificarPerfil"]);
		if(isset($_POST["destino"]))
		{
			$accion="guardar";
			$Permiso=$_POST["destino"];
			$id = (int) var_desencripta($_POST["idPerfilp"]); // Desencritar id

			$r1 = ModeloPerfil::mdlEliminarPermisosPerfil($id);
			$n2=count($Permiso);
			$n=0;


				if($r1 == "ok")
				{
					foreach ($Permiso as $a) 
					{
					 $r2 = ModeloPerfil::mdlAsignarPermisosPerfil($id,$a);
					 if($r2 == "ok") { $n += 1; }
					}

					if($n2 ==$n)
					{
						$alerta["Accion"]=$accion;
						$alerta["Tipo"]="success";
						$alerta["Titulo"]="La asignación se completó correctamente";
						$alerta["Entidad"]=strtolower(self::$tabla);
						echo sweet_alert ($alerta);
					} else 
							{
								$alerta["Accion"]=$accion;
								$alerta["Tipo"]="error";
								$alerta["Titulo"]="Ocurrió un error en la asignación, solo se pudieron $n permisos";
								$alerta["Entidad"]=strtolower(self::$tabla);
								echo sweet_alert ($alerta);
							}


				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un error al asignar";
							$alerta["Entidad"]=strtolower(self::$tabla);
							echo sweet_alert ($alerta);
						}

		}
		


	}


	/*=============================================
	ASIGNAR MENU AL PERFIL
	=============================================*/

	static public function ctrAsignarMenuPerfil(){

		if(isset($_POST["mdestino"]))
		{
			$accion="guardar";
			$Permiso=$_POST["mdestino"];
			$id = (int) var_desencripta($_POST["idPerfilm"]); // Desencritar id

			$r1 = ModeloPerfil::mdlEliminarMenuPerfil($id);
			$n2=count($Permiso);
			$n=0;


				if($r1 == "ok")
				{
					foreach ($Permiso as $a) 
					{
					 $r2 = ModeloPerfil::mdlAsignarMenuPerfil($id,$a);
					 if($r2 == "ok") { $n += 1; }
					}

					if($n2 ==$n)
					{
						$alerta["Accion"]=$accion;
						$alerta["Tipo"]="success";
						$alerta["Titulo"]="La asignación se completó correctamente";
						$alerta["Entidad"]=strtolower(self::$tabla);
						echo sweet_alert ($alerta);
					} else 
							{
								$alerta["Accion"]=$accion;
								$alerta["Tipo"]="error";
								$alerta["Titulo"]="Ocurrió un error en la asignación, solo se pudieron $n menus";
								$alerta["Entidad"]=strtolower(self::$tabla);
								echo sweet_alert ($alerta);
							}


				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un error al asignar";
							$alerta["Entidad"]=strtolower(self::$tabla);
							echo sweet_alert ($alerta);
						}

		}
		


	}


}
