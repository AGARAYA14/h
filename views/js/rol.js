/*=============================================
BUSQUEDA DE TIPO
=============================================*/


	//let datos1 = new FormData();
$(function() {
$('#nuevoTipo').autocomplete({


			
	//let datos = new FormData();
	//datos1.append("B_Tipo", request.term);

			source: function(request, response){
				$.ajax({
/*					
					url:"ajax/rol.ajax.php",
					  method: "POST",
				      data: B_Tipo:request.term,
				      cache: false,
				     contentType: false,
				     processData: false,
					dataType:"json",
*/
					
				
					url:"ajax/rol.ajax.php",
					dataType:"json",
					data:{B_Tipo:request.term},

					success: function(r){
						response(r);
						//console.log(r);
					}
 
				});
			},
			minLength: 2,

        select: function( event, ui ) {
            event.preventDefault();
            $("#nuevoTipo").val(ui.item.id);
        }

/*
			select: function(event,ui){
				alert("Selecciono: "+ ui.item.label);
			}
 */     
    
		});
 
});


/*=============================================
EDITAR PERFIL
=============================================*/
$(".tablas").on("click", ".btnModificarPerfil", function(){

	let idperfil = $(this).attr("idperfil");
	//console.log(idmenu);
	let datos = new FormData();
	datos.append("idperfil", idperfil);
	//console.log(datos);
	$.ajax({
		  url: "ajax/perfil.ajax.php",
		  method: "POST",
	      data: datos,
	      cache: false,
	     contentType: false,
	     processData: false,
	     dataType:"json",
     	success: function(respuesta){
		//console.log(respuesta);


     		$("#modificarCodigo").val(respuesta["codigo"]);
     		$("#modificarPerfil").val(respuesta["perfil"]);

     		if(respuesta["activo"]==1)
        {
			   //$("#modificarEstado").prop('checked', true);
			   $("#modificarEstado").iCheck('check');
     		}else 
        {
     			$("#modificarEstado").iCheck('uncheck');
     			//$("#modificarEstado").prop('checked', false);
     		}

     		$("#idPerfil").val(respuesta["pkid"]);

     	}

	})


})
