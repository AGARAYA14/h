<?php
require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	Consultar vista para retornar el usuario
	=============================================*/
	static public function MdlIngresoUsuario($usuario, $contrasena){

		$stmt = Conexion::conectar()->prepare(" exec dbo.Obtener_Usuario :usuario,:contrasena ");

		$stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);

		if($stmt->execute()){
			return $stmt -> fetch();
		}else{
			return ERROR;
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null){
//---------------------------------------------------------------	
/*
			$sql="call ObjUsuario_By_cIdenNumero_cUsuUsuario_cUsuClave(?,?,?)";

			$sentencia = $connection->prepare("CALL sp_returns_string(:userid)");
			$sentencia->bindParam(":userid", $valor_devuleto, PDO::PARAM_STR, 4000); 

			// llamar al procedimiento almacenado
			$sentencia->execute();

			print "El procedimiento devolvió $valor_devuleto\n";
*/
//---------------------------------------------------------------			
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
	Recuperar los menus de nivel 1
	=============================================*/

	static public function MdlMostrarModulo_Usuarios($valor){

		$stmt = Conexion::conectar()->prepare("exec dbo.Obtener_Menu_n1 :idperfil ");
		$stmt->bindParam(":idperfil", $valor, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
		
	}
	/*=============================================
	RECUPERAR MODULOS DE USUARIO
	=============================================*/
/*
	static public function MdlMostrarModulo_Usuarios($valor){

		$stmt = Conexion::conectar()->prepare("exec dbo.Obtener_Modulo :idperfil ");
		$stmt->bindParam(":idperfil", $valor, PDO::PARAM_INT);

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
		
	}
	*/
	/*=============================================
	RECUPERAR MENU DE USUARIO
	=============================================*/
/*
	static public function MdlMostrarMenu_Usuarios($valor){

		$stmt = Conexion::conectar()->prepare("exec dbo.Obtener_MenuUsuario :idusuario ");
		$stmt->bindParam(":idusuario", $valor, PDO::PARAM_INT);
		/*$stmt->execute();
		return $stmt -> fetchAll();

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
		

	}
*/
	/*=============================================
	RECUPERAR MENU DE USUARIO
	=============================================*/

	static public function MdlMostrarMenu_Usuarios($v1,$v2){

		$stmt = Conexion::conectar()->prepare("exec dbo.Obtener_Menu_n :idperfil,:idmenu");
		$stmt->bindParam(":idperfil", $v1, PDO::PARAM_INT);
		$stmt->bindParam(":idmenu", $v2, PDO::PARAM_INT);
		/*$stmt->execute();
		return $stmt -> fetchAll();*/

		if($stmt->execute()){
			return $stmt -> fetchAll();
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
		

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		//$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, foto) VALUES (:nombre, :usuario, :password, :perfil, :foto)");
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, foto, estado) VALUES (:nombre, :usuario, :password, :perfil, :foto, 0)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);



		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;
		

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($idusuario, $fecha){

		$stmt = Conexion::conectar()->prepare("UPDATE Usuario SET fecha_ultimologin = :fecha WHERE pkid = :idusuario");

		$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt -> bindParam(":idusuario", $idusuario, PDO::PARAM_INT);
		$stmt -> execute();
		//return ($stmt->execute())? OK :  ERROR; 

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
				//$n=strlen($errors[2]);
				util::Logs("mdlActualizarUsuario",funciones::error_sql($errors));
				//return substr($errors[2],MSJ_SQL,$n-MSJ_SQL);
				return funciones::error_sql($errors);
				}

		$stmt->close();		
		$stmt = null;
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}