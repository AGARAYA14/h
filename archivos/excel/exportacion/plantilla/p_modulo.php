<?php
/*
$ruta=dirname(__FILE__, 5);
require_once $ruta."/extensiones/Excel_PHP/PHPExcel/IOFactory.php";
require_once $ruta."/extensiones/Excel_PHP/PHPExcel.php";
*/
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Lista de Contacto</title>
	<head>
	<body>
		<?php

		// le damos el nombre al fichero exportado
			$archivo = 'Modulo_Plantilla.xls';
			
			// Creacion de la tabla para devolver resultados de MySQL
			$html = '';
			$html .= '<table border="1">';
/*			$html .= '<tr>';
			$html .= '<td colspan="5">Lista de Contactos</tr>';
			$html .= '</tr>';*/
			
			
			$html .= '<tr>';
			$html .= '<td style="background: #C7E6EF"><b>MODULO</b></td>';
			$html .= '<td style="background: #C7E6EF"><b>ORDEN</b></td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<td style="background: #FFF8DC"><i>modulo prueba</i></td>';
			$html .= '<td style="background: #FFF8DC"><i>1</i></td>';
			$html .= '<td style="background: #FFFF00"><i>(Fila de ejemplo)</i></td>';
			$html .= '</tr>';
			
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

		?>
	</body>
</html>


