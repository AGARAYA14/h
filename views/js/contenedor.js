/*=============================================
EDITAR CONTENEDOR VISTA
=============================================*/
$(".tablas").on("click", ".btnModificarContenedor", function(){

	let idcontenedor = $(this).attr("idcontenedorvista");
	//console.log(idcontenedor);
	let datos = new FormData();
	datos.append("idcontenedor",idcontenedor);
	console.log(datos);
	$.ajax({
		url: "ajax/contenedor.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
		//console.log(respuesta);

     		$("#modificarContenedor").val(respuesta["Contenedor"]);
     		$("#modificarConfiguracionVista").val(respuesta["Configuracion"]);
            $("#modificarquery").val(respuesta["query"]);
     		$("#idContenedor").val(respuesta["pkid"]);

     	}

	})

})

/*=============================================
RECUPERAR LAS COLUMNAS
=============================================*/
$(".tablas").on("click", ".btnAsignarContenedorColumna", function(){

    let idcontenedor2 = $(this).attr("idcontenedorvista");

    let fila = $("#NuevatablaContenedor tbody");
    let dato1 = $("#Contenedor");
    fila.find('tr').remove();
    dato1.find('input').remove();

    //console.log(fila);
    let datos = new FormData();
    datos.append("ContenedorID",idcontenedor2);
    //console.log(datos);
    $.ajax({
        url: "ajax/contenedor.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json",
        success: function(respuesta){
        //console.log(respuesta);
        $(dato1).append(
            "<input type='hidden' class='form-control' name='CID' value='"+ respuesta[0][0] +"' required>"+
            "<input type='hidden' class='form-control' name='IDCV' value='"+ respuesta[0][2] +"' required>");

              $(respuesta).each(function(i, v)// indice, valor
              { 
                $(fila).append(
                "<tr>"+
                "<td><input type='text' class='form-control' name='texto[]' value='"+ v.texto+"' required></td>"+
                "<td><input type='number' class='form-control' name='ancho[]' value='"+ v.ancho+"' required></td>"+
                "<td><input type='number' class='form-control' name='orden[]' value='"+ v.orden+"' required></td>"+
                "<td><input type='text' class='form-control' name='opcion[]' value='"+ v.opcion+"' required></td>"+
                "<td><input type='text' class='form-control' name='nombresql[]' value='"+ v.nombresql+"' required></td>"+
                "<td><input type='checkbox' name='visible[]' class='minimal visibilidad' value='"+ v.visible+"' "+ fcheck(v.visible)+">"+
                "<input type='hidden' class='oculto' name='check[]' value='"+ v.visible+"'></td>"+
                "<td class='text-center'><div class='btn btn-danger BorrarFila'>Eliminar</div></td>"+
                "</tr>"
                );

              });

        }

    })

})



/*=============================================
BORRAR LAS FILAS
=============================================*/

$(function () {
    $(document).on('click', '.BorrarFila', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
});


/*=============================================
AÑADIR LA FILA
=============================================*/
        $("#btnNuevaFilaContenedor").click(function(){

                let fila2 = $("#NuevatablaContenedor tbody");

                $(fila2).append(
                "<tr>"+
                "<td><input type='text' class='form-control' name='texto[]' required></td>"+
                "<td><input type='number' class='form-control' name='ancho[]' required></td>"+
                "<td><input type='number' class='form-control' name='orden[]' required></td>"+
                "<td><input type='text' class='form-control' name='opcion[]' required></td>"+
                "<td><input type='text' class='form-control' name='nombresql[]' required></td>"+
                "<td><input type='checkbox' class='minimal visibilidad' value=0 name='visible[]'>"+
                 "<input type='hidden' class='oculto' name='check[]' value=0></td>"+
                "<td class='text-center'><div class='btn btn-danger BorrarFila'>Eliminar</div></td>"+
               
                "</tr>");
        });

/*=============================================
AL MOMENTO DE CLICK A LA VISIBILIDAD
=============================================*/

$("#NuevatablaContenedor").on("click", ".visibilidad", function(){

    if($(this).val()==0) {
        $(this).attr('value',1);
        $(this).parents("tr").children("td").children(".oculto").attr('value',1);
    } else {
        $(this).attr('value',0);
        $(this).parents("tr").children("td").children(".oculto").attr('value',0);
    }

})