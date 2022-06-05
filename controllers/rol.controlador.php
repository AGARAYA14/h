<?php
//error_reporting(error_reporting() & ~E_NOTICE);

class ControladorRol{

	protected static $tabla = 'Rol';

	
	/*=============================================
	BUSCAR TIPO
	=============================================*/

	static public function ctrBuscarTipo($valor){

		$respuesta = ModeloRol::mdlBuscarTipo($valor);
		return $respuesta;
	
	}


	/*=============================================
	CREAR ROL
	=============================================*/

	static public function ctrCrearRol(){

		if(isset($_POST["nuevoCodigo"]))
		{
			$accion="guardar";

			$NewCodigo=limpiar_cadena($_POST["nuevoCodigo"]);
			$NewRol=limpiar_cadena($_POST["nuevoRol"]);
			$NewDescripcion=limpiar_cadena($_POST["nuevoDescripcion"]);
			$NewTipoBoton=limpiar_cadena($_POST["nuevoTipoBoton"]);
			$NewBoton=limpiar_cadena($_POST["nuevoBoton"]);
			$NewModal=limpiar_cadena($_POST["nuevoModal"]);
			$NewTipo=limpiar_cadena($_POST["nuevoTipo"]);
			$NewIcono=limpiar_cadena($_POST["nuevoIcono"]);
			$NewOrden=limpiar_cadena($_POST["nuevoOrden"]);
			$NewCreacion=var_check($_POST["nuevoCreacion"]);
			$NewAuditable=var_check($_POST["nuevoAuditable"]);

			$bl_Codigo = var_valida_texto ($NewCodigo);
			$bl_Descripcion = var_valida_texto ($NewDescripcion);
			$bl_Rol = var_valida_texto ($NewRol);
			$bl_TipoBoton = var_valida_texto ($NewTipoBoton);
			$bl_Boton = var_valida_texto ($NewBoton);
			$bl_Modal = var_valida_texto ($NewModal);
			$bl_Tipo = var_valida_texto ($NewTipo);
			$bl_Icono = var_valida_texto ($NewIcono);

			$bl_Orden = var_valida_numero ($NewOrden);
			$bl_Creacion = var_valida_numero ($NewCreacion);
			$bl_Auditable = var_valida_numero ($NewAuditable);

				
			
			if($bl_Contenedor && $bl_ConfVista)
			{


				$datos = array(
								"Contenedor" => $NewContenedor,
					           	"ConfVista" => $NewConfiguracionVista,
					           	"Query" => $NewConfiguracionVistaQuery
					           );


				$respuesta = ModeloRol::mdlIngresarRol(self::$tabla, $datos);
				$alerta = array();

				if($respuesta == "ok")
				{
					$alerta["Accion"]=$accion;
					$alerta["Tipo"]="success";
					$alerta["Titulo"]="El Rol ha sido creado";
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
	MODIFICAR ROL
	=============================================*/

	static public function ctrModificarRol(){

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


				$respuesta = ModeloRol::mdlIngresarRol(self::$tabla, $datos);
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
	MOSTRAR ROL
	=============================================*/

	static public function ctrMostrarRol($item, $valor){

		$respuesta = ModeloRol::mdlMostrarRol(self::$tabla, $item, $valor);
		return $respuesta;
	
	}
	

}