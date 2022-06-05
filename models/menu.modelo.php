<?php
require_once "conexion.php";

class ModeloMenu{

	/*=============================================
	REGISTRAR MENU
	=============================================*/

	static public function mdlIngresarMenu($datos){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarMenu :idmodulo,:menu,:link,:icono,:descripcion,:idcontenedor ");

		$stmt->bindParam(":idmodulo", $datos["IDModulo"], PDO::PARAM_INT);
		$stmt->bindParam(":menu", $datos["Menu"], PDO::PARAM_STR);
		$stmt->bindParam(":link", $datos["Link"], PDO::PARAM_STR);
		$stmt->bindParam(":icono", $datos["Icono"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["Descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":idcontenedor", $datos["IDContenedor"], PDO::PARAM_INT);

		if($stmt->execute()){

			return OK;	
		}else{
			return ERROR;	
		}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	REGISTRAR MENU IMPORTACION
	=============================================*/

	static public function mdlIngresarMenuImportacion($datos){

		$stmt = Conexion::conectar()->prepare(" exec dbo.p_InsertarMenuImportar :modulo,:menu,:link,:icono,:descripcion,:contenedor ");

		$stmt->bindParam(":modulo", $datos["modulo"], PDO::PARAM_STR);
		$stmt->bindParam(":menu", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":link", $datos["link"], PDO::PARAM_STR);
		$stmt->bindParam(":icono", $datos["icono"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":contenedor", $datos["contenedor"], PDO::PARAM_STR);

		if($stmt->execute()){
			return OK;	
		}else{
			return ERROR;	
		}

		$stmt->close();		
		$stmt = null;
	}


	/*=============================================
	MOSTRAR MENUS
	=============================================*/
	static public function mdlMostrarMenu($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT pkid,nombre,link,isnull(idmodulo,0)as idmodulo,icono_clase,descripcion,isnull(idcontenedor,0) as idcontenedor, nombre as seleccion  FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT pkid,nombre,link,isnull(idmodulo,0)as idmodulo,icono_clase,descripcion,isnull(idcontenedor,0) as idcontenedor, nombre as seleccion FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}

	/*=============================================
	EDITAR MENU
	=============================================*/

	static public function mdlModificarMenu($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :menu, link = :link, idmodulo = :idmodulo , icono_clase = :icono , descripcion = :descripcion, idcontenedor = :idcontenedor WHERE pkid = :id");

		$stmt->bindParam(":idmodulo", $datos["IDModulo"], PDO::PARAM_INT);
		$stmt->bindParam(":menu", $datos["Menu"], PDO::PARAM_STR);
		$stmt->bindParam(":link", $datos["Link"], PDO::PARAM_STR);
		$stmt->bindParam(":icono", $datos["Icono"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["Descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":idcontenedor", $datos["IDContenedor"], PDO::PARAM_INT);

		if($stmt->execute()){

			return OK;

		}else{

			return ERROR;
		
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	BORRAR MENU
	=============================================*/

	static public function mdlBorrarMenu($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("exec dbo.p_EliminarMenu :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		$stmt -> execute();

		if($stmt->errorCode() == 0) 
		{
			// Para validar que haya habido más de un registro
			if($stmt->rowCount()>0)
			{
				return OK;
			}
			else {return ERROR;}

		} else 
				{
				$errors = $stmt->errorInfo();
				$n=strlen($errors[2]);
				return substr($errors[2],MSJ_SQL,$n-MSJ_SQL);
				}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	EXPORTAR MENU: Devolver columnas
	=============================================*/
	static public function mdlRecuperaColumnasMenu($valor){

			$stmt = Conexion::conectar()->prepare("SELECT	ColumnasConfigVista.texto, ColumnasConfigVista.nombresql FROM	ConfiguracionVista WITH (nolock) INNER JOIN	ColumnasConfigVista WITH (nolock) ON ConfiguracionVista.pkid = ColumnasConfigVista.IDCV WHERE (ConfiguracionVista.pkid = :id) AND (ColumnasConfigVista.visible=1) ORDER BY ColumnasConfigVista.orden");
			$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;

	}



}