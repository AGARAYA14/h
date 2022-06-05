<?php
require_once "conexion.php";

class ModeloContenedorVista{

	/*=============================================
	MOSTRAR LA CONFIGURACION DE CONTENEDOR VISTA
	=============================================*/
	static public function mdlValidarContenedorVista($tabla, $idusuario){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_ContenedorVista :tabla,:idusuario ");

		$stmt->bindParam(":tabla", $tabla, PDO::PARAM_STR);
		$stmt->bindParam(":idusuario", $idusuario, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetch();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR LAS COLUMNAS DE CONTENEDOR VISTA
	=============================================*/
	static public function mdlObtenerColumnasVista($a){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_ColumnasVista :id ");

		$stmt->bindParam(":id", $a, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR CONSULTA DEL QUERY
	=============================================*/
	static public function mdlObtenerConsultaVista($a){

		//$stmt = Conexion::conectar()->prepare(" exec  dbo.usp_ejecuta :consulta ");
		//$stmt = Conexion::conectar()->prepare("exec dbo.usp_exe :consulta ");
		$stmt = Conexion::conectar()->prepare($a);

		//$stmt->bindParam(":consulta", $a, PDO::PARAM_STR);

		if($stmt->execute())
		{

			//return $stmt -> fetchAll();
			if($stmt->errorCode() === '00000') 
			{
			// Para validar que haya habido más de un registro
				return $stmt -> fetchAll() ; 
			}

		}else{
				//Detalle del error recibido
				$errors = $stmt->errorInfo();

				//Traer el mensaje de error 
				util::Logs("Error Obtener query datatable",funciones::error_sql($errors));
				return ERROR;
		}

/*
		$stmt -> execute();

		// Para validar que se haya ejecutado con exito sin observaciones
		if($stmt->errorCode() == 0) 
		{
			// Para validar que haya habido más de un registro
			return ($stmt->rowCount()>0)? $stmt -> fetchAll() :  ERROR; 

		} else 
				{
				//Detalle del error recibido
				$errors = $stmt->errorInfo();

				//Traer el mensaje de error 
				util::Logs("Error Obtener query datatable",funciones::error_sql($errors));
				return ERROR;
				}
*/

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR PERMISOS BOTONERA
	=============================================*/
	static public function mdlObtenerRolesPerfil($tabla, $idusuario){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_RolesPerfil :tabla,:idusuario ");

		$stmt->bindParam(":tabla", $tabla, PDO::PARAM_STR);
		$stmt->bindParam(":idusuario", $idusuario, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR PERMISOS PRINCIPALES
	=============================================*/
	static public function mdlObtenerRolesGeneralesPerfil($idusuario){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_Roles :idusuario ");

		$stmt->bindParam(":idusuario", $idusuario, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	OBTENER CAMPOS DE TABLA
	=============================================*/
	static public function mdlObtenerCamposTabla($tabla){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_CamposTabla :tabla ");

		$stmt->bindParam(":tabla", $tabla, PDO::PARAM_STR);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	MOSTRAR PERMISO CREAR
	=============================================*/
	static public function mdlObtenerRolCrearPerfil($tabla, $idperfil){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_RolCrearPerfil :tabla,:idperfil ");

		$stmt->bindParam(":tabla", $tabla, PDO::PARAM_STR);
		$stmt->bindParam(":idperfil", $idperfil, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	REGISTRAR CONTENEDOR VISTA
	=============================================*/

	static public function mdlIngresarContenedorVista($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarContenedorVista :contenedor,:configvista,:query ");

		$stmt->bindParam(":contenedor", $datos["Contenedor"], PDO::PARAM_STR);
		$stmt->bindParam(":configvista", $datos["ConfVista"], PDO::PARAM_STR);
		$stmt->bindParam(":query", $datos["Query"], PDO::PARAM_STR);
		$stmt -> execute();

		if($stmt->errorCode() == 0) 
		{
			if($stmt->rowCount()>0)
			{
				return "ok";
			}
			else {return "Operación sin resultado";}

		} else 
				{
				$errors = $stmt->errorInfo();
				$n=strlen($errors[2]);
				$c=54;
				return substr($errors[2], $c,$n-$c);
				}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	MOSTRAR CONTENEDOR VISTA
	=============================================*/


	static public function mdlMostrarContenedorVista($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT a.pkid, a.tabla AS Contenedor, b.nombre AS Configuracion, b.consulta AS query, b.nombre as seleccion FROM $tabla a INNER JOIN ConfiguracionVista b ON a.IDConfigvista = b.pkid WHERE a.$item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT a.pkid, a.tabla AS Contenedor, b.nombre AS Configuracion, b.consulta AS query, b.nombre as seleccion FROM $tabla a INNER JOIN ConfiguracionVista b ON a.IDConfigvista = b.pkid ");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}
	/*=============================================
	RECUPERAR COLUMNAS DEL CONTENEDOR VISTA
	=============================================*/


	static public function mdlRecuperarColumnasContenedorVista($tabla, $valor){

		if($valor != null)
		{

			$stmt = Conexion::conectar()->prepare("exec dbo.p_MostrarColumnasContenedor :item");
			$stmt -> bindParam(":item", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}


	/*=============================================
	BORRAR COLUMNAS DE LA CONFIGURACION DE VISTA
	=============================================*/

	static public function mdlEliminarColumnasVista($id){

		$stmt = Conexion::conectar()->prepare("DELETE ColumnasConfigVista where IDCV=:id");
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

	static public function mdlAsignarColumnasConfiguracionVista($a){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarColumnaContenedorVista :idcv, :texto, :ancho, :orden, :opcion, :nombresql, :visible ");
		$stmt->bindParam(":idcv", $a["IDCV"], PDO::PARAM_INT);
		$stmt->bindParam(":texto", $a["texto"], PDO::PARAM_STR);
		$stmt->bindParam(":ancho", $a["ancho"], PDO::PARAM_INT);
		$stmt->bindParam(":orden", $a["orden"], PDO::PARAM_INT);
		$stmt->bindParam(":opcion", $a["opcion"], PDO::PARAM_STR);
		$stmt->bindParam(":nombresql", $a["nombresql"], PDO::PARAM_STR);
		$stmt->bindParam(":visible", $a["visible"], PDO::PARAM_INT);

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


