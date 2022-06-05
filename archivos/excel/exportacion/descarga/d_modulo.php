<?php

$ruta=dirname(__FILE__, 5);
require_once $ruta."/core/globales.php";
require_once $ruta."/core/funciones.php";
require_once $ruta."/core/helpers.php";

require_once $ruta."/controllers/contenedor_vista.controlador.php";
require_once $ruta."/models/contenedor_vista.modelo.php";

require_once $ruta."/controllers/modulo.controlador.php";
require_once $ruta."/models/modulo.modelo.php";

		
if(isset($_POST["Enviar"]))

{ 		

$Select = "SELECT ";
	
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Modulo - Exportar</title>
	<head>
	<body>
		<?php

			// le damos el nombre al fichero exportado
			$archivo = 'Modulo_Exportar.xls';
			
			// Inicio de tabla
			$html = '';
			$html .= '<table border="1">';

			
		if(!empty($_POST['modulo_columnas']))

		{
			// Obtener número de elementos de array
			$keys = array_keys($_POST['modulo_columnas']);

			$html .= '<tr>';

			// concatenar los campos del array y si es el último para terminar
			foreach($_POST['modulo_columnas'] as $key => $campo)
			{
			    if ($key === end($keys)) 
			    {
			        $Select .= $campo." ";
			    } else {
			        	$Select .= $campo.",";
			    		}
				// Colocar las cabeceras
				$html .= '<td style="background: #C7E6EF"><b>'.strtoupper($campo).'</b></td>';
			
			}
	


			$html .= '</tr>';	

			// Obtener la consulta de vista administrativa	
			$menu_usuario2 = ControladorContenedorVista::ctrValidarContenedorVista("Modulo",$_POST["p_id"]);
			
			if($menu_usuario2)
			{
				// Obtener la consulta con los campos que seleccionaron
				$Consulta=helper::Consulta_Exportar($Select,$menu_usuario2);
				// Recoger el resultado
				$menu_query2 = ControladorContenedorVista::ctrObtenerConsultaVista($Consulta);	

				if (isset($menu_query2))
				{
					foreach($menu_query2 as $key => $campo)
					{
						// Recorrer cada cabecera
						$html .= '<tr>';
						
						foreach($_POST['modulo_columnas'] as $key => $c)
						{
							// Recorrer cada valor resultado de la consulta
							$html .= '<td>'.$campo[$c].'</td>';
						}
						
						$html .= '</tr>';
					}
				}
			}


			
	} else {
			// En caso no haya resultados
			$html .= '<tr>';
			$html .= '<td style="background: #C7E6EF"><b>NO HAY CAMPOS SELECCIONADOS</b></td>';
			$html .= '</tr>';
			}

// Configuracion para la descarga del excel
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$archivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Envia contenido archivo
echo $html;
exit;

}

?>

	</body>
</html>


