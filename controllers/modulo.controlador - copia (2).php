<?php
require_once "./extensiones/Excel_PHP/PHPExcel/IOFactory.php";
require_once "./extensiones/Excel_PHP/PHPExcel.php";
/*require_once "PHPExcel/IOFactory.php";
require_once "PHPExcel.php";*/
libxml_use_internal_errors(true);

class ControladorModulo{

public static $tabla = 'Modulo';


	/*=============================================
	MOSTRAR MODULO
	=============================================*/

	static public function ctrMostrarModulo($item, $valor){

		$respuesta = ModeloModulo::mdlMostrarModulo(self::$tabla, $item, $valor);
		return $respuesta;
	
	}

	/*=============================================
	CREAR MODULO
	=============================================*/

	static public function ctrCrearModulo(){

		if(isset($_POST["nuevoModulo"]))
		{

			$NewModulo=limpiar_cadena($_POST["nuevoModulo"]);
			$NewOrden=limpiar_cadena($_POST["nuevoOrden"]);

			$bl_modulo = var_valida_texto ($NewModulo);
			$bl_orden = var_valida_numero ($NewOrden);

			if($bl_modulo && $bl_orden)
			{

				// Preparación de la data
				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlIngresarModulo($datos);

				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_CREAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_CREAR);

			}

		}

	}


	/*=============================================
	EDITAR MODULO
	=============================================*/

	static public function ctrEditarModulo(){


		if(isset($_POST["editarModulo"])){

			$NewModulo=limpiar_cadena($_POST["editarModulo"]);
			$NewOrden=limpiar_cadena($_POST["editarOrden"]);
			$id=$_POST["idModulo"];
                       
			$bl_modulo = var_valida_texto ($NewModulo);
			$bl_orden = var_valida_numero ($NewOrden);

			if($bl_modulo && $bl_orden)
			{


				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden,
					           	"id" => $id
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlEditarModulo(self::$tabla,$datos);

				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_EDITAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_EDITAR);

			}
			}
		
	}

	/*=============================================
	BORRAR MODULO
	=============================================*/

	static public function ctrBorrarModulo(){

		if(isset($_GET["idModulo"])){

			$idModulo = (int) var_desencripta ($_GET["idModulo"]);
			$bl_id = var_valida_numero ($idModulo);

			if($bl_id)
			{

				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlBorrarModulo(self::$tabla, $idModulo);

				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_ELIMINAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_ELIMINAR);

			}
			

		}
	}


	/*=============================================
	CREAR MODULO
	=============================================*/

	static public function ctrImportarModulo(){

		if(isset($_FILES["archivo"]))
		{
			    //--- SECCION 2 --- 
			    $archivo = utf8_decode($_FILES["archivo"]["name"]); // para permitir las tildes
			    //$archivo2 = $_FILES["archivo_2"]["name"];
			    $archivo_ruta = $_FILES["archivo"]["tmp_name"];
			    $archivo_tipo = $_FILES["archivo"]["type"];
			    $archivo_size = $_FILES["archivo"]["size"];
			    //$archivo_error = $_FILES["archivo"]["error"];
			     // $aa = strtolower(preg_replace('/^.*\./','',$archivo));
			    $archivo_guardado = "COPIA_".$archivo;
/*
    if(copy($archivo_ruta, $archivo_guardado)){
        // echo "ARCHIVO COPIADO";
    }else{
        echo "NO COPIADO";
    }
*/

    	$carpeta = './archivos/excel/importacion/'.self::$tabla.'/';
    	// Crear la carpeta si no existe
		if (!file_exists($carpeta)) {	mkdir($carpeta, 0777, true);}  
		// Mover el archivo a la carpeta
        $ruta_destino =$carpeta.$archivo;
        move_uploaded_file($archivo_ruta, $ruta_destino);



				//var_dump($archivo);
				
				//var_dump($archivo2);
				/*
				var_dump($archivo_ruta);
				var_dump($archivo_tipo);
				var_dump($archivo_size);
				var_dump($archivo_error);
				var_dump(get_mimetype ($archivo));
				*/
			$bl_tipo_archivo = validar_tipo_archivo(IMPORTAR,$archivo);
			$bl_peso_archivo = validar_peso_archivo(IMPORTAR,(int)$archivo_size);

			if($bl_tipo_archivo) 
			{
				if($bl_peso_archivo)
				{
						//echo "todo valido";
					//var_dump(dirname(__FILE__));
				    //--- SECCION 3 ---
				   $objPHPExcel = PHPEXCEL_IOFactory::load($ruta_destino);
				    //var_dump($objPHPExcel);  
				   $objPHPExcel->setActiveSheetIndex(0); //Leer hoja numero 0
				        
				   $num_filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); // obtener fila de la hoja activa
				    //$num_columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn(); // obtener ultima columnas
				    //$rango = $objPHPExcel->setActiveSheetIndex(0)->calculateWorksheetDimension(); // rango de celdas

				    //echo "<center><table border=1><tr> <th>NOMBRE</th> <th>IDENTIFICACION</th> </tr>";
				   	//var_dump($num_x);
				   	//
				   $n=0;
				   $no_validos=[];
				   $detalle_no_validos='';

					for($i = 2; $i <= $num_filas; $i++)
					{
					           
					        //--- MODULO  - Obtenemos el valor y limpiamos cadena
					        $modulo = limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
					        
					        //--- ORDEN - Obtenemos el valor y limpiamos cadena
					        $orden = (int)limpiar_cadena($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());

							$bl_modulo = var_valida_texto ($modulo);
							$bl_orden = var_valida_numero ($orden);

							if($bl_modulo && $bl_orden)
							{

								// Preparación de la data
								$datos = array(
												"modulo" => $modulo,
									           	"orden" => $orden
									           );

								// Respuesta de la base de datos
								$respuesta = ModeloModulo::mdlIngresarModulo($datos);
								if($respuesta == "ok") { $n += 1; } else { array_push($no_validos,$i);}
					    	}
					}
					//var_dump($n);
					//var_dump($no_validos);

				
					if (sizeof($no_valido)>0)
					{foreach ($no_validos as $a) { $detalle_no_validos .= "(".strval($a).") "; }}
					
														
				    if($num_filas-1 ==$n)
				    {
				    	echo Leer_Sweet (self::$tabla,OK, ACCION_GUARDAR, CRUD_CREAR);
				    }else 
						{
							$alerta["Accion"]=$accion;
							$alerta["Tipo"]="error";
							$alerta["Titulo"]="Ocurrió un error en la importación, estas filas tuvieron problemas $detalle_no_validos ";
							$alerta["Entidad"]=strtolower(self::$tabla);
							echo sweet_alert ($alerta);
						}



				}else { echo Leer_Sweet (self::$tabla, "peso_invalido", ACCION_GUARDAR); }

			}else  { echo Leer_Sweet (self::$tabla, "tipo_invalido", ACCION_GUARDAR); }





/*

			$NewModulo=limpiar_cadena($_POST["nuevoModulo"]);
			$NewOrden=limpiar_cadena($_POST["nuevoOrden"]);

			$bl_modulo = var_valida_texto ($NewModulo);
			$bl_orden = var_valida_numero ($NewOrden);

			if($bl_modulo && $bl_orden)
			{

				// Preparación de la data
				$datos = array(
								"modulo" => $NewModulo,
					           	"orden" => $NewOrden
					           );

				// Respuesta de la base de datos
				$respuesta = ModeloModulo::mdlIngresarModulo($datos);

				// Impresión del mensaje
				echo Leer_Sweet (self::$tabla, $respuesta, ACCION_GUARDAR, CRUD_CREAR);

			}else{

				echo Leer_Sweet (self::$tabla, "invalido", ACCION_GUARDAR, CRUD_CREAR);

			}
*/
		}
		//else { echo Leer_Sweet (self::$tabla, "error_desconocido", ACCION_GUARDAR);}

	}

//---------------------FIN DE LA CLASE-----------------------------------

}
