<?php
require_once "core/globales.php";
require_once CONTROLADORES."plantilla.controlador.php";
/* require_once CORE."util.php";
require_once CORE."helpers.php";
require_once CORE."funciones.php";
require_once CORE."registros.php";
require_once CORE."formulario.php";
require_once CORE."notificaciones.php";

require_once CONTROLADORES."plantilla.controlador.php";
require_once CONTROLADORES."sesion.controlador.php";
require_once CONTROLADORES."contenedor_vista.controlador.php";

require_once CONTROLADORES."parametros.controlador.php";
require_once CONTROLADORES."menu.controlador.php";
require_once CONTROLADORES."usuarios.controlador.php";
require_once CONTROLADORES."modulo.controlador.php";

require_once MODELOS."contenedor_vista.modelo.php";
require_once MODELOS."parametros.modelo.php";
require_once MODELOS."menu.modelo.php";
require_once MODELOS."usuarios.modelo.php";
require_once MODELOS."modulo.modelo.php"; */

require_once "models/conexion.php";
/*
$stmt = Conexion::conectar()->prepare("SELECT * FROM  estado");
//$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
$stmt -> execute();

var_dump($stmt -> fetchAll(PDO::FETCH_CLASS)) ;
*/


/* require_once INCLUDES."Excel_PHP/PHPExcel/IOFactory.php";
require_once INCLUDES."Excel_PHP/PHPExcel.php"; */


  $plantilla = new ControladorPlantilla();
 $plantilla -> ctrPlantilla(); 


