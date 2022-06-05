/*=============================================
EDITAR MENU
=============================================*/
$(".tablas").on("click", ".btnModificarMenu", function(){

	let idmenu = $(this).attr("idmenu");
	//console.log(idmenu);
	let datos = new FormData();
	datos.append("idmenu", idmenu);
	//console.log(datos);
	$.ajax({
		url: "ajax/menu.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
		//console.log(respuesta);

			/*=============================================
			TRAEMOS EL MODULO
			=============================================*/
			//console.log(respuesta["idmodulo"]);
			if(respuesta["idmodulo"] != 0)
			{
			
				var datosModulo = new FormData();
				datosModulo.append("idmodulo", respuesta["idmodulo"]);
				//console.log(datosModulo);

				$.ajax({

						url:"ajax/modulo.ajax.php",
						method: "POST",
						data: datosModulo,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(r){
							//console.log(r);	
							
							$(".modificarModulo").html(r["modulo"]);
							$(".modificarModulo").val(r["pkid"]);
						}

					})

			}else{

				$(".modificarModulo").html("SIN MENU");

			}
			/*=============================================
			TRAEMOS EL CONTENEDOR VISTA
			=============================================*/
			//console.log(respuesta["idmodulo"]);
			if(respuesta["idcontenedor"] != 0)
			{
			
				var datosContenedor = new FormData();
				datosContenedor.append("idcontenedor", respuesta["idcontenedor"]);
				//console.log(datosModulo);

				$.ajax({

						url:"ajax/contenedor.ajax.php",
						method: "POST",
						data: datosContenedor,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(r){
							//console.log(r);	
							
							$(".modificarContenedor").html(r["Configuracion"]);
							$(".modificarContenedor").val(r["pkid"]);
						}

					})

			}else{
				$(".modificarContenedor").html("SIN CONTENEDOR");

			}

     		$("#modificarMenu").val(respuesta["nombre"]);
     		$("#modificarLink").val(respuesta["link"]);
     		$("#modificarIcono").val(respuesta["icono_clase"]);
     		$("#modificarDescripcion").val(respuesta["descripcion"]);
     		$("#idMenu").val(respuesta["pkid"]);
     	}

	})


})

/*=============================================
ELIMINAR MENU
=============================================*/
$(".tablas").on("click", ".btnEliminarMenu", function(){

let titulo = '¿Está seguro de borrar el menú?';
let texto = '¡Si no lo está puede cancelar la acción!';
let confirmar = 'Si, borrar menú!';
let ruta='menu';
let id='Menu';
let idmenu = $(this).attr("idmenu");

alertas(titulo,texto,confirmar,ruta,id,idmenu)

})



/*=============================================
EXPORTAR MENU
=============================================*/
$(".box-header").on("click", ".btnExportarMenu", function(){

	let idmenuvista = $(this).attr("idmenuvista");
	let permisos_a = $("#Lista_Campos");
	permisos_a.empty();

	let datos2 = new FormData();
	datos2.append("idmenuvista", idmenuvista);
	//console.log(datos);
	$.ajax({
		url: "ajax/menu.ajax.php",
		method: "POST",
      	data: datos2,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){

		console.log(respuesta);

              $(respuesta).each(function(i, v)// indice, valor
              { 
                  permisos_a.append('<label><input type="checkbox" name="menu_columnas[]" value="' + v.nombresql + '">' + v.texto + '</label> </br>');
              });

     	}

	})


})


