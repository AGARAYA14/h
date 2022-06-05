<?php

class Conexion{

/*=============================================
CONECTAR
=============================================*/

static public function conectar(){

            try
            {
                $conexion = new PDO("sqlsrv:Server=" .SQL_HOST. ";Database=" .SQL_NAME.";ConnectionPooling=0", SQL_USER,SQL_PASS);

                return $conexion;

            } catch (PDOException $exception) {
            	//util::Logs("Error Acceso",$exception->getMessage());
               die(sprintf('No  hay conexión a la base de datos, hubo un error: %s', $exception->getMessage()));
            }

	}
/*=============================================
CONECTAR
=============================================*/



}