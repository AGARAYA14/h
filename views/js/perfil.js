console.log('Ales');
const perfil="Perfil";
const tbody_NuevoFiltroPerfil  = $("#NuevoFiltroPerfil tbody");
console.log("tbody_NuevoFiltroPerfil", tbody_NuevoFiltroPerfil);

const perfil_path = window.location.pathname;
console.log("perfil_path", perfil_path);

let idvista_Perfil =0;
if (perfil_path.substr(1) == perfil.toLowerCase()) { 

  idvista_Perfil =document.getElementById(perfil).getAttribute("vista").toString(); 

} 

let E_Perfil = new Entidad (perfil,idvista_Perfil,tbody_NuevoFiltroPerfil,perfil_id);
console.log("E_Perfil", E_Perfil);


const perfil_campos = E_Perfil.getCampos();
const perfil_tabla= E_Perfil.getTablaAjax();
console.log("perfil_tabla", perfil_tabla);


/*=============================================
Columnas : Mostrar y ocultar columnas del data table
=============================================*/
$("a.columnas").on("click", function (e) { Columna.ocultarMostrar(perfil_tabla,$(this)); });

/*=============================================
Filtro : BotonModal
=============================================*/
$(".btnFiltroPerfil").click(() => E_Perfil.getFiltros(perfil_campos) ); 


/*=============================================
Filtro: Añadir Fila
=============================================*/
$("#btnNuevoFiltroPerfil").click(() => Arreglos_Filtro.nuevo_filtro(perfil_campos,tbody_NuevoFiltroPerfil) );

/*=============================================
Filtro: Cambiar tipo de dato input en cada Fila
=============================================*/
$('#NuevoFiltroPerfil tbody').on('change', '.scampo', event => Arreglos_Filtro.changeCampo_combo(event) );

/*=============================================
Filtro : Guardar registro de filtro
=============================================*/
$("#SaveFiltroPerfil").click((e) => {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  // Capturar los enlaces del filtro
  let enlaces = document.getElementsByName('f_enlace[]');

  let formDataFiltro = new FormData($("#formulario")[0]);
  // Añadir al formulario el idvista y idusuario
  formDataFiltro.append("idVista", idvista_Perfil);
  formDataFiltro.append("idUsuario", perfil_id);

  // Revisar si hay enlaces en el filtro
  if (enlaces.length!=0) {
      // Convertir a un array los enlaces.
      let combo = Array.from(enlaces);
      // validar que el ultimo filtro este en blanco
      let flagFiltro = Arreglos_Filtro.esFiltroValido(combo);

      if (flagFiltro) {
        E_Perfil.saveFiltro(true,formDataFiltro);
      
      } else {
            let msjErrorFiltro = new Notificacion (perfil,'ErrorSimple');
            let perfil_parametros=[];
            perfil_parametros.push({"texto": "Sólo el último enlace debe estar vacio"});
            msjErrorFiltro.notify(perfil_parametros);
      }

  } 
  // Si ls filtros estan vacios.
  else {
      E_Perfil.saveFiltro(false,formDataFiltro);
  }

} ); 


/*=============================================
Modificar Perfil
=============================================*/
$(".tablaPerfil").on("click", ".btnModificarPerfil", function(){

  let idperfil = $(this).attr("idperfil");
  let datos = new FormData();
  datos.append("idperfil", idperfil);

  $.ajax({
    url: "ajax/perfil.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success: function(respuesta){
      // $("#modificarperfil").val(respuesta["modulo"]);
      // $("#modificarOrden").val(respuesta["orden"]);
      // $("#idModulo").val(respuesta["pkid"]);
    }
  });

});

/*=============================================
Eliminar Perfil
=============================================*/
$(".tablaPerfil").on("click", ".btnEliminarPerfil", function(){
  let idperfil = $(this).attr("idperfil");

  let perfil_parametros=[];

  perfil_parametros.push({"ruta": perfil.toLowerCase(),"entidad":perfil,"valor":idperfil});

  let m_borrar = new Notificacion(perfil.toLowerCase(),'Eliminar');
  m_borrar.sweet(perfil_parametros);

});

/*=============================================
Exportar Perfil
=============================================*/
$(".btnExportarPerfil").click( function(){

  let lista_campos = $("#Lista_Campos");
  // metodo de campos
  E_Perfil.getListaCampos(lista_campos);
  // marcar los checks
  funArchivo.marcarChecks();

});


/*=============================================
Importar Perfil
=============================================*/
$(".btnImportarPerfil").click( function(){

    // Poner el nombre del archivo en el input
    $("#file_archivo :file").on('change', function () {
        var input = $(this).parents('.input-group').find(':text');
        input.val($(this).val());
    });

    // Capturar el archivo y enviarlo para ser procesado
    $("#filePerfil").change(function(){

        let fileInput = document.getElementById('filePerfil');

        let fileImportar = new Archivo (fileInput, IMPORTAR);
        fileImportar.mostrarAlerta();
    });

});








