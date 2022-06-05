<?php

class funciones {

    /*=============================================
    ----------  Paginas  ----------
    =============================================*/

    /*---------- Retornar Pagina de error  ----------*/
    public static function error () {
        include MODULOS.'404.php';
    }

    /*----------  Redireccionar a pagina ----------*/
    public static function location ($pagina) : string {
        $resultado = '';
        $resultado .= '<script> window.location ="'.$pagina.'"; </script>';
        return $resultado;
    }

    /*=============================================
    ----------  DIV's  ----------
    =============================================*/

    /*----------  Mostrar Alerta  ----------*/
    public static function div_alerta ($alerta, $texto) : string {
        $resultado = '<br>';
        $resultado .= '<div class="alert alert-'.$alerta.'">'.$texto.'</div>';
        return $resultado;
    }

    /*----------  Funcion para mostrar texto de ERROR ----------*/
    public static function notifica_mensaje ($texto,$tipodato) {
         return "<strong> {$texto} </strong> No es de tipo ".strtolower($tipodato);
         //return "{$texto} No es de tipo ".strtolower($tipodato)." Por favor verificar";
    }

    public static function notifica_mensaje2 ($texto,$tipodato) {
         return "{$texto} : No es de tipo ".strtolower($tipodato);
         //return "{$texto} No es de tipo ".strtolower($tipodato)." Por favor verificar";
    }

    /*----------  Detalle del error de SQL ----------*/
    public static function error_sql ($cadena){
        $n='';
        $resultado='';
        if(!empty($cadena))
        {
            $n=strlen($cadena[2]);
            $resultado = substr($cadena[2],MSJ_SQL,$n-MSJ_SQL);
        }

        return $resultado;
    }

    /*=============================================
    ----------  Encriptar  ----------
    =============================================*/

    /*----------  Encriptar variable ----------*/
    public static function encripta($variable) {

        return crypt($variable, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');        
    }

    /*----------  Funcion para encriptar ----------*/
    public static function var_encripta ($string):string{
        $output=FALSE;
        $key=hash('sha256',SECRET_KEY);
        $iv=substr(hash('sha256',SECRET_IV),0,16);
        $output=openssl_encrypt($string,METHOD,$key,0,$iv);
        $output=base64_encode($output);
        return $output;
    }

    /*----------  Funcion para desencritar ----------*/
    public static function var_desencripta ($string):string{
        $key=hash('sha256',SECRET_KEY);
        $iv=substr(hash('sha256',SECRET_IV),0,16);
        $output=openssl_decrypt(base64_decode($string),METHOD,$key,0,$iv);
        return $output;
    }

    /*----------  Funcion para desencriptar y devolver numerico (ID) ----------*/
    public static function get_id_num ($valor):int{
        $rspta=0;
        $rspta= (is_numeric($valor)) ? $valor : (int) funciones::var_desencripta($valor); 
        return $rspta;
    }



    /*=============================================
    VALIDACIONES (BOOLEAN)
    =============================================*/
    /*----------  VALIDA SI EXISTE EN ARRAY EL PERMISO ----------*/
    public static function siTiene($tipo,$permiso,$array){
        $actividad=$tipo.'_'.$permiso;
        $a = array_search($actividad, array_column($array, 2));

        if(isset($a))  return true;
        else return false;
    }

    /*---------- VALIDA EXISTENCIA DE CREAR ----------*/
    public static function esValido($valor){
        if(isset($valor))  return true;
        else return false;

    }

    /*----------  Revisar si un rol es auditable  ----------*/
    public static function esAuditable ($tipo,$permiso,$array){
        $actividad=$tipo.'_'.$permiso;

        $a = array_search($actividad, array_column($array, 2));

        if ($GLOBALS['roles'][$a][8]) return true;
        else return false;
    }

    /*----------  rECIBIR UN CHECK  ----------*/
    public static function var_check($variable) {
        if($variable =="on"){
             return 1; 
            } else {
            return 0;
            }
    }

    /*=============================================
    ARREGLOS
    =============================================*/

    /*---------- Funcion que devuelve la fecha actual ----------*/
    public static function get_date():string{
        $fechaActual ='';
        $fecha = date('Y-d-m');
        $hora = date('H:i:s');

        $fechaActual = $fecha.' '.$hora;


        return $fechaActual;
    }

    /*---------- Concatener un array  ----------*/
    public static function concatena_array ($cadena) : string {
        $resultado = '';
        foreach ($cadena as $i) {
            $resultado .= "<h4>". $i . "</h4>";
        }

        return $resultado;
    }

    /*---------- Funcion para devolver un array ----------*/
    public static function get_array ($array,$indice,$valor=null):array{

        $resultado = array();

        if($valor != null) 
        {
            foreach($array as $fila)
            { $resultado[trim($fila[$indice])] = trim($fila[$valor]); }

        } else {
                foreach($array as $fila)
                { $resultado[] = trim($fila[$indice]); }
        }

        return $resultado;
    }

    /*---------- Funcion para devolver en formato xML ----------*/
    public static function arrayToXml($array, $rootElement = null, $xml = null) { 
        $_xml = $xml; 
          
        // If there is no Root Element then insert root 
        if ($_xml === null) { 
            $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>'); 
        } 
          
        // Visit all key value pair 
        foreach ($array as $k => $v) 
        {    
            // If there is nested array then 
            if (is_array($v)) 
                {   
                // Call function for nested array 
                arrayToXml($v, $k, $_xml->addChild($k)); 
                }        
            else {    
                // Simply add child element.  
                $_xml->addChild($k, $v); 
            } 
        }   
        return $_xml->asXML(); 
    } 


    /*=============================================
    VALIDAR CAMPOS
    =============================================*/
    /*----------  Limpiar Cadenas  ----------*/
    public static function limpiar_cadena($cadena){
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

    /*---------- limpiar cadenas query ----------*/
    public static function limpiar_cadena_query($cadena){
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

    /*---------- valida segun el tipo de dato ----------*/
    public static function valida($variable): string {
        $Resultado = '';
        foreach ($variable as $v) 
        {

            switch ($v[1])
            {
                case NUMERO: $Resultado .= (self::esNumero($v[0]))? "": " {$v[0]} no es un número" ; break;
                case TEXTO: $Resultado .= (self::esTexto($v[0]))? "": " {$v[0]} no es un Texto"; break;
                case AGREGAR:  break;
                case AGREGAR:  break;
            }
            
        }

        return $Resultado;
    }

    /*---------- valida texto con número ----------*/
    public static function var_valida($variable) {
        if(preg_match('/^[a-zA-Z0-9]+$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }

    /*---------- valida si es texto ----------*/
    public static function esTexto($variable) {
        if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_. ]+$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }

    /*---------- valida si es número ----------*/
    public static function esNumero($variable) {
        if(preg_match('/^[0-9]+$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }

    /*---------- valida email ----------*/
    public static function var_valida_mail($variable) {
        if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }

    /*---------- valida numero de telefono ----------*/
    public static function var_valida_telefono($variable) {
        if(preg_match('/^[()\-0-9 ]+$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }

    /*---------- valida la dirección----------*/
    public static function var_valida_direccion($variable) {
        if(preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }    
    /*---------- valida texto en filtro----------*/
    public static function var_valida_filtro($variable) {
        if(preg_match('/^[%\#\.\-a-zA-Z0-9 ]+$/', $variable)){
             return true; 
            } else {
            return false;
            }
    }



    /*---------- ver el tipo de archivo ----------*/
    public static function validar_tipo_archivo($archivo_tipo,$archivo)
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

    /*---------- ver el peso de archivo ----------*/
    public static function validar_peso_archivo($archivo_tipo,$archivo)
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

    /*---------- Tipos de archivos ----------*/
    public static function get_mimetype($filepath) {
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





}
