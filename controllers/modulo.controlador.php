<?php
libxml_use_internal_errors(true);

class ControladorModulo{

	public static $tabla = 'Modulo';

	/*=============================================
	CRUD: CREAR MODULO
	=============================================*/

	static public function ctrCrearModulo($auditable){

		if(isset($_POST["nuevoModulo"]))
		{
			$NewModulo=funciones::limpiar_cadena($_POST["nuevoModulo"]);
			$NewOrden=funciones::limpiar_cadena($_POST["nuevoOrden"]);

			// Crear array de variables recibidas
			$variables =array(
								1 => array ($NewModulo,"Texto"),
								2 => array ($NewOrden,"Numero")
								);

			// Enviar a su revisión si son valores validos
			$rspta = helper::evaluar_datos($variables);

			// validar que no hayan regresado valores incorrectos
			if(empty($rspta))
			{
				// Preparación de la data
				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlIngresarModulo($datos);

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
	CRUD: MODIFICAR MODULO
	=============================================*/

	static public function ctrModificarModulo($auditable){

		if(isset($_POST["modificarModulo"])){
			$NewModulo=funciones::limpiar_cadena($_POST["modificarModulo"]);
			$NewOrden=funciones::limpiar_cadena($_POST["modificarOrden"]);

			$id=$_POST["idModulo"];

			// Crear array de variables recibidas
			$variables =array(
								1 => array ($NewModulo,"Texto"),
								2 => array ($NewOrden,"Numero")
								);

			// Enviar a su revisión si son valores validos
			$rspta = helper::evaluar_datos($variables);

			// validar que no hayan regresado valores incorrectos
			if(empty($rspta))
			{
				// Preparación de la data
				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden,
					           	"id" => $id
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlModificarModulo(self::$tabla,$datos);

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
	CRUD: BORRAR MODULO
	=============================================*/

	static public function ctrBorrarModulo($auditable){

		if(isset($_GET["idModulo"])){

			$idModulo  = funciones::get_id_num($_GET["idModulo"]);
			$bl_id = funciones::esNumero ($idModulo);

			if($bl_id)
			{
				$obj_Modulo = ControladorModulo::ctrMostrarModulo("pkid", $idModulo);
				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlBorrarModulo(self::$tabla, $idModulo);

				// Evaluar auditoria
				if ($auditable) {
					if ($respuesta==OK) { util::registrarAuditoria(self::$tabla,CRUD_ELIMINAR,$obj_Modulo,$idModulo);	}
					}

				// Impresión del mensaje
				echo helper::notificar (self::$tabla, $respuesta, EJECUTAR3, TOAST, CRUD_ELIMINAR);

			}else{

				echo helper::notificar (self::$tabla, INVALIDO, EJECUTAR3, SWEET, CRUD_ELIMINAR);

			}
			

		}
	}


	/*=============================================
	MOSTRAR MODULO : Trae información de la tabla
	=============================================*/

	static public function ctrMostrarModulo($item, $valor){

		$respuesta = ModeloModulo::mdlMostrarModulo(self::$tabla, $item, $valor);
		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR FILTRO MODULO: Trae los filtro asociados
	=============================================*/

	static public function ctrMostrarFiltroModulo($IDConfigVista, $IDUsuario){

		$respuesta = ModeloModulo::mdlMostrarFiltroModulo($IDConfigVista, $IDUsuario);
		return $respuesta;
	
	}

	/*=============================================
	EXPORTAR MODULO : Recuperar las columnas
	=============================================*/

	static public function ctrRecuperaColumnasModulo($valor){

		$respuesta = ModeloModulo::mdlRecuperaColumnasModulo($valor);
		return $respuesta;
	
	}

	/*=============================================
	IMPORTAR MODULO
	=============================================*/
	static public function ctrImportarModulo(){

		if(isset($_FILES["archivo"]))
		{
			    //--- CAPTURAR EL ARCHIVO Y RECONOCER LA TILDE --- 
			    $archivo = utf8_decode($_FILES["archivo"]["name"]); 
			    //echo '<pre>'; print_r(archivo); echo '</pre>';
			    $archivo_ruta = $_FILES["archivo"]["tmp_name"];
			    $archivo_tipo = $_FILES["archivo"]["type"];
			    $archivo_size = $_FILES["archivo"]["size"];
			    //echo '<pre>'; print_r(archivo_size); echo '</pre>';
			    //$archivo_error = $_FILES["archivo"]["error"];
			    //$archivo_guardado = "COPIA_".$archivo;
			    
			    //--- ESTABLECER LA RUTA DE LA CARPETA --- 
		    	$carpeta = './archivos/excel/importacion/'.self::$tabla.'/';

		    	// Crear la carpeta si no existe
				if (!file_exists($carpeta)) {	mkdir($carpeta, 0777, true);}  

				// Mover el archivo a la carpeta
		        $ruta_destino =$carpeta.$archivo;
		        move_uploaded_file($archivo_ruta, $ruta_destino);

				//---VALIDAR EL TIPO Y PESO DEL ARCHIVO --- 
				$bl_tipo_archivo = funciones::validar_tipo_archivo(IMPORTAR,$archivo);
				$bl_peso_archivo = funciones::validar_peso_archivo(IMPORTAR,(int)$archivo_size);

				if($bl_tipo_archivo) 
				{
					if($bl_peso_archivo)
					{
						//---INICIAMOS LA CONEXION --- 
					   $objPHPExcel = PHPEXCEL_IOFactory::load($ruta_destino); 
					   $objPHPExcel->setActiveSheetIndex(0); //Leer hoja numero 0
					        
					   $num_filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); // obtener fila de la hoja activa
					    //$num_columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn(); // obtener ultima columnas
					    //$rango = $objPHPExcel->setActiveSheetIndex(0)->calculateWorksheetDimension(); // rango de celdas

					   $n=0; 					// contar cuantos registros fueron exitosos
					   $no_validos=[]; 			// contar cuantos registros no fueron exitosos
					   $detalle_no_validos='';	// obtener las filas no exitosas


						//--- MODULO  - Validamos la columna
						$EsModulo = funciones::limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('A1')->getCalculatedValue());
						        
						//--- ORDEN - Validamos la columna
						$EsOrden = funciones::limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('B1')->getCalculatedValue());

						if ($EsModulo=="MODULO" && $EsOrden=="ORDEN") 
						{
							// iniciamos en 2 porque desde la segunda fila
							for($i = 2; $i <= $num_filas; $i++)
							{     
							        //--- MODULO  - Obtenemos el valor y limpiamos cadena
							        $modulo = funciones::limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
							        
							        //--- ORDEN - Obtenemos el valor y limpiamos cadena
							        $orden = (int)funciones::limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

									// Crear array de variables recibidas
									$variables =array(
														1 => array ($modulo,"Texto"),
														2 => array ($orden,"Numero")
														);

									// Enviar a su revisión si son valores validos
									$rspta = helper::evaluar_datos($variables);

									// $bl_modulo = funciones::esTexto ($modulo);
									// $bl_orden = funciones::esNumero($orden);

									// validar que no hayan regresado valores incorrectos
									if(empty($rspta)) {
										// Preparación de la data
										$datos = array(
														"modulo" => $modulo,
											           	"orden" => $orden
											           );

										// Respuesta de la base de datos
										$respuesta = ModeloModulo::mdlIngresarModulo($datos);
										if($respuesta == OK) { $n += 1; } else { array_push($no_validos,$i);}
							    	} else { array_push($no_validos,$i);}
							}

							//---VERIFICAR SI NO HAN HABIDO REGISTROS MALOS --- 
							if (sizeof($no_validos)>0) {
								foreach ($no_validos as $a) { $detalle_no_validos .= "(".strval($a).") "; }}
							
							//---COMPARAR RESULTADOS --- 							
						    if($num_filas-1 ==$n) {
						    	// Borrar archivo excel
								unlink($ruta_destino);
						    	echo helper::notificar (self::$tabla,IMPORTAR, EJECUTAR2,SWEET);
						    }else 
								{
							    	// Borrar archivo excel
									unlink($ruta_destino);
									echo helper::notificar (self::$tabla, ERROR_IMPORTACION, EJECUTAR2,SWEET,'',$detalle_no_validos);
								} //-------------------------------------

						} else {
									unlink($ruta_destino);
									echo helper::notificar (self::$tabla,COLUMNA_INVALIDA, EJECUTAR,SWEET);
								}
						//---------------------------------------------------------

					}else { echo helper::notificar (self::$tabla, PESO_INVALIDO, EJECUTAR,SWEET); }

				}else  { echo helper::notificar (self::$tabla, TIPO_INVALIDO, EJECUTAR,SWEET); }


		}
		//---------------------------------------------------
	}


















//---------------------FIN DE LA CLASE-----------------------------------

}
