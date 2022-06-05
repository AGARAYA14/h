<?php
/*
//Para detectar caracteres alfanumericos
ctype_alnum($_POST["user"]) ? $_POST["user"] : null;

// Condicionar el numero de string
$telefono = "1234567";
$telefono = preg_replace('/[^\d]/', "", $telefono);
$length = strlen($telefono);
if ($length = 7 || $length = 10 || $length = 11){
    echo "$telefono es un formato válido";
}

// Sanitizar comentario de usuario - Retira las etiquetas HTML y PHP de un string
$comentario = strip_tags($_POST["comentario"]);

*/
/*
function encryption ($string) {
    $key = "TIENE QUE SER LA MISMA EN LAS 2 FUNCIONES";
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
}
 
function decryption ($string) {
    $key = "TIENE QUE SER LA MISMA EN LAS 2 FUNCIONES";
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
}
*/
//------------------------------------
/*
function encryption ($string){
    $output=FALSE;
    $key=hash('sha256',SECRET_KEY);
    $iv=substr(hash('sha256',SECRET_IV),0,16);
    $output=openssl_encrypt($string,METHOD,$key,0,$iv);
    $output=base64_encode($output);
    return $output;
}


function decryption ($string){
    //$output=FALSE;
    $key=hash('sha256',SECRET_KEY);
    $iv=substr(hash('sha256',SECRET_IV),0,16);
    $output=openssl_decrypt(base64_decode($string),METHOD,$key,0,$iv);
    return $output;
}
    
*/
/*=============================================
Funcion para encriptar
=============================================*/
function var_encripta ($string):string{
    $output=FALSE;
    $key=hash('sha256',SECRET_KEY);
    $iv=substr(hash('sha256',SECRET_IV),0,16);
    $output=openssl_encrypt($string,METHOD,$key,0,$iv);
    $output=base64_encode($output);
    return $output;
}

/*=============================================
Funcion para desencritar
=============================================*/
function var_desencripta ($string):string{
    $key=hash('sha256',SECRET_KEY);
    $iv=substr(hash('sha256',SECRET_IV),0,16);
    $output=openssl_decrypt(base64_decode($string),METHOD,$key,0,$iv);
    return $output;
}


// Recibir un check
function var_check($variable) {
    if($variable =="on"){
         return 1; 
        } else {
        return 0;
        }
}

// Validar el texto ingresado
function var_valida($variable) {
	if(preg_match('/^[a-zA-Z0-9]+$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}
//------------------------------------------------------------------------------------
function var_valida_texto($variable) {
	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_. ]+$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}
//------------------------------------------------------------------------------------
function var_valida_numero($variable) {
	if(preg_match('/^[0-9]+$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}
//------------------------------------------------------------------------------------
function var_valida_mail($variable) {
	if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}
//------------------------------------------------------------------------------------
function var_valida_telefono($variable) {
	if(preg_match('/^[()\-0-9 ]+$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}
//------------------------------------------------------------------------------------
function var_valida_direccion($variable) {
	if(preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}
//------------------------------------------------------------------------------------

// ---------------------------------------------------------------------
// Encriptar variable
function encripta($variable) {
	 return crypt($variable, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');		
}

//limpiar cadenas
function limpiar_cadena($cadena){
    $cadena=trim($cadena);
    $cadena=stripcslashes($cadena);
    $cadena=str_ireplace("<script>","",$cadena);
    $cadena=str_ireplace("</script>","",$cadena);
    $cadena=str_ireplace("<script src","",$cadena);
    $cadena=str_ireplace("<script type","",$cadena);
    $cadena=str_ireplace("select * from","",$cadena);
    $cadena=str_ireplace("delete from","",$cadena);
    $cadena=str_ireplace("insert into","",$cadena);
    $cadena=str_ireplace("--","",$cadena);
    $cadena=str_ireplace("^","",$cadena);
    $cadena=str_ireplace("[","",$cadena);
    $cadena=str_ireplace("]","",$cadena);
    $cadena=str_ireplace("==","",$cadena);
    return $cadena;
}

//limpiar cadenas query
function limpiar_cadena_query($cadena){
    $cadena=trim($cadena);
    $cadena=stripcslashes($cadena);
    $cadena=str_ireplace("<script>","",$cadena);
    $cadena=str_ireplace("</script>","",$cadena);
    $cadena=str_ireplace("<script src","",$cadena);
    $cadena=str_ireplace("<script type","",$cadena);
    $cadena=str_ireplace("delete from","",$cadena);
    $cadena=str_ireplace("insert into","",$cadena);
    $cadena=str_ireplace("--","",$cadena);
    $cadena=str_ireplace("^","",$cadena);
    $cadena=str_ireplace("[","",$cadena);
    $cadena=str_ireplace("]","",$cadena);
    $cadena=str_ireplace("==","",$cadena);
    return $cadena;
}

/*=============================================
Funcion para obtener consulta a exportar
=============================================*/
function Consulta_Exportar ($select,$consulta,$where='',$orden=''):string{
    $resultado='';

if(isset($consulta)){

        $pos = strpos($consulta["consulta"], 'from');
        $consulta_desde_from = substr($consulta["consulta"],$pos);
        $resultado = $select.$consulta_desde_from.$where.$orden; 
}

    return $resultado;
}


/*=============================================
Sweet Alert 
=============================================*/

function sweet_alert($datos)
{
    if($datos['Accion']=="simple"){
        $alerta="
                <script>
                swal(
                    '".$datos['Titulo']."',
                    '".$datos['Texto']."',
                    '".$datos['Tipo']."'
                );
                </script>    ";

    } elseif ($datos['Accion']=="recargar"){
        $alerta="
                <script>
                swal({
                        title: '".$datos['Titulo']."',
                        text: '".$datos['Texto']."',
                        tipo: '".$datos['Tipo']."',
                        confirmButtonText: 'Aceptar'
                    }).then(function(){location.reload();
                });
                </script>    ";

    } elseif ($datos['Accion']=="limpiar"){
       $alerta="
                <script>
                swal({
                        title: '".$datos['Titulo']."',
                        text: '".$datos['Texto']."',
                        tipo: '".$datos['Tipo']."',
                        confirmButtonText: 'Aceptar'
                    }).then(function(){ $('.FormularioAjax')[0].reset();
                });
                </script>    ";

    }elseif ($datos['Accion']=="guardar"){
       $alerta="
                <script>
                swal({
                		type: '".$datos['Tipo']."',
                        title: '".$datos['Titulo']."',
						showConfirmButton: true,
						confirmButtonText: 'Cerrar'
                    }).then(function(result){ 
                    	window.location = '".$datos['Entidad']."';
                })
                </script>";

    }
return $alerta;


}

/*=============================================
ver el tipo de archivo
=============================================*/
function validar_tipo_archivo($archivo_tipo,$archivo)
{
$extension = strtolower(preg_replace('/^.*\./','',$archivo));
$resultado=false;
switch($archivo_tipo){
        case IMAGEN: 
                $resultado=in_array($extension,VALORES_IMAGEN, true);
                // 3 MB
                //if (peso <= 3024000){ resultado=true; } else {resultado=false;}; 
                //peso <= 3024000 ?  resultado=[true,0,''] : resultado=[false,3,'MB']; 
        break;
        case DOCUMENTO:
                $resultado=in_array($extension,VALORES_DOCUMENTO, true);
                // 8 MB
                //peso <= 8064000 ?  resultado=true : resultado=false; 
               // peso <= 8064000 ?  resultado=[true,0,''] : resultado=[false,8,'MB']; 
        break;
        case IMPORTAR:
                // 8 MB
                //peso <= 8064000 ?  resultado=[true,0,''] : resultado=[false,8,'MB']; 
                
                $resultado=in_array($extension,VALORES_IMPORTAR, true);
        break;
        case PLANO:
                $resultado=in_array($extension,VALORES_PLANO, true);
                // 1 MB
                //peso <= 1008000 ?  resultado=[true,0,''] : resultado=[false,1,'MB'];  
        break;
        case COMPLETO:
                $resultado=in_array($extension,VALORES_COMPLETO, true);
                // 10 MB
                // 
                //peso <= 10080000 ?  resultado=[true,0,''] : resultado=[false,10,'MB'];  
        break;
        default:
                //resultado=false; 
                $resultado=false;
        break;  
}
return $resultado;

}

/*=============================================
ver el peso de archivo
=============================================*/
function validar_peso_archivo($archivo_tipo,$archivo)
{
//$extension = strtolower(preg_replace('/^.*\./','',$archivo));
$resultado=false;
switch($archivo_tipo){
        case IMAGEN:    $archivo <= PESO_IMAGEN? $resultado=true : $resultado=false; 
        break;
        case DOCUMENTO: $archivo <= PESO_DOCUMENTO? $resultado=true : $resultado=false; 
        break;
        case IMPORTAR:  $archivo <= PESO_IMPORTAR? $resultado=true : $resultado=false; 
        break;
        case PLANO:     $archivo <= PESO_PLANO? $resultado=true : $resultado=false; 
        break;
        case COMPLETO:  $archivo <= PESO_COMPLETO? $resultado=true : $resultado=false; 
        break;
        default: $resultado=false;
        break;  
}
return $resultado;

}

/*=============================================
ver el tipo de archivo
=============================================*/

function get_mimetype($filepath) {
    if(!preg_match('/\.[^\/\\\\]+$/',$filepath)) {
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepath);
    }
    switch(strtolower(preg_replace('/^.*\./','',$filepath))) {
        // START MS Office 2007 Docs
        case 'docx':
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        case 'docm':
            return 'application/vnd.ms-word.document.macroEnabled.12';
        case 'dotx':
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
        case 'dotm':
            return 'application/vnd.ms-word.template.macroEnabled.12';
        case 'xlsx':
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        case 'xlsm':
            return 'application/vnd.ms-excel.sheet.macroEnabled.12';
        case 'xltx':
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
        case 'xltm':
            return 'application/vnd.ms-excel.template.macroEnabled.12';
        case 'xlsb':
            return 'application/vnd.ms-excel.sheet.binary.macroEnabled.12';
        case 'xlam':
            return 'application/vnd.ms-excel.addin.macroEnabled.12';
        case 'pptx':
            return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
        case 'pptm':
            return 'application/vnd.ms-powerpoint.presentation.macroEnabled.12';
        case 'ppsx':
            return 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
        case 'ppsm':
            return 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12';
        case 'potx':
            return 'application/vnd.openxmlformats-officedocument.presentationml.template';
        case 'potm':
            return 'application/vnd.ms-powerpoint.template.macroEnabled.12';
        case 'ppam':
            return 'application/vnd.ms-powerpoint.addin.macroEnabled.12';
        case 'sldx':
            return 'application/vnd.openxmlformats-officedocument.presentationml.slide';
        case 'sldm':
            return 'application/vnd.ms-powerpoint.slide.macroEnabled.12';
        case 'one':
            return 'application/msonenote';
        case 'onetoc2':
            return 'application/msonenote';
        case 'onetmp':
            return 'application/msonenote';
        case 'onepkg':
            return 'application/msonenote';
        case 'thmx':
            return 'application/vnd.ms-officetheme';
            //END MS Office 2007 Docs
        default: return 'no encontrado';
    }
    return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filepath);
}
