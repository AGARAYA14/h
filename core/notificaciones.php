<?php 


class alerta
{


/*=============================================
Toast: Obiene un array es procesado uno por uno.
=============================================*/

public static function toast_varios($titulo,$texto,$tipo=INFO)
  {
    $resultado ='';

    if(count($texto) > 0)
    {
    	$resultado .='<script>';
    	foreach($texto as $msj) {
    		$resultado .=" "."toastr.{$tipo}('{$msj}','{$titulo}',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true });";
    	}
    	$resultado .=  '</script>';
        
    }
    return $resultado;
  }


/*=============================================
Sweet Alert 
=============================================*/
public static function sweet_alert($datos)
{
	switch ($datos['Accion']) {
		
		case SA_CONSULTA:
		// Mensaje con un enlace debajo
			$alerta="<script>
						Swal.fire({
							icon: '".$datos['Tipo']."',
							title: '".$datos['Titulo']."',
							text: '".$datos['Texto']."',
							footer: '<a href>Why do I have this issue?</a>'
							})
					</script>";
			break;

		case EJECUTAR3:
	     // mensaje que desaparece al rato
	       $alerta="<script>
	                Swal.fire({
	                    icon: '".$datos['Tipo']."',
	                    title: '".$datos['Titulo']."',
	                    text: '".$datos['Texto']."',
	                    showConfirmButton: true,
	                    timer: 8000
	                	}).then((result) => { 
		                	window.location = '".$datos['Entidad']."';	
	                		})
	                </script>";
			break;

		case EJECUTAR2:
	     // mensaje que desaparece al rato
	       $alerta="<script>
	                Swal.fire({
	                    icon: '".$datos['Tipo']."',
	                    title: '".$datos['Titulo']."',
	                    text: '".$datos['Texto']."',
	                    showConfirmButton: true,
	                    timer: 18000
	                	}).then((result) => { 
		                	 (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';	
	                		})
	                </script>";
			break;

		case EJECUTAR:
	     // mensaje que desaparece al rato
	       $alerta="<script>
	                Swal.fire({
	                    icon: '".$datos['Tipo']."',
	                    title: '".$datos['Titulo'].$datos['Texto']."',
	                    showConfirmButton: true,
	                    timer: 8000
	                	}).then((result) => { 
		                	 (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';	
	                		})
	                </script>";
			break;
		case SA_ANIMADO:
	       // mensaje que desplaza en css
	       $alerta="<script>
	                Swal.fire({
	                    title: '".$datos['Titulo']."',
	                    icon: '".$datos['Tipo']."',
	                    showClass: {
	                    popup: 'animate__animated animate__fadeInDown'
	                    },
	                    hideClass: {
	                    popup: 'animate__animated animate__fadeOutUp'
	                    }
	                }).then((result) => { 
		                	 (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';	
	                		})
	                </script>";
			break;
		case SA_DOBLE:
	        // mensaje con boton que muestra otro mensaje
	       $alerta="<script>
	                Swal.fire({
	                  title: '".$datos['Titulo']."',
	                  text: '".$datos['Texto']."',
	                  icon: '".$datos['Tipo']."',
	                  showCancelButton: true,
	                  confirmButtonColor: '#3085d6',
	                  cancelButtonColor: '#d33',
	                  confirmButtonText: 'Si, Borrarlo!'
	                }).then((result) => {
	                  if (result.value) {
	                    Swal.fire(
	                      'Deleted!',
	                      'Your file has been deleted.',
	                      'success'
	                    )
	                  }
	                }).then((result) => { 
		                	 (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';	
	                		})
	                </script>";
			break;
		case SA_IMAGEN:
	        // mensaje con imagen, falta ".$datos['Imagen_URL']."
	       $alerta="<script>
	       			Swal.fire({
	                    title: '".$datos['Titulo']."',
	                    text: '".$datos['Texto']."',
	                    imageUrl: 'https://unsplash.it/400/200',
	                    imageWidth: 400,
	                    imageHeight: 200,
	                    imageAlt: 'Custom image',
	                }).then((result) => { 
		                	 (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';	
	                		})
	                </script>";
			break;
		default:
	        // mensaje por default
	       $alerta="<script> Swal.fire('".$datos['Texto']."')</script>";
			break;
	}

	return $alerta;

}

/*=============================================
Toastr 
=============================================*/
public static function toast($datos) {
	/*
		Command: toastr["success"]("llll", "Error")
		toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!')
		toastr.success('Have fun storming the castle!', 'Miracle Max Says')
		toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')
		toastr.remove()
		toastr.clear()
		toastr.success('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 5001})

		toastr.options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": true,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut"
		}
	 */

	switch ($datos['Accion']) {
		
		case EJECUTAR:
		// Mensaje por default
			$alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true });
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;

		case EJECUTAR3:
		// Mensaje por default
			$alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true });
						window.location = '".$datos['Entidad']."';
					</script>";
			break;

		case TO_EJECUTA:
	     // mensaje sin barra de progreso
	       $alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':false, 'timeOut': '3000', 'closeButton': false,'newestOnTop': true });
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;
		case TO_RIGHT:
	       // mensaje que se posiciona en la parte superior derecha
	       $alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true, 'positionClass': 'toast-bottom-right' });
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;
		case TO_LEFT:
	        // mensaje que se posiciona en la parte superior izquierda
	       $alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true, 'positionClass': 'toast-top-left' });
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;
		case TO_TOP:
	        // mensaje que se posiciona en la parte superior 
	       $alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true, 'positionClass': 'toast-top-full-width' });
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;		

		case TO_BOTTOM:
	        // mensaje que se posiciona en la parte inferior
	       $alerta="<script>
						toastr.".$datos['Tipo']."('".$datos['Texto']."','".$datos['Titulo']."',{ 'progressBar':true, 'timeOut': '3000', 'closeButton': true,'newestOnTop': true, 'positionClass': 'toast-bottom-full-width' });
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;
		default:
	        // mensaje por default
	       $alerta="<script> toastr.success('".$datos['Texto']."', '".$datos['Titulo']."'); </script>";

			break;
	}


	return $alerta;

}


/*=============================================
Notify
=============================================*/
public static function notify($datos) {
	/*
	$(".pos-demo").notify( "I'm to the right of this box",  { position:"right" });
	{ position:"top left" }
	{ position:"top right" }
	{ position:"top center" }
	{ position:"right middle" }
	{ position:"bottom right" }
	{ position:"bottom left" }
	{ position:"left middle" }
	 */

	switch ($datos['Accion']) {

		case EJECUTAR:
		// Por default llamara esta accion
			$alerta="<script> $.notify('".$datos['Texto']."', '".$datos['Tipo']."'); 
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;

		case NOT_OK:
		// Cuando sea exitoso
			$alerta="<script> $.notify('".$datos['Texto']."', 'success'); 
						(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
					</script>";
			break;

		case NOT_INFO:
	     // cuando sea informativo
	       $alerta="<script> $.notify('".$datos['Texto']."', 'info'); 
	    			   (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
	       			</script>";
			break;
		case NOT_WARN:
	       // cuando sea un warning
	       $alerta="<script> $.notify('".$datos['Texto']."', 'warn'); 
	    			   (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
	       			</script>";
			break;
		case NOT_ERROR:
	        // cuando sea un error 
	       $alerta="<script> $.notify('".$datos['Texto']."', 'error'); 
	    			   (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
	       			</script>";
			break;
		case NOT_SELECTOR:
	        // con selector, falta '".$datos['Selector']."'
	       $alerta="<script>
				       $('".$datos['Selector']."').notify(
				       '".$datos['Texto']."' , 'info', 
				       { position:'".$datos['Posicion']."' }
				       );
				    	(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';

					</script>";
			break;		

		case NOT_POSICION:
	        // ubicacion del mensaje
	       $alerta="<script> $.notify('".$datos['Texto']."', '".$datos['Tipo']."' , { position:'".$datos['Posicion']."' }); 
	    			   (window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
	       			</script>";
			break;

		default:
	        // mensaje por default
	       $alerta="<script> $.notify('".$datos['Texto']."');	</script>";
			break;
	}


	return $alerta;


}

/*=============================================
Notie
=============================================*/
public static function notie($datos) {

	/*
		notie.alert({
		type: Number|String, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
		text: String,
		stay: Boolean, // optional, default = false
		time: Number, // optional, default = 3, minimum = 1,
		position: String // optional, default = 'top', enum: ['top', 'bottom']
		})
	 */

	switch ($datos['Accion']) {
			case EJECUTAR:
			// Mensaje por default
				$alerta="<script> 	                    
							notie.alert({
								type: '".$datos['Tipo']."',
								text: '".$datos['Texto']."',
								time: 10
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
		                 </script>";
				break;

			case NOTI_OK:
			// Mensaje exitoso
				$alerta="<script> 	                    
							notie.alert({
								type: 1,
								text: '".$datos['Texto']."',
								time: 10
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
		                 </script>";
				break;

			case NOTI_WARN:
		     // mensaje de warning
		       $alerta="<script> 						
		       				notie.alert({
								type: 2,
								text: '".$datos['Texto']."',
								time: 10
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
							</script>";
				break;
			case NOTI_ERROR:
		       // mensaje error
		       $alerta="<script> 						
		       				notie.alert({
								type: 3,
								text: '".$datos['Texto']."',
								time: 10
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
							</script>";
				break;
			case NOTI_INFO:
		        // mensaje informativo
		       $alerta="<script> 						
		       				notie.alert({
								type: 4,
								text: '".$datos['Texto']."',
								time: 10
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
							</script>";
				break;
			case NOTI_NEUTRAL:
		        // mensaje neutral
		       $alerta="<script> 						
		       				notie.alert({
								type: 5,
								text: '".$datos['Texto']."',
								time: 10
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
							</script>";
				break;	

			case NOTI_POSICION:
		        // mensaje con la posicion superior o inferior
		       $alerta="<script> 						
		       				notie.alert({
								type: 5,
								text: '".$datos['Texto']."',
								time: 10,
								position:'".$datos['Posicion']."'
								}); 
								(window.history.replaceState) ? ".JS_SAME_PAGE." : window.location = '".$datos['Entidad']."';
							</script>";
				break;

			default:
		        // mensaje por default
		       $alerta="<script> notie.alert({ text: '".$datos['Texto']."' }); </script>";
				break;
		}

		return $alerta;
	}


}














