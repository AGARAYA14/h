<?php
require_once "core/globales.php";

require_once CORE."util.php";
require_once CORE."helpers.php";
require_once CORE."funciones.php";
require_once CORE."registros.php";
require_once CORE."formulario.php";
require_once CORE."notificaciones.php";

require_once CONTROLADORES."plantilla.controlador.php";
require_once CONTROLADORES."sesion.controlador.php";
require_once CONTROLADORES."contenedor_vista.controlador.php";
require_once CONTROLADORES."perfil.controlador.php";

require_once CONTROLADORES."parametros.controlador.php";
require_once CONTROLADORES."menu.controlador.php";
require_once CONTROLADORES."usuarios.controlador.php";
require_once CONTROLADORES."modulo.controlador.php";

require_once MODELOS."contenedor_vista.modelo.php";
require_once MODELOS."parametros.modelo.php";
require_once MODELOS."menu.modelo.php";
require_once MODELOS."usuarios.modelo.php";
require_once MODELOS."modulo.modelo.php";
require_once MODELOS."perfil.modelo.php";
/*
require_once INCLUDES."Excel_PHP/PHPExcel/IOFactory.php";
require_once INCLUDES."Excel_PHP/PHPExcel.php";

require_once "system/config.php";





//require_once "controladores/categorias.controlador.php";
//require_once "controladores/productos.controlador.php";
//require_once "controladores/clientes.controlador.php";
//require_once "controladores/ventas.controlador.php";



require_once CONTROLLERS."menu.controlador.php";

require_once CONTROLLERS."rol.controlador.php";

require_once CORE."globales.php";
require_once CORE."funciones.php";
require_once CORE."helpers.php";


//require_once "app/modelo.php";


//require_once "modelos/categorias.modelo.php";
//require_once "modelos/productos.modelo.php";
//require_once "modelos/clientes.modelo.php";
//require_once "modelos/ventas.modelo.php";



require_once MODELS."menu.modelo.php";

require_once MODELS."rol.modelo.php";

*/

// echo DS."<br>";
// echo ROOT."<br>";
// echo CORE."<br>";
// echo CONTROLADORES."<br>";
// echo VISTAS."<br>";
// echo MODELOS."<br>";
// echo PAGINAS."<br>";
// echo CSS."<br>";
// echo IMG."<br>";
// echo JS."<br>";
// echo $_SERVER['REMOTE_ADDR'];


//require_once "controladores/plantilla.controlador.php";



 $plantilla = new ControladorPlantilla();
 $plantilla -> ctrPlantilla();



/*
$vector = array(2,5,4,6,8,9,888,1);
$resultado=0;
$suma=0;
$cont=0;

for ($i=0; $i < sizeof($vector) ; $i++) { 
	$suma=$suma+$vector[$i];
	$cont++;
	# code...
}

$resultado=$suma/$cont;
echo "El resultado de la media es $resultado ";
*/

