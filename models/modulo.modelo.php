<?php
require_once "conexion.php";

class ModeloModulo{

	/*=============================================
	CREAR MODULO
	=============================================*/

	static public function mdlIngresarModulo($datos){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarModulo :modulo,:orden ");
		$stmt->bindParam(":modulo", $datos["modulo"], PDO::PARAM_STR);
		$stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);

		return ($stmt->execute())? OK :  ERROR;

		//$stmt->close();
		$stmt = null;
	}

	/*=============================================
	MODIFICAR MODULO
	=============================================*/

	static public function mdlModificarModulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET modulo = :modulo, orden = :orden WHERE pkid = :id");

		$stmt->bindParam(":modulo", $datos["modulo"], PDO::PARAM_STR);
		$stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		return ($stmt->execute())? OK :  ERROR;

		//$stmt->close();
		$stmt = null;
	}

	/*=============================================
	BORRAR MODULO
	=============================================*/

	static public function mdlBorrarModulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("exec dbo.p_EliminarModulo :id");
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

		//$stmt->close();
		$stmt = null;
	}

	/*=============================================
	MOSTRAR MODULOS
	=============================================*/
	static public function mdlMostrarModulo($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT pkid,modulo,orden, modulo as seleccion FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT pkid,modulo,orden, modulo as seleccion FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		//$stmt -> close();
		$stmt = null;
	

	}


	/*=============================================
	EXPORTAR MODULOS: Devolver columnas
	=============================================*/
	static public function mdlRecuperaColumnasModulo($valor){

		$stmt = Conexion::conectar()->prepare("SELECT ccv.texto, ccv.nombresql, ccv.opcion FROM ConfiguracionVista as cv INNER JOIN ColumnasConfigVista as ccv ON cv.pkid = ccv.IDCV WHERE (cv.pkid = :id) AND (ccv.visible=1) AND (cv.filtro=1)  ORDER BY ccv.orden");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
		$stmt -> execute();

		return $stmt -> fetchAll();

		//$stmt -> close();
		$stmt = null;

	}

	/*=============================================
	FILTRO MODULO: Devolver los filtros del usuario
	=============================================*/
	static public function mdlMostrarFiltroModulo($idvista, $idusuario){

		$stmt = Conexion::conectar()->prepare("SELECT fc.Campo, fc.Condicion, fc.Valor, fc.Operador, fc.IDFiltro FROM dbo.Filtro AS f 
				INNER JOIN dbo.FiltroCondicion AS fc ON f.PKID = fc.IDFiltro WHERE  (f.IDCV = :vista) AND (f.IDUsuario = :usuario)");
		$stmt -> bindParam(":vista", $idvista, PDO::PARAM_INT);
		$stmt -> bindParam(":usuario", $idusuario, PDO::PARAM_INT);
		$stmt -> execute();

		return $stmt -> fetchAll();

		//$stmt -> close();
		$stmt = null;

	}


}