
const modulo="Modulo";
const tbody_NuevoFiltroModulo  = $("#NuevoFiltroModulo tbody");

const modulo_path = window.location.pathname;

let idvista_Modulo =0;

if (modulo_path.substring(modulo_path.length - modulo.length) == modulo.toLowerCase()) {

  idvista_Modulo =document.getElementById(modulo).getAttribute("vista").toString();
}

let E_Modulo = new Entidad (modulo,idvista_Modulo,tbody_NuevoFiltroModulo,perfil_id);

const modulo_campos = E_Modulo.getCampos();
const modulo_tabla= E_Modulo.getTablaAjax();

/*=============================================
Columnas : Mostrar y ocultar columnas del data table
=============================================*/
$("a.columnas").on("click", function (e) { Columna.ocultarMostrar(modulo_tabla,$(this)); });

/*=============================================
Filtro : BotonModal
=============================================*/
$(".btnFiltroModulo").click(() => E_Modulo.getFiltros(modulo_campos) ); 


/*=============================================
Filtro: Añadir Fila
=============================================*/
$("#btnNuevoFiltroModulo").click(() => Arreglos_Filtro.nuevo_filtro(modulo_campos,tbody_NuevoFiltroModulo) );

/*=============================================
Filtro: Cambiar tipo de dato input en cada Fila
=============================================*/
$('#NuevoFiltroModulo tbody').on('change', '.scampo', event => Arreglos_Filtro.changeCampo_combo(event) );

/*=============================================
Filtro : Guardar registro de filtro
=============================================*/
$("#SaveFiltroModulo").click((e) => {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  // Capturar los enlaces del filtro
  let enlaces = document.getElementsByName('f_enlace[]');

  let formDataFiltro = new FormData($("#formulario")[0]);
  // Añadir al formulario el idvista y idusuario
  formDataFiltro.append("idVista", idvista_Modulo);
  formDataFiltro.append("idUsuario", perfil_id);

  // Revisar si hay enlaces en el filtro
  if (enlaces.length!=0) {
      // Convertir a un array los enlaces.
      let combo = Array.from(enlaces);
      // validar que el ultimo filtro este en blanco
      let flagFiltro = Arreglos_Filtro.esFiltroValido(combo);

      if (flagFiltro) {
        E_Modulo.saveFiltro(true,formDataFiltro);

      } else {
            let msjErrorFiltro = new Notificacion (modulo,'ErrorSimple');
            let modulo_parametros=[];
            modulo_parametros.push({"texto": "Sólo el último enlace debe estar vacio"});
            msjErrorFiltro.notify(modulo_parametros);
      }

  }
  // Si ls filtros estan vacios.
  else {
      E_Modulo.saveFiltro(false,formDataFiltro);
  }

} );


/*=============================================
Modificar Modulo
=============================================*/
$(".tablaModulo").on("click", ".btnModificarModulo", function(){

  let idmodulo = $(this).attr("idmodulo");
  let datos = new FormData();
  datos.append("idmodulo", idmodulo);

  $.ajax({
    url: "ajax/modulo.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success: function(respuesta){
      $("#modificarModulo").val(respuesta["modulo"]);
      $("#modificarOrden").val(respuesta["orden"]);
      $("#idModulo").val(respuesta["pkid"]);
    }
  });

});

/*=============================================
Eliminar Modulo
=============================================*/
$(".tablaModulo").on("click", ".btnEliminarModulo", function(){
  let idmodulo = $(this).attr("idmodulo");

  let modulo_parametros=[];
  // modulo_opciones.push({"icono":"warning","btn_Aceptar":`Sí, borrar ${modulo}!`,"tipo":"v.opcion"});

  modulo_parametros.push({"ruta": modulo.toLowerCase(),"entidad":modulo,"valor":idmodulo});

  let m_borrar = new Notificacion(modulo.toLowerCase(),'Eliminar');
  m_borrar.sweet(modulo_parametros);

});

/*=============================================
Exportar Modulo
=============================================*/
$(".btnExportarModulo").click( function(){

  let lista_campos = $("#Lista_Campos");
  // metodo de campos
  E_Modulo.getListaCampos(lista_campos);
  // marcar los checks
  funArchivo.marcarChecks();

});


/*=============================================
Importar Modulo
=============================================*/
$(".btnImportarModulo").click( function(){

    // Poner el nombre del archivo en el input
    $("#file_archivo :file").on('change', function () {
        var input = $(this).parents('.input-group').find(':text');
        input.val($(this).val());
    });

    // Capturar el archivo y enviarlo para ser procesado
    $("#fileModulo").change(function(){

        let fileInput = document.getElementById('fileModulo');

        let fileImportar = new Archivo (fileInput, IMPORTAR);
        fileImportar.mostrarAlerta();
    });

});




