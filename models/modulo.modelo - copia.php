<?php
require_once "conexion.php";

class ModeloModulo{

	/*=============================================
	REGISTRAR MODULOS
	=============================================*/

	static public function mdlIngresarModulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarModulo :modulo,:orden ");
		$stmt->bindParam(":modulo", $datos["modulo"], PDO::PARAM_STR);
		$stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";	
		}else{
			return "error";	
		}

		$stmt->close();		
		$stmt = null;
	}


	/*=============================================
	MOSTRAR MODULOS
	=============================================*/
	static public function mdlMostrarModulo($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}

	/*=============================================
	EDITAR MODULO
	=============================================*/

	static public function mdlEditarModulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET modulo = :modulo, orden = :orden WHERE pkid = :id");

		$stmt->bindParam(":modulo", $datos["modulo"], PDO::PARAM_STR);
		$stmt->bindParam(":orden", $datos["orden"], PDO::PARAM_INT);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR MODULO
	=============================================*/

	static public function mdlBorrarModulo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE pkid = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			if($stmt->rowCount()>0)
			{
				return "ok";
			}
			else {return "error";}
		
		}else{

			return "error";	

		}
		$stmt -> close();
		$stmt = null;
	}



}