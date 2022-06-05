<?php
libxml_use_internal_errors(true); //Deshabilita errores libxml y permite al usuario extraer información de errores según sea necesario

class ControladorMenu{
	public static $tabla = 'Menu';

	/*=============================================
	EXPORTAR MENU : Recuperar las columnas
	=============================================*/

	static public function ctrRecuperaColumnasMenu($valor){

		$respuesta = ModeloMenu::mdlRecuperaColumnasMenu($valor);
		return $respuesta;
	
	}

	/*=============================================
	MOSTRAR MENU
	=============================================*/

	static public function ctrMostrarMenu($item, $valor){

		$respuesta = ModeloMenu::mdlMostrarMenu(self::$tabla, $item, $valor);
		return $respuesta;
	
	}

	/*=============================================
	CREAR MENU
	=============================================*/

	static public function ctrCrearMenu(){

		if(isset($_POST["nuevoMenu"]))
		{
			$accion="guardar";

			$IDModulo=(int) var_desencripta($_POST["nuevoModulo"]);
			$IDContenedor=(int) var_desencripta($_POST["nuevoContenedor"]);

			$NewMenu=limpiar_cadena($_POST["nuevoMenu"]);
			$NewLink=limpiar_cadena($_POST["nuevoLink"]);
			$NewIcono=limpiar_cadena($_POST["nuevoIcono"]);
			$NewDescripcion=limpiar_cadena($_POST["nuevoDescripcion"]);

			$bl_IDModulo = var_valida_numero ($IDModulo);
			$bl_IDContendor = var_valida_numero ($IDContenedor);
			$bl_Menu = var_valida_texto ($NewMenu);
			$bl_Link = var_valida_texto ($NewLink);
			$bl_Icono = var_valida_direccion ($NewIcono);
			$bl_Descripcion = var_valida_texto ($NewDescripcion);


			//$tabla = "Menu";
			if($bl_Menu && $bl_Link && $bl_Icono && $bl_Descripcion && $bl_IDModulo && $bl_IDContendor)
			{

				
				$datos = array(
								"IDModulo" => $IDModulo,
					           	"Menu" => $NewMenu,
					           	"Link" => $NewLink,
					           	"Icono" => $NewIcono,
					           	"Descripcion" => $NewDescripcion,
					           	"IDContenedor" => $IDContenedor
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloMenu::mdlIngresarMenu($datos);

				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_CREAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_CREAR);

			}
			

		}

	}

	/*=============================================
	MODIFICAR MENU
	=============================================*/

	static public function ctrModificarMenu(){

		//var_dump($_POST["modificarMenu"]);
		if(isset($_POST["modificarMenu"]))
		{

			$accion="guardar";

			if (is_numeric($_POST["modificarIDModulo"])){
				$IDModulo=$_POST["modificarIDModulo"];
			}else {
				$IDModulo=(int) var_desencripta($_POST["modificarIDModulo"]);
			}
			
			if (is_numeric($_POST["modificarIDContenedor"])){
				$IDContenedor=$_POST["modificarIDContenedor"];
			}else {
				$IDContenedor=(int) var_desencripta($_POST["modificarIDContenedor"]);
			}

			$NewMenu=limpiar_cadena($_POST["modificarMenu"]);
			$NewLink=limpiar_cadena($_POST["modificarLink"]);
			$NewIcono=limpiar_cadena($_POST["modificarIcono"]);
			$NewDescripcion=limpiar_cadena($_POST["modificarDescripcion"]);
			$id=$_POST["idMenu"];
			//$IDModulo=$_POST["modificarIDModulo"];

			$bl_ID = var_valida_numero ($id);
			$bl_IDModulo = var_valida_numero ($IDModulo);
			$bl_IDContenedor = var_valida_numero ($IDContenedor);
			$bl_Menu = var_valida_texto ($NewMenu);
			$bl_Link = var_valida_texto ($NewLink);
			$bl_Icono = var_valida_direccion ($NewIcono);
			$bl_Descripcion = var_valida_texto ($NewDescripcion);


			if($bl_Menu && $bl_Link && $bl_Icono && $bl_Descripcion && $bl_IDModulo && $bl_ID && $bl_IDContenedor)
			{


				$datos = array(
								"IDModulo" => $IDModulo,
					           	"Menu" => $NewMenu,
					           	"Link" => $NewLink,
					           	"Icono" => $NewIcono,
					           	"Descripcion" => $NewDescripcion,
					           	"id" => $id,
					           	"IDContenedor" => $IDContenedor
					           );

				//var_dump($datos);
				$respuesta = ModeloMenu::mdlModificarMenu(self::$tabla, $datos);
				
				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_EDITAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_EDITAR);

				}
			}
	}

	/*=============================================
	BORRAR MENU
	=============================================*/

	static public function ctrBorrarMenu(){

		if(isset($_GET["idMenu"])){

			$idMenu = (int) var_desencripta ($_GET["idMenu"]);
			$bl_id = var_valida_numero ($idMenu);

			if($bl_id)
			{
				// Respuesta de la base de datos
				$respuesta = ModeloMenu::mdlBorrarMenu(self::$tabla, $idMenu);
				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_ELIMINAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_ELIMINAR);

			}
			

		}
		
	}

	/*=============================================
	IMPORTAR MENU
	=============================================*/

	static public function ctrImportarMenu(){

		if(isset($_FILES["archivo"]))
		{
			    //--- CAPTURAR EL ARCHIVO Y RECONOCER LA TILDE --- 
			    $archivo = utf8_decode($_FILES["archivo"]["name"]); 
			    $archivo_ruta = $_FILES["archivo"]["tmp_name"];
			    $archivo_tipo = $_FILES["archivo"]["type"];
			    $archivo_size = $_FILES["archivo"]["size"];

			    //--- ESTABLECER LA RUTA DE LA CARPETA --- 
		    	$carpeta = './archivos/excel/importacion/'.self::$tabla.'/';

		    	// Crear la carpeta si no existe
				if (!file_exists($carpeta)) {	mkdir($carpeta, 0777, true);}  

				// Mover el archivo a la carpeta
		        $ruta_destino =$carpeta.$archivo;
		        move_uploaded_file($archivo_ruta, $ruta_destino);

				//---VALIDAR EL TIPO Y PESO DEL ARCHIVO --- 
				$bl_tipo_archivo = validar_tipo_archivo(IMPORTAR,$archivo);
				$bl_peso_archivo = validar_peso_archivo(IMPORTAR,(int)$archivo_size);

			if($bl_tipo_archivo) 
			{
				if($bl_peso_archivo)
				{
					//---INICIAMOS LA CONEXION --- 
				   $objPHPExcel = PHPEXCEL_IOFactory::load($ruta_destino); 
				   $objPHPExcel->setActiveSheetIndex(0); //Leer hoja numero 0
				        
				   $num_filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); // obtener fila de la hoja activa

				   $n=0; 					// contar cuantos registros fueron exitosos
				   $no_validos=[]; 			// contar cuantos registros no fueron exitosos
				   $detalle_no_validos='';	// obtener las filas no exitosas


					//--- NOMBRE  - Validamos la columna
					$EsNombre = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('A1')->getCalculatedValue());
					        
					//--- LINK - Validamos la columna
					$EsLink = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('B1')->getCalculatedValue());
					
					//--- MODULO (REF) - Validamos la columna
					$EsModulo = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('C1')->getCalculatedValue());
					        
					//--- ICONO CLASE - Validamos la columna
					$EsIcono = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('D1')->getCalculatedValue());
					
					//--- DESCRIPCION  - Validamos la columna
					$EsDescripcion = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('E1')->getCalculatedValue());
					        
					//--- CONTENEDOR (REF) - Validamos la columna
					$EsContenedor = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('F1')->getCalculatedValue());

				if ($EsNombre=="NOMBRE" && $EsLink=="LINK" && $EsModulo=="MODULO" && $EsIcono=="ICONO" && $EsDescripcion=="DESCRIPCION" && $EsContenedor=="CONTENEDOR") 
				{

					for($i = 2; $i <= $num_filas; $i++)
					{
//--------------------------------------------------------------------------------------------------		           
					        //--- NOMBRE  - Obtenemos el valor y limpiamos cadena
					        $nombre = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
					        //--- LINK  - Obtenemos el valor y limpiamos cadena
					        $link = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
					        //--- MODULO  - Obtenemos el valor y limpiamos cadena
					        $modulo = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
					        //--- ICONO  - Obtenemos el valor y limpiamos cadena
					        $icono = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
					        //--- DESCRIPCION  - Obtenemos el valor y limpiamos cadena
					        $descripcion = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
					        //--- CONTENEDOR  - Obtenemos el valor y limpiamos cadena
					        $contenedor = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());					        

							$bl_nombre = var_valida_texto ($nombre);
							$bl_link = var_valida_texto ($link);
							$bl_modulo = var_valida_texto ($modulo);
							$bl_icono = var_valida_direccion ($icono);
							$bl_Descripcion = var_valida_texto ($descripcion);
							$bl_contenedor = var_valida_texto ($contenedor);

							if($bl_nombre && $bl_link && $bl_modulo && $bl_icono && $bl_Descripcion&& $bl_contenedor )
							{
								// Preparación de la data
								$datos = array(
												"nombre" => $nombre,
									           	"link" => $link,
												"modulo" => $modulo,
									           	"icono" => $icono,
												"descripcion" => $descripcion,
									           	"contenedor" => $contenedor
									           );
								
								// Respuesta de la base de datos
								$respuesta = ModeloMenu::mdlIngresarMenuImportacion($datos);
								if($respuesta == "ok") { $n += 1; } else { array_push($no_validos,$i);}
					    	}

					}

					//---VERIFICAR SI NO HAN HABIDO REGISTROS MALOS --- 
					if (sizeof($no_valido)>0)
					{foreach ($no_validos as $a) { $detalle_no_validos .= "(".strval($a).") "; }}
					
					//---COMPARAR RESULTADOS --- 							
				    if($num_filas-1 ==$n)
				    {
				    	// Borrar archivo excel
						unlink($ruta_destino);
				    	echo Leer_Sweet (self::$tabla,OK, ACCION_GUARDAR, CRUD_CREAR);

				    }else 
						{
				    	// Borrar archivo excel
						unlink($ruta_destino);
						echo Leer_Sweet (self::$tabla, "error_importacion", ACCION_GUARDAR,'',$detalle_no_validos);
						}
//--------------------------------------------------------------------------------------------------


				} else
						{
							// Borrar archivo excel
/*							var_dump($EsModulo);
							var_dump($EsOrden);*/
							unlink($ruta_destino);
							echo Leer_Sweet (self::$tabla, "columnas_invalidas", ACCION_GUARDAR);
						}
//--------------------------------------------------------------------------------------------------

				}else { echo Leer_Sweet (self::$tabla, "peso_invalido", ACCION_GUARDAR); }

			}else  { echo Leer_Sweet (self::$tabla, "tipo_invalido", ACCION_GUARDAR); }


		}
		//---------------------------------------------------
	}









//---------------------FIN DE LA CLASE-----------------------------------

}
