<?php
libxml_use_internal_errors(true);
//error_reporting(error_reporting() & ~E_NOTICE);

class ControladorPerfil{
	public static $tabla = 'Perfil';

	/*=============================================
	CRUD: CREAR PERFIL
	=============================================*/

	static public function ctrCrearPerfil($auditable){

		if(isset($_POST["nuevoPerfil"]))
		{
			$NewCodigo=funciones::limpiar_cadena($_POST["nuevoCodigo"]);
			$NewPerfil=funciones::limpiar_cadena($_POST["nuevoPerfil"]);
			$NewEstado=funciones::var_check($_POST["nuevoEstado"]);
			// Crear array de variables recibidas
			$variables =array(
								1 => array ($NewCodigo,"Texto"),
								2 => array ($NewPerfil,"Texto"),
								3 => array ($NewEstado,"Numero")
								);

			// Enviar a su revisión si son valores validos
			$rspta = helper::evaluar_datos($variables);

			// validar que no hayan regresado valores incorrectos
			if(empty($rspta))
			{
				// Preparación de la data
				$datos = array(
								"Codigo" => $NewCodigo,
					           	"Perfil" => $NewPerfil,
					           	"Estado" => $NewEstado
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloPerfil::mdlIngresarPerfil($datos);

				// Evaluar auditoria
				if ($auditable) {
					if ($respuesta==OK) { util::registrarAuditoria(self::$tabla,CRUD_CREAR,$datos); }
				}
				

				// Impresión del mensaje
				echo helper::notificar (self::$tabla, $respuesta, EJECUTAR, TOAST, CRUD_CREAR);

			}else{
				// Mostrar alerta de los errores
				echo helper::notificar (self::$tabla, INVALIDO, EJECUTAR,SWEET, CRUD_CREAR,funciones::concatena_array($rspta));
				}
		}
	}

	/*=============================================
	CRUD: MODIFICAR PERFIL
	=============================================*/

	static public function ctrModificarPerfil($auditable){

		if(isset($_POST["modificarPerfil"]))
		{
			$NewCodigo=funciones::limpiar_cadena($_POST["modificarCodigo"]);
			$NewPerfil=funciones::limpiar_cadena($_POST["modificarPerfil"]);
			$NewEstado=funciones::var_check($_POST["modificarEstado"]);		
			$id=$_POST["idPerfil"];

			// Crear array de variables recibidas
			$variables =array(
								1 => array ($NewCodigo,"Texto"),
								2 => array ($NewPerfil,"Texto"),
								3 => array ($NewEstado,"Numero")
								);

			// Enviar a su revisión si son valores validos
			$rspta = helper::evaluar_datos($variables);

			// validar que no hayan regresado valores incorrectos
			if(empty($rspta))
			{
				// Preparación de la data
				$datos = array(
								"Codigo" => $NewCodigo,
					           	"Perfil" => $NewPerfil,
					           	"Estado" => $NewEstado,
					           	"id" => $id
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloPerfil::mdlModificarPerfil(self::$tabla,$datos);

				// Evaluar auditoria
				if ($auditable) {
					if ($respuesta==OK) { util::registrarAuditoria(self::$tabla,CRUD_EDITAR,$datos,$id); }
				}

				// Impresión del mensaje
				echo helper::notificar (self::$tabla, $respuesta, EJECUTAR, TOAST, CRUD_EDITAR);

			}else{
				// Mostrar alerta de los errores
				echo helper::notificar (self::$tabla, INVALIDO, EJECUTAR, SWEET,CRUD_EDITAR,funciones::concatena_array($rspta));
				}
		
		}
		


	}

	/*=============================================
	CRUD: BORRAR PERFIL
	=============================================*/

	static public function ctrBorrarPerfil($auditable){

		if(isset($_GET["idPerfil"])){

			$idPerfil  = funciones::get_id_num($_GET["idPerfil"]);
			$bl_id = funciones::esNumero ($idPerfil);

			if($bl_id)
			{
				$obj_Perfil = ControladorPerfil::ctrMostrarPerfil("pkid", $idPerfil);
				// Respuesta de la base de datos
				$respuesta = ModeloPerfil::mdlBorrarPerfil(self::$tabla, $idPerfil);

				// Evaluar auditoria
				if ($auditable) {
					if ($respuesta==OK) { util::registrarAuditoria(self::$tabla,CRUD_ELIMINAR,$obj_Perfil,$idPerfil);	}
					}

				// Impresión del mensaje
				echo helper::notificar (self::$tabla, $respuesta, EJECUTAR3, TOAST, CRUD_ELIMINAR);

			}else{

				echo helper::notificar (self::$tabla, INVALIDO, EJECUTAR3, SWEET, CRUD_ELIMINAR);

			}	

		}
		
	}

	/*=============================================
	MOSTRAR PERFIL : Trae información de la tabla
	=============================================*/

	static public function ctrMostrarPerfil($item, $valor){

		$respuesta = ModeloPerfil::mdlMostrarPerfil(self::$tabla, $item, $valor);
		return $respuesta;
	
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
