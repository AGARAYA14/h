/*=============================================
	GLOBALES TIPOS DE ARCHIVOS
	IMAGENES: JPEG JPG PNG GIF // DOCUMENTOS: .docx .docm .xlsx .xlsm .pptx .pptm .PDF // 	IMPORTACION: .xlsx .xlsm
	PLANO: .txt .ttx  /// COMPLETO: * + .RAR .ZIP
=============================================*/
const IMAGEN = "IMAGEN";
const DOCUMENTO = "DOCUMENTO";
const IMPORTAR = "IMPORTAR";
const PLANO = "PLANO";
const COMPLETO = "COMPLETO";

/*----------  Variables globales  ----------*/
const perfil_id = document.getElementsByClassName("sperfil")[0].getAttribute("perfil").toString();
const clase_combo = "";
const clase_combo_accion = "scampo";



/*====================================
=         Clase Entidad         	 =
====================================*/
class Entidad {
	constructor(nombre,idvista,tFiltro,idperfil=0)  {
	this.nombre = nombre;
	this.idVista = idvista;
	this.idperfil = idperfil;
	this.e_ajax = "ajax/"+nombre.toLowerCase()+".ajax.php";
	this.bodyFiltro = tFiltro;
	}

	/*----------  Funcion para la tabla  del tipo (Datatable) ----------*/
	getTablaAjax(){
		let url_ajax = "tablas/tabla"+this.nombre+".ajax.php";
		let clase_tabla = ".tabla"+this.nombre;

		return	$(clase_tabla).DataTable({
			"ajax":{
			"url":url_ajax,
			"type": "POST",
			"data": {"idperfil": this.idperfil}	
			}
			});
	}

	/*----------  Funcion para la tabla  del tipo (Datatable) ----------*/
	saveFiltro(filtro,formData){
		let eTabla = ".tabla"+this.nombre;
		let eModalTabla = "#modalfiltro"+this.nombre;
		let url_ajax=this.e_ajax;
		if (filtro) {
			url_ajax +="?op=filtro";
		} else {
			url_ajax +="?op=Sinfiltro";
		}

		$.ajax({
			url: url_ajax,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			dataType:"json",
			success: function(rpsta){
				let f_parametros=[];
				f_parametros.push({"texto": rpsta[0]["texto"],"titulo":rpsta[0]["titulo"]});

				let f_ok = new Notificacion(modulo,rpsta[0]["r"]);
				f_ok.toast(f_parametros);
				$(eTabla).DataTable().ajax.reload();
				$(eModalTabla).modal('hide');
			}
		});

	}

	/*----------  Funcion para devolver los campos del tipo  ----------*/
	getCampos(){

		let arreglo = [];
		let vista_id =this.idVista;

			$.ajax({
			url: this.e_ajax,
			method: "POST",
			data: {vista_id},
			cache: false,
			dataType:"json",
			success: res => {
			//console.log(res);
			$(res).each(function(i,v)// indice, valor
			{ arreglo.push({"campo":v.texto,"sql":v.nombresql,"tipo":v.opcion}); });

			},error : (xhr,status) => {
			console.log('Disculpe, existió un problema');
			console.log(xhr);
			},complete : (xhr, status) => {
			//console.log('Petición realizada');
			}
			});
		return arreglo;	
	}

	/*----------  Funcion para Obtener los registro del filtro de la entidad  ----------*/
	getFiltros (entidad_campos){
			
		let tFiltro = this.bodyFiltro;
		tFiltro.empty();

		let fila          = null;

		let datos_filtro  = new FormData();
		datos_filtro.append("idvista_entidad", this.idVista);
		datos_filtro.append("idusuario", this.idperfil);
		
		$.ajax({
		url: this.e_ajax,
		method: "POST",
		data: datos_filtro,
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json",
		success: function(respuesta){
			let inputFiltro = document.createElement("input");
			inputFiltro.setAttribute("type", "hidden");
			inputFiltro.setAttribute("name", "idFiltro");

			if(Arreglos_Filtro.estaVacio(respuesta)) 
			{
				inputFiltro.setAttribute("value",0);
				tFiltro.append(inputFiltro);
			}
			else {

				inputFiltro.setAttribute("value",respuesta[0]["IDFiltro"]);
				tFiltro.append(inputFiltro);
				//console.log("respuesta", respuesta);
				$(respuesta).each(function(i,v)// indice, valor        
				{ 
					fila="<tr>";
					fila+=`<td><select class="form-control ${clase_combo} ${clase_combo_accion}" name='f_campo[]' style="width: 100%;">${Arreglos_Filtro.campo_filtro(entidad_campos,v.Campo,"sql","campo","tipo")}</select></td>`;
					fila+=`<td><select class="form-control ${clase_combo}" style="width: 100%;" name='f_condicion[]'>${Arreglos_Filtro.campo_filtro(condicionales,v.Condicion,"valor","descripcion")}</select></td>`;
					fila+=`<td><input type='text' class='form-control'  name='f_valor[]' value="${v.Valor}" required></td>`;
					fila+=`<td><select id="f_enlace" class="form-control  ${clase_combo}" name='f_enlace[]'>${Arreglos_Filtro.campo_filtro(enlaces,v.Operador,"valor","descripcion")}</select></td>`;
					fila+=`<td style="display:none;"><input type='hidden' class='form-control'  name='f_opcion[]' value="${Arreglos_Filtro.buscarArray (entidad_campos,v.Campo,"sql","tipo")}" required></td>`;
					fila+=`<td class='text-center'><div class='btn btn-danger BorrarFila'>X</div></td>`;
					fila+="</tr>";
					tFiltro.append(fila);
				});
			}


			} // fin respuesta ajax
		}); // fin ajax
			//console.log("registros", registros);	
	}// Fin funcion

	/*----------  Funcion para Obtener los campos para ser marcados para exportar  ----------*/
	getListaCampos (lista){
	  lista.empty();
	  let etipo = this.nombre;
	  let data = new FormData();
	  data.append("idvista_exportar", this.idVista);

	  $.ajax({
	    url: this.e_ajax,
	    method: "POST",
	    data: data,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",
	    success: function(respuesta){
	      // indice, valor
	      $(respuesta).each(function(i,v) { 
	      lista.append('<label><input type="checkbox" name="'+etipo.toLowerCase()+'_columnas[]" value="' + v.nombresql + '"> ' + v.texto + '</label> </br>');
	      });
	    }

	  })
	}

}
/*====================================
=         Fin  Clase entidad      =
====================================*/

/*====================================
=      Clase Notificacion         =
====================================*/
class Notificacion {

	constructor(entidad,tipo)  {
	this.entidad = entidad;
	this.tipo = tipo;
	}

	/*----------  Funcion para las notificaciones de tipo sweet  ----------*/
	sweet(parametros){

		switch (this.tipo) {
			case "Eliminar":
				let titulo = `¿Está seguro de borrar el ${this.entidad}?`;
				let texto = '¡Si no lo está puede cancelar la acción!';
				let confirmar = `Si, borrar  ${this.entidad}!`;  

                Swal.fire({
                  title: titulo,
                  text: texto,
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: confirmar
                }).then((result) => {
                  if (result.value) {
						window.location = "index.php?ruta="+parametros[0]["ruta"]+"&id"+parametros[0]["entidad"]+"="+parametros[0]["valor"];
                  }
                });			
				break;

			default:
				// statements_def
				break;
		}
		

	}

	/* */
	notify (parametros) {
		switch (this.tipo) {
			case "ErrorSimple":
				$.notify(this.entidad + ": " + parametros[0]["texto"],'error');
				break;
			default:
				// statements_def
				break;
		}
	}


	/* */

	notie (parametros) {
		switch (this.tipo) {
			case "ok" : 
				notie.alert({	type: parametros[0]["texto"],
								text: parametros[0]["texto"],
								time: 10
								}); 
			break;

			case "ok2" : 
			break;

			case "error" : 
			break;
		}


	}	

	/* */

	toast (parametros) {
		switch (this.tipo) {
			case "ok" : 
				toastr.success(parametros[0]["texto"],this.entidad + ": " + parametros[0]["titulo"],{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true });
			break;

			case "ok2" :
				toastr.warning(parametros[0]["texto"],this.entidad + ": " + parametros[0]["titulo"],{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true }); 
			break;

			case "error" : 
				toastr.error(parametros[0]["texto"],this.entidad + ": " + parametros[0]["titulo"],{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true });
			break;

			default:
				toastr.success('Have fun storming the castle!', 'Miracle Max Says');
				break;
		}


	}

}
/*====================================
=         Fin  Clase Notificacion     =
====================================*/

/*====================================
=         Clase Manejo Archivos          =
====================================*/
class funArchivo {
	// funcion para validar el peso del archivo
	static checkPeso (peso,tipo_archivo) {

		let resultado=[];

			switch(tipo_archivo)
			{
				case IMAGEN: 
						// 3 MB
						//if (peso <= 3024000){ resultado=true; } else {resultado=false;}; 
						peso <= 3024000 ?  resultado=[true,0,''] : resultado=[false,3,'MB']; 
				break;
				case DOCUMENTO:
						// 8 MB
						//peso <= 8064000 ?  resultado=true : resultado=false; 
						peso <= 8064000 ?  resultado=[true,0,''] : resultado=[false,8,'MB']; 
				break;
				case IMPORTAR:
						// 8 MB
						peso <= 8064000 ?  resultado=[true,0,''] : resultado=[false,8,'MB']; 
				break;
				case PLANO:
						// 1 MB
						peso <= 1008000 ?  resultado=[true,0,''] : resultado=[false,1,'MB'];  
				break;
				case COMPLETO:
						// 10 MB
						// 
						peso <= 10080000 ?  resultado=[true,0,''] : resultado=[false,10,'MB'];  
				break;
				default:
						resultado=false; 
				break;	
			}
			return resultado;
	}

	// funcion para validar el peso del archivo
	static checkTipo (archivo,tipo_archivo){

		let extension_permitida;
		let mensaje;
		let respuesta=[];
		// Evaluar el tipo de archivo
		switch(tipo_archivo){
			case "IMAGEN":
				extension_permitida = /(.jpg|.jpeg|.png|.gif)$/i;
				mensaje ='Por favor cargar un archivo de imagen válido como jpg,jpeg, png o gif ';
			break;
			case "DOCUMENTO":
				extension_permitida = /(.docx|.docm|.xlsx|.xlsm|.pptx|.pptm|.pdf|.xls)$/i;
				mensaje ='Por favor cargar un archivo de documento válido como docx, xlsx, pptx o pdf ';
			break;
			case "IMPORTAR":
				extension_permitida = /(.xlsx|.xlsm|.xls)$/i;
				mensaje ='Por favor cargar un archivo excel válido';
			break;
			case "PLANO":
				extension_permitida = /(.txt|.ttx)$/i;
				mensaje ='Por favor cargar un archivo de texto válido ';
			break;
			case "COMPLETO":
				extension_permitida = /(.jpg|.jpeg|.png|.gif|.docx|.docm|.xlsm|.xlsx|.xlsm|.pptx|.pptm|.pdf|.txt|.ttx|.zip|.rar|.dll|.ra0|.sql|.7z)$/i;
				mensaje ='Por favor cargar un archivo válido ';
			break;
			default:
				extension_permitida = null;
				mensaje ='Ha subido un archivo incorrecto';
			break;
		}


		if (extension_permitida) 
		{
		   (!extension_permitida.exec(archivo))? respuesta =[false,mensaje] : respuesta =[true,''];	    
		    
		   return respuesta;
		}
	}

	// funcion para marcar todos los checks
	static marcarChecks (){
		$("#checkTodos").change(function () {
      	$("input:checkbox").prop('checked', $(this).prop("checked"));
  		});
	}
}
/*====================================
=    Fin  Manejo Archivos      =
====================================*/


/*====================================
=      Clase Archivos         =
====================================*/
class Archivo {

	constructor(archivo,operacion)  {
	this.archivo = archivo;
	this.tipoFile = archivo.value;
	this.pesoFile = archivo.files[0].size;
	this.operacion= operacion;
	this.tipoVal = funArchivo.checkTipo (archivo.value,operacion);
	this.pesoVal= funArchivo.checkPeso(Number(archivo.files[0].size),operacion);
	}

	/*----------  Funcion para poner alerta.  ----------*/
	mostrarAlerta (){
		$(".f_error_peso").remove();
        $(".f_error_archivo").remove();

          //Poner alerta
          // Validar tipo de archivo
          if(!this.tipoVal[0])
          {
            $("#mensaje_error_archivo").before('<div class="alert alert-warning f_error_archivo text-center">'+this.tipoVal[1]+'</div>');
            $('.btn-importar').prop('disabled', true);
          } 
          else
            { 
            	$(".f_error_archivo").remove(); 
				// Validar el peso de archivo
					if(!this.pesoVal[0])
					{
						$("#mensaje_error_archivo").before('<div class="alert alert-warning f_error_peso text-center">El archivo excede el peso permitido es '+this.pesoVal[1]+' '+this.pesoVal[2]+'</div>');
						$('.btn-importar').prop('disabled', true);
					} else
					{ 
						$(".f_error_peso").remove(); 
						$('.btn-importar').prop('disabled', false);
					}

            }
	}




}
/*====================================
=         Fin  Clase Archivos     =
====================================*/







/*
	var boton = document.getElementsByClassName("nav-link");
console.log(boton);
	// Click
	boton.addEventListener('click', function(){
		boton.className += " active";
		console.log(this);

		//active
	});

*/


/*=============================================
CAMBIO EN EL CHECK
=============================================*/

function fcheck (number) {
    if(number==1){
    return "checked";
    }
    else{
        return "";
    }
}





/*=============================================
VALIDAR PESO
=============================================*/

function validar_archivo_peso (peso,tipo_archivo) {

let resultado=[];

	switch(tipo_archivo)
	{
		case IMAGEN: 
				// 3 MB
				//if (peso <= 3024000){ resultado=true; } else {resultado=false;}; 
				peso <= 3024000 ?  resultado=[true,0,''] : resultado=[false,3,'MB']; 
		break;
		case DOCUMENTO:
				// 8 MB
				//peso <= 8064000 ?  resultado=true : resultado=false; 
				peso <= 8064000 ?  resultado=[true,0,''] : resultado=[false,8,'MB']; 
		break;
		case IMPORTAR:
				// 8 MB
				peso <= 8064000 ?  resultado=[true,0,''] : resultado=[false,8,'MB']; 
		break;
		case PLANO:
				// 1 MB
				peso <= 1008000 ?  resultado=[true,0,''] : resultado=[false,1,'MB'];  
		break;
		case COMPLETO:
				// 10 MB
				// 
				peso <= 10080000 ?  resultado=[true,0,''] : resultado=[false,10,'MB'];  
		break;
		default:
				resultado=false; 
		break;	
	}

	return resultado;
}

/*=============================================
ENVIAR ARCHIVO
=============================================*/

function Validar_Archivo(archivo,tipo_archivo){

	/**
	 IMAGENES: JPEG JPG PNG GIF
	 DOCUMENTOS: .docx .docm .xlsx .xlsm .pptx .pptm
	 IMPORTACION: .xlsx .xlsm
	 PLANO: .txt .ttx 
	 COMPLETO: * + .RAR .ZIP
	 */
let extension_permitida;
let mensaje;
let respuesta=[];

switch(tipo_archivo){
	case "IMAGEN":
		extension_permitida = /(.jpg|.jpeg|.png|.gif)$/i;
		mensaje ='Por favor cargar un archivo de imagen válido como jpg,jpeg, png o gif ';
	break;
	case "DOCUMENTO":
		extension_permitida = /(.docx|.docm|.xlsx|.xlsm|.pptx|.pptm|.pdf|.xls)$/i;
		mensaje ='Por favor cargar un archivo de documento válido como docx, xlsx, pptx o pdf ';
	break;
	case "IMPORTAR":
		extension_permitida = /(.xlsx|.xlsm|.xls)$/i;
		mensaje ='Por favor cargar un archivo excel válido';
	break;
	case "PLANO":
		extension_permitida = /(.txt|.ttx)$/i;
		mensaje ='Por favor cargar un archivo de texto válido ';
	break;
	case "COMPLETO":
		extension_permitida = /(.jpg|.jpeg|.png|.gif|.docx|.docm|.xlsm|.xlsx|.xlsm|.pptx|.pptm|.pdf|.txt|.ttx|.zip|.rar|.dll|.ra0|.sql|.7z)$/i;
		mensaje ='Por favor cargar un archivo válido ';
	break;
	default:
		extension_permitida = null;
		mensaje ='Ha subido un archivo incorrecto';
	break;
}


if (extension_permitida) 
{

    if(!extension_permitida.exec(archivo))
    {
        //alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        //fileInput.value = '';
        //return false;
        respuesta =[false,mensaje];
    }else{
        //Image preview
        /*
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
          */
          respuesta =[true,''];
        }
    
        return respuesta;
}


// --------------------------------------------------------



 
// --------------------------------------------------------------------

}

