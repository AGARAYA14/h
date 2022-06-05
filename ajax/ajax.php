<?php
// require_once "../controladores/modulo.controlador.php";
// require_once "../modelos/modulo.modelo.php";
require_once "../core/funciones.php";
require_once "../core/globales.php";
require_once "../core/helpers.php";
//require_once "../controladores/contenedor_vista.controlador.php";
require_once "../models/filtro.modelo.php";


abstract class Ajax{
	
	private $idvista;
	//private $idusuario;

  /*=============================================
  Funcion Constructor
  =============================================*/
  public function __construct ($idvista){
  		$this->idvista=$idvista;
  		//$this->idusuario=$usuario;
  	}
  /*=============================================
  Funcion para recuperar las columnas de la configuración vista
  =============================================*/
  public function columnasEntidad (){
    $resultado = null;
    $respuesta = ModeloFiltro::mdlRecuperaColumnas($this->idvista);
    echo json_encode($respuesta);

  }

  /*=============================================
  Funcion para devolver el formato json
  =============================================*/
  public function filtro ($idusuario){
      $respuesta = ModeloFiltro::mdlMostrarFiltro($this->idvista, $idusuario);
      echo json_encode($respuesta);

  	}

  public function registrarFiltro ($idFiltro,$idusuario, $array) {

    $r = ModeloFiltro::mdlIngresarFiltro($this->idvista,$idusuario,$idFiltro,$array);
    helper::array_rspta($r);

  }








}


