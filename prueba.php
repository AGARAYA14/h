<!-- <a href="">Alex Garay </a>



                        $datos_auditoria= array(
                              "idusuario" => $_SESSION["idusuario"],
                              "tipo" => substr($_SERVER['REQUEST_URI'], 1),
                              "operacion" => "Prueba",
                              "id_entidad" => 0,
                              "pc" => util::ObtenerIp()." - ".gethostname(),
                              "navegador" => util::ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),
                              "fecha" => date('Y-m-d H:i:s'),
                              "contenido"=>funciones::arrayToXml($_SERVER)
                              //"contenido" => $xml->asXML()
                              //"contenido" =>  json_encode($_SERVER)
                             );
    $respuesta = ModeloParametros::mdlIngresarAuditoria($datos_auditoria);


<a href=""></a>
<a href=""></a>
<a href=""></a>
<a href=""></a>
<a href=""></a> -->
<?php 
// $basefichero = basename("tutorial.txt");
// $descripcion = "HOLA";
// header( "Content-Type: application/octet-stream");
// header( "Content-Length: ".filesize("tutorial.txt"));
// header( "Content-Disposition: attachment; filename=".$basefichero."");

// fwrite($basefichero, date("Y-m-d H:i:s").' >>> '.$descripcion."\r\n");
// fclose($basefichero);     
// readfile("tutorial.txt");

// Definimos el nombre de archivo a descargar.
 $filename = "tutorial.txt";
 // Ahora guardamos otra variable con la ruta del archivo
 //$file = "ruta/".$filename;
 // Aquí, establecemos la cabecera del documento
 header("Content-Description: Descargar imagen");
 header("Content-Disposition: attachment; filename=$filename");
 header("Content-Type: application/force-download");
 //header("Content-Length: " . filesize($file));
 header("Content-Transfer-Encoding: binary");
 readfile($file);


function DescargarArchivo($fichero){

$basefichero = basename($fichero);

header( "Content-Type: application/octet-stream");

header( "Content-Length: ".filesize($fichero));

header( "Content-Disposition:attachment;filename=" .$basefichero."");
readfile($fichero);
}
 ?>