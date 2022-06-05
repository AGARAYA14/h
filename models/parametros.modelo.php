<?php

require_once "conexion.php";

Class ModeloParametros{

	/*=============================================
	Devolver la lista de parametros para el sistema
	=============================================*/
	
	static public function mdlParametros(){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM Parametros");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

	}
	/*=============================================
	Devolver la lista de paginas configuradas
	=============================================*/
	
	static public function mdlPaginas(){

		$stmt = Conexion::conectar()->prepare("SELECT pkid, link FROM Menu where activo=1");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

	}


	/*=============================================
	Ingresar la auditoria
	=============================================*/
	static public function mdlIngresarAuditoria($datos){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarAuditoria :idusuario,:tipo,:operacion,:id_entidad,:pc,:navegador,:fecha,:contenido ");
		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":operacion", $datos["operacion"], PDO::PARAM_STR);
		$stmt->bindParam(":id_entidad", $datos["id_entidad"], PDO::PARAM_INT);
		$stmt->bindParam(":pc", $datos["pc"], PDO::PARAM_STR);
		$stmt->bindParam(":navegador", $datos["navegador"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":contenido", $datos["contenido"], PDO::PARAM_STR);				
		return ($stmt->execute())? OK :  ERROR; 

		$stmt->close();		
		$stmt = null;
	}


}