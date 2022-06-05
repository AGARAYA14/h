<?php
require_once "conexion.php";

class ModeloFiltro{

	/*=============================================
	CREAR FILTRO
	=============================================*/

	static public function mdlIngresarFiltro($vista, $usuario, $filtro , $datos){
		//Contador de registros
		$n = 0;
		$pdo = Conexion::conectar();

		try {

		    $pdo->beginTransaction();

		    // Eliminar el detalle de los filtros
			$stmt = $pdo->prepare("delete FiltroCondicion where IDFiltro=:id");
			$stmt -> bindParam(":id", $filtro, PDO::PARAM_INT);

			// Validar que se ejecuto correctamente.
			if($stmt -> execute())
			{
				// Validar que no este varios los filtros
				if (!empty($datos)) {

					// Recorrer cada filtro
					foreach ($datos as $key => $a) {
						$stmt = $pdo->prepare(" exec dbo.p_InsertarFiltroCondicion :idcv,:idusuario, :campo, :condicion, :valor, :enlace, :flag ");
						$stmt->bindParam(":idcv", $vista, PDO::PARAM_INT);
						$stmt->bindParam(":idusuario", $usuario, PDO::PARAM_INT);
						$stmt->bindParam(":campo", $a["campo"], PDO::PARAM_STR);
						$stmt->bindParam(":condicion", $a["condicion"], PDO::PARAM_STR);
						$stmt->bindParam(":valor", $a["valor"], PDO::PARAM_STR);
						$stmt->bindParam(":enlace", $a["enlace"], PDO::PARAM_STR);
						$stmt->bindParam(":flag", $a["opcion"], PDO::PARAM_INT);

						// Contador de registro
						if($stmt -> execute()) { $n += 1; }
					}

				}

			}else{
				util::Logs("Filtro - Registrar: ",$e->getMessage());
				return ERROR;	
			}

		    $pdo->commit();

		    if (count($datos)==$n) {
		    	return OK;
		    } else {
		    	return OK2;
		    }
			
		    $stmt -> close();
			$stmt = null;
		} 

		catch (Exception $e) {
			util::Logs("Filtro - Registrar: ",$e->getMessage());
		    if ($pdo->inTransaction()) {
		        $pdo->rollback();
		        // If we got here our two data updates are not in the database
		    }
		    return ERROR;
		    //throw $e;
		}




		// $stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarFiltro :Filtro,:orden ");
		// $stmt->bindParam(":Filtro", $datos["Filtro"], PDO::PARAM_STR);
		// $stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);

		// return ($stmt->execute())? OK :  ERROR; 

		// $stmt->close();		
		// $stmt = null;
	}

	/*=============================================
	MODIFICAR FILTRO
	=============================================*/

	static public function mdlModificarFiltro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Filtro = :Filtro, orden = :orden WHERE pkid = :id");

		$stmt->bindParam(":Filtro", $datos["Filtro"], PDO::PARAM_STR);
		$stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		return ($stmt->execute())? OK :  ERROR; 

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	BORRAR FILTRO
	=============================================*/

	static public function mdlBorrarFiltro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("exec dbo.p_EliminarFiltro :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		$stmt -> execute();

		// Para validar que se haya ejecutado con exito sin observaciones
		if($stmt->errorCode() == 0) 
		{
			// Para validar que haya habido más de un registro
			return ($stmt->rowCount()>0)? OK :  ERROR; 

		} else 
				{
				//Detalle del error recibido
				$errors = $stmt->errorInfo();

				//Traer el mensaje de error 
				return funciones::error_sql($errors);
				}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	MOSTRAR FILTRO
	=============================================*/
	// static public function mdlMostrarFiltro($tabla, $item, $valor){

	// 	if($item != null){

	// 		$stmt = Conexion::conectar()->prepare("SELECT pkid,Filtro,orden, Filtro as seleccion FROM $tabla WHERE $item = :$item");
	// 		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
	// 		$stmt -> execute();

	// 		return $stmt -> fetch();

	// 	}else{

	// 		$stmt = Conexion::conectar()->prepare("SELECT pkid,Filtro,orden, Filtro as seleccion FROM $tabla");
	// 		$stmt -> execute();
	// 		return $stmt -> fetchAll();

	// 	}

	// 	$stmt -> close();
	// 	$stmt = null;
	

	// }


	/*=============================================
	EXPORTAR FILTRO: Devolver columnas
	=============================================*/
	static public function mdlRecuperaColumnas($valor){

		$stmt = Conexion::conectar()->prepare("SELECT ccv.texto, ccv.nombresql, ccv.opcion FROM ConfiguracionVista as cv INNER JOIN ColumnasConfigVista as ccv ON cv.pkid = ccv.IDCV WHERE (cv.pkid = :id) AND (ccv.visible=1) AND (cv.filtro=1)  ORDER BY ccv.orden");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;

	}

	/*=============================================
	FILTRO FILTRO: Devolver los filtros del usuario
	=============================================*/
	static public function mdlMostrarFiltro($idvista, $idusuario){

		$stmt = Conexion::conectar()->prepare("SELECT fc.Campo, fc.Condicion, fc.Valor, fc.Operador, fc.IDFiltro FROM dbo.Filtro AS f 
				INNER JOIN dbo.FiltroCondicion AS fc ON f.PKID = fc.IDFiltro WHERE  (f.IDCV = :vista) AND (f.IDUsuario = :usuario)");
		$stmt -> bindParam(":vista", $idvista, PDO::PARAM_INT);
		$stmt -> bindParam(":usuario", $idusuario, PDO::PARAM_INT);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;

	}



}