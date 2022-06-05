<?php
libxml_use_internal_errors(true);

class ControladorSesion {

    private $idperfil;

    public function getPerfil(){

        return $this->idperfil;
    }


	/*=============================================
	Revisar si es que esta con la sesión iniciada
	=============================================*/

    static public function checkSession(){
        $check = false;

        if(
            isset($_SESSION['iniciarSesion']) && 
            !empty($_SESSION['iniciarSesion'])
        ){
            $check = true;
        }

        return $check;
    }

    /*=============================================
    Creación de sesión - con variables
    =============================================*/
    static public function createSession( array $datos ){
        $_SESSION = array();

		$_SESSION["iniciarSesion"]	= OK;
		$_SESSION["idusuario"] 		= $datos["idusuario"];
		$_SESSION["id"]				= $datos["idusuario"];
		$_SESSION["nombre"]			= $datos["nombre"];
		$_SESSION["usuario"]		= $datos["usuario"];
		$_SESSION["foto"]			= $datos["foto"];
		$_SESSION["idperfil"]		= $datos["idperfil"];
        //$this->idperfil=$datos["idperfil"];
    }

    /*=============================================
    Cerrar sesión
    =============================================*/
    static public function endSession(){
        $_SESSION = array();
        session_destroy();
        echo funciones::location(SERVERURL);
    }

    /*=============================================
    Revisar si ya caducó la sesión activa
    =============================================*/
    static public function validaTiempoSession(){

            if(isset($_SESSION['fechaSesion']))
            {
                $fechaGuardada = $_SESSION['fechaSesion'];
                $ahora = date('Y-m-d H:i:s');

                $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

                if($tiempo_transcurrido >= (TIME_OUT*60))
                {
                    ControladorSesion::endSession(); 
                    header("Refresh:0");
                    exit();
                }else
                    {$_SESSION['fechaSesion'] = date('Y-m-d H:i:s');}

            }else{$_SESSION['fechaSesion'] = date('Y-m-d H:i:s');}
    }


}