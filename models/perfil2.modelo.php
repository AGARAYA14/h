<?php
require_once "conexion.php";

class ModeloPerfil{

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
	/*=============================================
	ACTUALIZAR PERFIL
	=============================================*/

	static public function mdlActualizarPerfil($id){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_ActualizarEstadoPerfil :id");

		$stmt -> bindParam(":id", $id, PDO::PARAM_INT);

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

	/*=============================================
	MOSTRAR PERMISOS ASIGNADOS DE PERFILES
	=============================================*/
	static public function mdlMostrarPermisosPerfil($valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT Rol.rol,Rol.pkid as idrol FROM Perfil_Rol INNER JOIN Rol ON Perfil_Rol.idrol = Rol.pkid WHERE (Perfil_Rol.idperfil = :idperfil) order by 1");
			$stmt -> bindParam(":idperfil", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM Rol");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}
	/*=============================================
	MOSTRAR PERMISOS PENDIENTES DE PERFILES
	=============================================*/
	static public function mdlMostrarPermisosPendientesPerfil($valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT rol, pkid AS idrol FROM Rol WHERE (pkid NOT IN (SELECT idrol FROM Perfil_Rol WHERE (idperfil = :idperfil ))) order by 1 ");
			$stmt -> bindParam(":idperfil", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM Rol");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR MENUS ASIGNADOS DE PERFILES
	=============================================*/
	static public function mdlMostrarMenuPerfil($valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT Menu.nombre as menu, Menu.pkid as idmenu FROM Perfil_Menu INNER JOIN Menu ON Perfil_Menu.idmenu = Menu.pkid WHERE (Perfil_Menu.idperfil = :idperfil)");
			$stmt -> bindParam(":idperfil", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM Menu");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}
	/*=============================================
	MOSTRAR MENUS PENDIENTES DE PERFILES
	=============================================*/
	static public function mdlMostrarMenuPendientesPerfil($valor){

		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT Menu.nombre as menu, Menu.pkid as idmenu FROM Menu  WHERE (pkid NOT IN (SELECT idmenu FROM Perfil_Menu WHERE (idperfil = :idperfil ))) order by 1 ");
			$stmt -> bindParam(":idperfil", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM Menu");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PERMISOS DEL PERFIL
	=============================================*/

	static public function mdlEliminarPermisosPerfil($id){

		$stmt = Conexion::conectar()->prepare("DELETE Perfil_Rol where idperfil=:id");
		$stmt -> bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt -> execute())
		{
			return "ok";	

		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	ASIGNAR PERMISOS DEL PERFIL
	=============================================*/

	static public function mdlAsignarPermisosPerfil($id,$a){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarPerfilRol :idperfil, :idrol ");
		$stmt -> bindParam(":idperfil", $id, PDO::PARAM_INT);
		$stmt -> bindParam(":idrol", $a, PDO::PARAM_INT);

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

	/*=============================================
	BORRAR MENU DEL PERFIL
	=============================================*/

	static public function mdlEliminarMenuPerfil($id){

		$stmt = Conexion::conectar()->prepare("DELETE Perfil_Menu where idperfil=:id");
		$stmt -> bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt -> execute())
		{
			return "ok";	

		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	ASIGNAR MENU DEL PERFIL
	=============================================*/

	static public function mdlAsignarMenuPerfil($id,$a){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarPerfilMenu :idperfil, :idmenu ");
		$stmt -> bindParam(":idperfil", $id, PDO::PARAM_INT);
		$stmt -> bindParam(":idmenu", $a, PDO::PARAM_INT);

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

// ---------------------------------------------------------------

}