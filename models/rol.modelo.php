<?php
require_once "conexion.php";

class ModeloRol{


	/*=============================================
	BUSCAR TIPO 
	=============================================*/

	static public function mdlBuscarTipo($datos){

		$stmt = Conexion::conectar()->prepare(" select rol from dbo.rol where pkid<>1 and descripcion like CONCAT('%', :tipo, '%') ");
		//$stmt = Conexion::conectar()->prepare(" select * from dbo.IDTabla where id<>1 and tabla like CONCAT('%', :tipo, '%') ");

		$stmt->bindParam(":tipo", $datos, PDO::PARAM_STR);


		if($stmt -> execute())
		{
			return $stmt -> fetchAll();
		
		}else{

			return "error";	

		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	REGISTRAR PERFIL
	=============================================*/

	static public function mdlIngresarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarPerfil :codigo,:perfil,:estado ");

		$stmt->bindParam(":codigo", $datos["Codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["Perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["Estado"], PDO::PARAM_INT);

		if($stmt -> execute())
		{
			if($stmt->rowCount()>0)
			{
				return "ok";
			}
			else {return "error";}
		
		}else{

			return "error";	

		}

		$stmt->close();		
		$stmt = null;
	}


	/*=============================================
	MOSTRAR PERFILES
	=============================================*/
	static public function mdlMostrarPerfil($tabla, $item, $valor){

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
	EDITAR PERFIL
	=============================================*/

	static public function mdlModificarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, perfil = :perfil, activo = :estado  WHERE pkid = :id");

		$stmt->bindParam(":codigo", $datos["Codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["Perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["Estado"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			if($stmt->rowCount()>0)
			{
				return "ok";
			}
			else {return "error";}

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PERFIL
	=============================================*/

	static public function mdlBorrarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE pkid = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute())
		{
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