// Establecer valores por defecto en todas las tablas
$.extend(true, $.fn.dataTable.defaults, {
	info:true,
	paging:true,
	ordering:true,
	searching:true,
	deferRender: true,
	retrieve: true,
	processing: true,
	//autoWidth: true,
	language: {

		"sProcessing":     "Procesando_Alex...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
				},
		"oAria":
			{
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
	},
	/*
	// Para configurar el idioma
	language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },*/
    // Para configurar la cantidad de regitros a filtrar
    lengthMenu: [
    	[10,25,50,100,500,-1],[10,25,50,100,500,"Todos"]
    ]
    // Para colocar botones, se requiere los archivos js y css
    // dom: "Bfrtip",
    //         buttons: [
    //             'copy', 'csv', 'excel', 'pdf', 'print',
    //             'selected',
    //             'selectedSingle',
    //             'selectAll',
    //             'selectNone',
    //             'selectRows',
    //             'selectColumns',
    //             'selectCells'
    //         ],
    //         select: true

});






/*=============================================
 //input Mask
=============================================*/

//Datemask dd/mm/yyyy
// $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
// //Datemask2 mm/dd/yyyy
// $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
// //Money Euro
// $('[data-mask]').inputmask()