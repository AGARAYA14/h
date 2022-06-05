<?php

date_default_timezone_set("America/Lima");


/*=============================================
=           DIV         =
=============================================*/
const DIV_MODAL='<div class="modal-body">';
const DIV_OPEN='<div>';
const DIV_CLOSE='</div>';

/*=============================================
Para las rutas         =
=============================================*/
define('DS'         , DIRECTORY_SEPARATOR);
define('ROOT'       , getcwd().DS);

const CORE          = ROOT.'core'.DS;
const CONTROLADORES = ROOT.'controllers'.DS;
const MODELOS       = ROOT.'models'.DS;
const VISTAS        = ROOT.'views'.DS;

const INCLUDES      = ROOT.'extensiones'.DS;
const ARCHIVOS      = ROOT.'archivos'.DS;
// archivos/excel/exportacion/plantilla
const CSS           = VISTAS.'css'.DS;
const IMG           = VISTAS.'img'.DS;
const JS            = VISTAS.'js'.DS;
const PAGINAS       = VISTAS.'paginas'.DS;
const MODULOS       = PAGINAS.'modulos'.DS;
const REPORTES      = PAGINAS.'reportes'.DS;

const IMP           = ARCHIVOS.'importacion'.DS;
const EXP           = ARCHIVOS.'exportacion'.DS;
const EXP_DESCARGA  = 'archivos/excel/exportacion/descarga'.DS;
const EXP_PLANTILLA = 'archivos/excel/exportacion/plantilla'.DS;


const LOG          = ROOT.'logs'.DS;

const IMG_PLANTILLA   = IMG.'plantilla'.DS;

const SERVERURL="http://127.0.0.5:8080/";
const TITULO = "SISTEMA DE SOPORTE";
const MARCA_WEB = "Alex Garay";
const LINK_MARCA_WEB = "https://uniflex.com.pe/";
const TIME_OUT = 8000;
/*=============================================
Para las claves         =
=============================================*/
const METHOD="AES-256-CBC";
const SECRET_KEY='$AGARAY@2018@94938';
const SECRET_IV='101712';

const AGREGAR="Agregar";
const MODIFICAR="Modificar";

const MSJ_SQL=54;  //$c=54;



const INICIO="inicio";
/*=============================================
Para Operacion      =
=============================================*/
const CRUD_CREAR="Crear";
const CRUD_EDITAR="Editar";
const CRUD_ELIMINAR="Eliminar";
const EXPORTAR="Exportar";
/*=============================================
Para tipos de variable       =
=============================================*/
const NUMERO='Numero';
const TEXTO='Texto';
const EMAIL='Email';
const VARIABLE='Variable';

/*=============================================
Acciones    =
=============================================*/
const EJECUTAR="guardar_general";
const EJECUTAR2="Ejecutar_Alterno";
const EJECUTAR3="Ejecutar_Eliminacion";
const SA_CONSULTA="SweetAlert_Consulta";
const SA_ANIMADO="SweetAlert_Animado";
const SA_DOBLE="SweetAlert_Doble";
const SA_IMAGEN="SweetAlert_Imagen";

const TO_EJECUTA="Toast_SinBarra";
const TO_RIGHT="Toast_SuperiorDerecha";
const TO_LEFT="Toast_SuperiorIzquierda";
const TO_TOP="Toast_Superior";
const TO_BOTTOM="Toast_Inferior";

const NOT_OK="Notify_exito";
const NOT_ERROR="Notify_error";
const NOT_WARN="Notify_warning";
const NOT_INFO="Notify_info";
const NOT_SELECTOR="Notify_selector";
const NOT_POSICION="Notify_posicion";

const NOTI_OK="Notie_exito";
const NOTI_ERROR="Notie_error";
const NOTI_WARN="Notie_warning";
const NOTI_INFO="Notie_info";
const NOTI_NEUTRAL="Notie_neutral";
const NOTI_POSICION="Notie_posicion";

const ACCION_GUARDAR="guardar";

/*=============================================
Para toastr         =
=============================================*/
// const EXITO = "success";
// const INFO = "info";
// const PELIGRO = "warning";
/*=============================================
Para alertas         =
=============================================*/
const JS_SAME_PAGE = 'window.history.replaceState( null, null, window.location.href )';
const SWEET = "sweet";
const TOAST = "toast";
const NOTIFY = "notify";
const NOTIE = "notie";

const DANGER = "danger";
const INFO = "info";
const WARNING = "warning";
const SUCCESS = "success";
const QUESTION = "question";
/*=============================================
Para respuesta        =
=============================================*/
const OK=			"ok";
const OK2=           "ok2";
const ERROR=		"error";
const INVALIDO=		"invalido";
const PESO_INVALIDO="peso_invalido";
const TIPO_INVALIDO="tipo_invalido";
const ERROR_DESCONOCIDO="error_desconocido";
const ERROR_IMPORTACION="error_importacion";
const COLUMNA_INVALIDA="columnas_invalidas";


const IMAGEN = "IMAGEN";
const DOCUMENTO = "DOCUMENTO";
const IMPORTAR = "IMPORTAR";
const PLANO = "PLANO";
const COMPLETO = "COMPLETO";

const VALORES_IMAGEN = ['jpg','jpeg','png','gif'];
const VALORES_DOCUMENTO = ['docx','docm','xlsx','xlsm','pptx','pptm','pdf','xls','mpp'];
const VALORES_IMPORTAR = ['xlsx','xlsm','xls'];
const VALORES_PLANO = ['txt','ttx'];
const VALORES_COMPLETO = ['jpg','jpeg','png','gif','docx','docm','xlsx','xlsm','pptx','pptm','pdf','xls','mpp','txt','ttx','sql','dll','rar','zip','ra0'];




const PESO_IMAGEN = 3024000; //3 MB
const PESO_DOCUMENTO = 8064000; // 8MB
const PESO_IMPORTAR = 8064000; // 8 MB
const PESO_PLANO = 1008000; // 1 MB
const PESO_COMPLETO = 10080000; // 10 MB



const SQL_MOTOR	= "sql";
const SQL_HOST   = "AGARAY";
const SQL_NAME   = "Elna";
const SQL_USER   = "sa";
const SQL_PASS   = "123";



// Validar el texto ingresado provicional
function var_valida($variable) {
	if(preg_match('/^[a-zA-Z0-9]+$/', $variable)){
		 return true; 
		} else {
		return false;
		}
}

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

// Encriptar variable
function encripta($variable) {
	 return crypt($variable, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');		
}