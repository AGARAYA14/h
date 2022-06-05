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

/*=============================================
ELIMINAR PERFIL
=============================================*/
$(".tablas").on("click", ".btnEliminarPerfil", function(){

let titulo = '¿Está seguro de borrar el perfil?';
let texto = '¡Si no lo está puede cancelar la acción!';
let confirmar = 'Si, borrar perfil!';
let ruta='perfil';
let id='Perfil';
let idmenu = $(this).attr("idperfil");

alertas(titulo,texto,confirmar,ruta,id,idmenu);

})

/*=============================================
ACTIVAR PERFIL
=============================================*/
$(".tablas").on("click", ".btnActivarPerfil", function(){

	let idperfil = $(this).attr("idperfil");
	let estadoPerfil = $(this).attr("estado");

  //var valor = $(this).parents("tr").find("td").eq(2).html();
  var valor = $(this).parents("tr").children("td").children("span").attr("estado");
  //console.log(valor);



	var datos = new FormData();
 	datos.append("PerfilID", idperfil);
  	//datos.append("activarUsuario", estadoUsuario);

  	$.ajax({

	  url:"ajax/perfil.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      }

  	});


			if(valor == 0)
      		{
      			$(this).parents("tr").children("td").children("span").removeClass('label label-danger');
      			$(this).parents("tr").children("td").children("span").addClass('label label-success');
      			$(this).parents("tr").children("td").children("span").html('ACTIVADO');
      			$(this).parents("tr").children("td").children("span").attr('estado',1);

  			}else{
      			$(this).parents("tr").children("td").children("span").removeClass('label label-success');
      			$(this).parents("tr").children("td").children("span").addClass('label label-danger');
      			$(this).parents("tr").children("td").children("span").html('DESACTIVADO');
      			$(this).parents("tr").children("td").children("span").attr('estado',0);
		  		}


})


/*=============================================
ASIGNAR PERMISOS PERFIL
=============================================*/
$(".tablas").on("click", ".btnAsignarPerfil", function(){
  let permisos_b = $("#origen");
  let permisos_a = $("#destino");


  permisos_a.find('option').remove();
  permisos_b.find('option').remove();

  let idperfil = $(this).attr("idperfil");

      /*=============================================
      TRAER LOS PERMISOS ASIGNADOS
      =============================================*/
        let datos = new FormData();
        datos.append("idperfil_asignar", idperfil);
        //console.log(datos);
        $.ajax({
            url: "ajax/perfil.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success: function(respuesta)
            {

            //console.log(respuesta);
      /*
            respuesta.forEach( function(v, i, array) 
            {
            $("#destino").append('<option value="'+v[1]+'">'+v[0]+'</option>');
            });
      */
              $(respuesta).each(function(i, v)// indice, valor
              { 
                  permisos_a.append('<option value="' + v.idrol + '">' + v.rol + '</option>');
              });


            }

        })
    /*=============================================
    TRAER LOS PERMISOS PENDIENTES
    =============================================*/
      let datos2 = new FormData();
      datos2.append("idperfil_pendiente", idperfil);
      //console.log(datos);
      $.ajax({
          url: "ajax/perfil.ajax.php",
          method: "POST",
          data: datos2,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(r)
          {
            //console.log(r);
            $(r).each(function(i, v)// indice, valor
            { 
                permisos_b.append('<option value="' + v.idrol + '">' + v.rol + '</option>');
            });

            $("#idPerfilp").val(idperfil);
          }

            })

    $('.pasar').click(function() 
      { 
        return !$('#origen option:selected').remove().appendTo('#destino'); 
      });  


    $('.quitar').click(function() 
      { 
        return !$('#destino option:selected').remove().appendTo('#origen'); 
      });

    $('.pasartodos').click(function() 
      { 
        $('#origen option').each(function() 
        { 
          $(this).remove().appendTo('#destino'); 
        }); 
      });

    $('.quitartodos').click(function() 
      { 
        $('#destino option').each(function() 
        { 
          $(this).remove().appendTo('#origen'); 
        });
      });

    $('.guardarpermisos').click(function() 
      { 
        $('#destino option').prop('selected', 'selected'); 
      });


})


/*=============================================
ASIGNAR MENU PERFIL
=============================================*/
$(".tablas").on("click", ".btnAsignarMenuPerfil", function(){
  let permisos_b = $("#morigen");
  let permisos_a = $("#mdestino");


  permisos_a.find('option').remove();
  permisos_b.find('option').remove();

  let idperfil = $(this).attr("idperfil");


      /*=============================================
      TRAER LOS MENUS ASIGNADOS
      =============================================*/
        let datosm = new FormData();
        datosm.append("idperfil_asignarm", idperfil);

        $.ajax({
            url: "ajax/perfil.ajax.php",
            method: "POST",
            data: datosm,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success: function(respuesta)
            {
                
              $(respuesta).each(function(i, v)// indice, valor
              { 
                  permisos_a.append('<option value="' + v.idmenu + '">' + v.menu + '</option>');
              });

            }

        })
    /*=============================================
    TRAER LOS MENUS PENDIENTES
    =============================================*/
      let datosm2 = new FormData();
      datosm2.append("idperfil_pendientem", idperfil);
      $.ajax({
          url: "ajax/perfil.ajax.php",
          method: "POST",
          data: datosm2,
          cache: false,
          contentType: false,
          processData: false,
          dataType:"json",
          success: function(r)
          {
            $(r).each(function(i, v)// indice, valor
            { 
                permisos_b.append('<option value="' + v.idmenu + '">' + v.menu + '</option>');
            });

            $("#idPerfilm").val(idperfil);
          }

            })

    $('.mpasar').click(function() 
      { 
        return !$('#morigen option:selected').remove().appendTo('#mdestino'); 
      });  


    $('.mquitar').click(function() 
      { 
        return !$('#mdestino option:selected').remove().appendTo('#morigen'); 
      });

    $('.mpasartodos').click(function() 
      { 
        $('#morigen option').each(function() 
        { 
          $(this).remove().appendTo('#mdestino'); 
        }); 
      });

    $('.mquitartodos').click(function() 
      { 
        $('#mdestino option').each(function() 
        { 
          $(this).remove().appendTo('#morigen'); 
        });
      });

    $('.mguardarpermisos').click(function() 
      { 
        $('#mdestino option').prop('selected', 'selected'); 
      });


})









