<?php
//error_reporting(error_reporting() & ~E_NOTICE);

class ControladorContenedorVista{

	protected static $tabla = 'ContenedorVista';
	protected static $acceso = 'contenedor-vista';

	/*=============================================
	MOSTRAR Contenedor
	=============================================*/

	static public function ctrValidarContenedorVista($tabla, $idusuario){

		$respuesta = ModeloContenedorVista::mdlValidarContenedorVista($tabla, $idusuario);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR Columnas
	=============================================*/

	static public function ctrObtenerColumnasVista($a){

		$respuesta = ModeloContenedorVista::mdlObtenerColumnasVista($a);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR consulta de Query
	=============================================*/

	static public function ctrObtenerConsultaVista($a){

		$respuesta = ModeloContenedorVista::mdlObtenerConsultaVista($a);
		return $respuesta;

	}
	/*=============================================
	OBTENER PERMISOS BOTONERA
	=============================================*/

	static public function ctrObtenerRolesPerfil($tabla, $idusuario){

		$respuesta = ModeloContenedorVista::mdlObtenerRolesPerfil($tabla, $idusuario);
		return $respuesta;

	}
	/*=============================================
	OBTENER PERMISOS GENERALES
	=============================================*/

	static public function ctrObtenerRolesGeneralesPerfil($idusuario){

		$respuesta = ModeloContenedorVista::mdlObtenerRolesGeneralesPerfil($idusuario);
		return $respuesta;

	}
	/*=============================================
	OBTENER PERMISO CREAR  - ENTIDAD
	=============================================*/

	static public function ctrObtenerRolCrearPerfil($tabla, $idperfil){

		$respuesta = ModeloContenedorVista::mdlObtenerRolCrearPerfil($tabla, $idperfil);
		return $respuesta;

	}
	/*=============================================
	OBTENER CAMPOS DE TABLA
	=============================================*/

	static public function ctrObtenerCamposTabla($tabla){

		$respuesta = ModeloContenedorVista::mdlObtenerCamposTabla($tabla);
		return $respuesta;

	}



	/*=============================================
	CREAR ContenedorVista
	=============================================*/

	static public function ctrCrearContenedorVista(){

		if(isset($_POST["nuevoContenedor"]))
		{
			$accion="guardar";

			$NewContenedor=limpiar_cadena($_POST["nuevoContenedor"]);
			$NewConfiguracionVista=limpiar_cadena($_POST["nuevoConfiguracionVista"]);
			$NewConfiguracionVistaQuery=limpiar_cadena_query($_POST["nuevoquery"]);

			$bl_Contenedor = var_valida_texto ($NewContenedor);
			$bl_ConfVista = var_valida_texto ($NewConfiguracionVista);

			
			if($bl_Contenedor && $bl_ConfVista)
			{


				$datos = array(
								"Contenedor" => $NewContenedor,
					           	"ConfVista" => $NewConfiguracionVista,
					           	"Query" => $NewConfiguracionVistaQuery
					           );


				$respuesta = ModeloContenedorVista::mdlIngresarContenedorVista(self::$tabla, $datos);
				$alerta = array();

				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Contenedor ha sido creado";
					$alerta["Entidad"]=strtolower(self::$acceso);
					echo sweet_alert ($alerta);
				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]=$respuesta;//"Ocurrió un error al guardar";
							$alerta["Entidad"]=strtolower(self::$acceso);
							echo sweet_alert ($alerta);
						}


			}else{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="error";
					$alerta["Titulo"]="¡El Contenedor no puede ir vacío o llevar caracteres especiales!";
					$alerta["Entidad"]=strtolower(self::$acceso);
					echo sweet_alert ($alerta);

			}
			

		}

	}

	/*=============================================
	MODIFICAR ContenedorVista
	=============================================*/

	static public function ctrModificarContenedorVista(){

		if(isset($_POST["modificarContenedor"]))
		{
			$accion="guardar";

			$NewContenedor=limpiar_cadena($_POST["modificarContenedor"]);
			$NewConfiguracionVista=limpiar_cadena($_POST["modificarConfiguracionVista"]);
			$NewConfiguracionVistaQuery=limpiar_cadena_query($_POST["modificarquery"]);

			$bl_Contenedor = var_valida_texto ($NewContenedor);
			$bl_ConfVista = var_valida_texto ($NewConfiguracionVista);

			
			if($bl_Contenedor && $bl_ConfVista)
			{


				$datos = array(
								"Contenedor" => $NewContenedor,
					           	"ConfVista" => $NewConfiguracionVista,
					           	"Query" => $NewConfiguracionVistaQuery
					           );


				$respuesta = ModeloContenedorVista::mdlIngresarContenedorVista(self::$tabla, $datos);
				$alerta = array();

				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Contenedor ha sido modificado";
					$alerta["Entidad"]=strtolower(self::$acceso);
					echo sweet_alert ($alerta);
				} else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]=$respuesta;//"Ocurrió un error al guardar";
							$alerta["Entidad"]=strtolower(self::$acceso);
							echo sweet_alert ($alerta);
						}


			}else{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="error";
					$alerta["Titulo"]="¡El Contenedor no puede ir vacío o llevar caracteres especiales!";
					$alerta["Entidad"]=strtolower(self::$acceso);
					echo sweet_alert ($alerta);


			}
			

		}

	}


	/*=============================================
	MOSTRAR CONTENEDOR VISTA
	=============================================*/

	static public function ctrMostrarContenedorVista($item, $valor){

		$respuesta = ModeloContenedorVista::mdlMostrarContenedorVista(self::$tabla, $item, $valor);
		return $respuesta;
	
	}
	/*=============================================
	RECUPERAR COLUMNAS DEL CONTENEDOR VISTA
	=============================================*/

	static public function ctrRecuperarColumnasContenedorVista($valor){

		$respuesta = ModeloContenedorVista::mdlRecuperarColumnasContenedorVista(self::$tabla,$valor);
		return $respuesta;
	
	}
	/*=============================================
	GUARDAR COLUMNAS DE CONTENEDOR 
	=============================================*/

	static public function ctrGuardarColumnasContenedorVista(){

		if(isset($_POST["texto"]))
		{

			$accion="guardar";
			$n=0;
			$n2=count($_POST["texto"]);

			$IDCV =	$_POST["IDCV"];
			$ID   =	$_POST["CID"];

			$bl_ID   = var_valida_numero ($ID);
			$bl_IDCV = var_valida_numero ($IDCV);

			if($bl_ID && $bl_IDCV)
			{

				$r1 = ModeloContenedorVista::mdlEliminarColumnasVista ($IDCV);
				if($r1 == "ok") 
				//if("ok") 
				{
					for($i=0;$i<$n2;$i++) 
					{ 
				    
						$Texto=limpiar_cadena($_POST["texto"][$i]);
						$Ancho=$_POST["ancho"][$i];
						$Orden=$_POST["orden"][$i];
						$Opcion=limpiar_cadena($_POST["opcion"][$i]);
						$NombreSQL=limpiar_cadena($_POST["nombresql"][$i]);
						$Visible= ($_POST["check"][$i])==1?1:0;

						$bl_texto = var_valida_texto ($Texto);
						$bl_ancho = var_valida_numero ($Ancho);
						$bl_orden = var_valida_numero ($Orden);
						$bl_opcion = var_valida_direccion ($Opcion);
						$bl_nombresql = var_valida_texto ($NombreSQL);
						$bl_orden = var_valida_numero ($Orden);



						if($bl_texto && $bl_ancho && $bl_orden && $bl_opcion && $bl_nombresql)
						{ 	
							$datos = array(
											"IDCV"=> $IDCV,
											"texto"=> $Texto,
											"ancho"=> $Ancho,
											"orden"=> $Orden,
											"opcion"=> $Opcion,
											"nombresql"=> $NombreSQL,
											"visible"=> $Visible
								           );

							$r2 = ModeloContenedorVista::mdlAsignarColumnasConfiguracionVista($datos);

							if($r2 == "ok") { $n += 1; }

							var_dump($datos);
						}
						else{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Las columnas no deben tener caracteres especiales";
							$alerta["Entidad"]=strtolower(self::$acceso);
							echo sweet_alert ($alerta);
							break;
							}	
							
					} 

					if($n2 == $n) 
					{
						$alerta["Accion"]=$accion;
						$alerta["Tipo"]="success";
						$alerta["Titulo"]="La asignación se completó correctamente";
						$alerta["Entidad"]=strtolower(self::$acceso);
						echo sweet_alert ($alerta);
					} else {
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un problema en los registros, solo se pudieron $n columnas";
							$alerta["Entidad"]=strtolower(self::$acceso);
							echo sweet_alert ($alerta);
							}
			
				}else {
						$alerta["Accion"]=$accion;
						$alerta["Tipo"]="error";
						$alerta["Titulo"]="Ocurrio un error en el inicio de operación, configuracion de vista incorrecto";
						$alerta["Entidad"]=strtolower(self::$acceso);
						echo sweet_alert ($alerta);
				}

				
			}
			else {
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="error";
					$alerta["Titulo"]="Ocurrio un error en la operación, contenedor incorrecto";
					$alerta["Entidad"]=strtolower(self::$acceso);
					echo sweet_alert ($alerta);
				}
		}

	}

}