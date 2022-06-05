<?php

                //$conexion = new PDO("sqlsrv:Server="AGARAY";Database="u_Elna";ConnectionPooling=0", "sa","123");

$contraseña = "123";
$usuario = "sa";
$nombreBaseDeDatos = "u_Elna";
// Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
$rutaServidor = "AGARAY";
try {
    $base_de_datos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
    //$base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
var_dump ($base_de_datos);


} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
}


