
/*----------  Constante de los enlaces  ----------*/
const enlaces = [
    {valor: 'Y', descripcion:"Y"},
    {valor: 'O', descripcion:"O"},
    {valor: '0', descripcion:" "}
    ];
    /*----------  Constante de las condiciones  ----------*/
    const condicionales = [
            {valor: '=', descripcion:"Es igual a"},
            {valor: '>', descripcion:"Es mayor que"},
            {valor: '>=', descripcion:"Es mayor igual que"},
            {valor: '<', descripcion:"Es menor que"},
            {valor: '<=', descripcion:"Es menor igual que"},
            {valor: 'like', descripcion:"Es Como"},
            {valor: '<>', descripcion:"Es diferente de"}
    ];
    
    /*====================================
    =         Clase Columnas          =
    ====================================*/
    class Columna {
        // Evento para ocultar y mostrar
        static ocultarMostrar (tabla,obj) {
            //e.preventDefault();
            var column = tabla.column(obj.data("column"));
            obj.toggleClass('active');
            column.visible(!column.visible());
        }
    
    }
    /*====================================
    =    Fin  Clase Columnas        =
    ====================================*/
    
    
    /*====================================
    =      Clase MetodosArray            =
    ====================================*/
    class Arreglos_Filtro {
        // Buscar un elemento en array
        static buscarArray (arr,valor, buscar, entregar) {
            let rspta = null;
            let busqueda_campo = arr.filter((a) => a[buscar] == valor);
            rspta = busqueda_campo[0][entregar];
            return rspta;
        }
    
        //Funcion para encontrar el tipo de dato 
        static campo_filtro (arr,campo,buscar,entregar,tipo=null) {
            //console.log("campo", campo.length);
            let resultado = '';
            let filtraCampos;
    
          if (tipo==null)
          {
               if (campo==" ") {
                  resultado= `<option value="0" selected="selected">${campo}</option>`;
                  filtraCampos = arr.filter( d => { return  d[buscar] != "0"; });
                } else {
                  resultado= `<option value="${campo}" selected="selected">${Arreglos_Filtro.buscarArray (arr,campo,buscar,entregar)}</option>`;
                  filtraCampos = arr.filter( d => { return  d[buscar].toLowerCase() != campo.toLowerCase(); });
                }
          } else {
                  resultado= `<option tipo_opcion="${Arreglos_Filtro.buscarArray (arr,campo,buscar,tipo)}" value="${campo}" selected="selected">${Arreglos_Filtro.buscarArray (arr,campo,buscar,entregar)}</option>`;
                  filtraCampos = arr.filter( d => { return  d[buscar].toLowerCase() != campo.toLowerCase(); });
          }
    
          // Recorrer el resto de campos
          filtraCampos.forEach( function(element, index) 
          {
    
          if (tipo==null)
          {
                if (element[entregar]==element[buscar]) {
                resultado += `<option value="${element[entregar]}">${element[entregar]}</option>`;
                } else {
                resultado += `<option value="${element[buscar]}">${element[entregar]}</option>`;
                }
          }
          else {
                resultado += `<option tipo_opcion="${element[tipo]}" value="${element[buscar]}">${element[entregar]}</option>`;
          }
    
    
    
          });
    
          return resultado;
    
         }
    
        //Funcion para agregar una fila nueva en el filtro
        static nuevo_filtro (arr,tbodyFiltro) {
    
            let nueva_fila ="<tr>";
            nueva_fila+=`<td><select class='form-control ${clase_combo} ${clase_combo_accion}' name='f_campo[]' style='width: 100%;'>${Arreglos_Filtro.getCombo_array(arr,"sql","campo","tipo")}</select></td>`;
            nueva_fila+=`<td><select class="form-control ${clase_combo} style="width: 100%;" name='f_condicion[]'>${Arreglos_Filtro.getCombo_array(condicionales,"valor","descripcion")}</select></td>`;
            nueva_fila+=`<td><input type='text' class='form-control'  name='f_valor[]' required></td>`;
            nueva_fila+=`<td><select id="f_enlace" class="form-control ${clase_combo}" name='f_enlace[]'>${Arreglos_Filtro.getCombo_array(enlaces,"valor","descripcion")}</select></td>`;
            nueva_fila+=`<td style="display:none;"><input type='hidden' class='form-control'  name='f_opcion[]' value="Texto" required></td>`;
            nueva_fila+=`<td class='text-center'><div class='btn btn-danger BorrarFila'>X</div></td>`;
            nueva_fila+="</tr>";
    
            tbodyFiltro.append(nueva_fila);
    
        }
    
        // Funcion para buscar en el array y completar el combo de una fila nueva
        static getCombo_array (arr,i,valor,tipo=null) {
           let rspta = '';
    
           arr.forEach( (element,index) => {
                    (tipo==null)? rspta += `<option value="${element[i]}">${element[valor]}</option>` 
                    : rspta += `<option tipo_opcion="${element[tipo]}" value="${element[i]}">${element[valor]}</option>`;
              });
    
              return rspta;
        }
    
        // Funcion para buscar en el array y completar el combo de una fila nueva
        static changeCampo_combo (event) {
            let OpcionSeleccionadaCombo=event.target;
            let Input_a_Modificar =OpcionSeleccionadaCombo.parentNode.nextSibling.nextSibling.children[0];
            let InputHidden_a_Modificar =OpcionSeleccionadaCombo.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.children[0];
            //console.log("InputHidden_a_Modificar", InputHidden_a_Modificar);
            let TipoDatoCombo = OpcionSeleccionadaCombo.options[OpcionSeleccionadaCombo.selectedIndex].getAttribute("tipo_opcion");
            
            let caja = new TipoInput (TipoDatoCombo);
            caja.verTipoDato(Input_a_Modificar);
            InputHidden_a_Modificar.value=TipoDatoCombo;
        }
    
        // Validar que el último enlace esta vacio
        static esFiltroValido (filtro) {
            let flag=null
            // validar si el último esta vacio
            let rspta = filtro.find( function (e, i) {
                if (e.value==0 && i== filtro.length - 1) {
                     return true;
                    
                } else { return false;}
            });
    
            flag = rspta?  true :  false;
            // validar que otro no esten vacios
            for (let i = 0; i < filtro.length; i++) {
    
                if (filtro[i].value == 0) {
                    if (filtro.length - 1 != i) { flag = false; }
                }
            }
            
            return flag;
    
        }
    
        // Es array vacio
        static estaVacio (obj) {
            if(Object.entries(obj).length === 0) { return true;} else {return false;}
        }
    
    }
    /*====================================
    =    Fin  Clase MetodosArray        =
    ====================================*/
    
    
    /*====================================
    =            Clase Input            =
    ====================================*/
    class TipoInput{
         constructor(nombre)  {
              this.nombre = nombre;
              this.min = 1;
              this.max = 999999;
              this.minimo = 1;
              this.maximo = 100;
              this.min_fecha = "01/01/2016";
              this.max_fecha = "01/01/2050";
         }
    
          verTipoDato(input) 
          {
              
             input.removeAttribute("minlength"); 
             input.removeAttribute("maxlength");
             input.removeAttribute("min");
             input.removeAttribute("max");
             input.removeAttribute("step");
             
             switch (this.nombre) {
               case "Texto": 
                 input.type='text'; 
                 input.setAttribute("minlength",this.minimo); 
                 input.setAttribute("maxlength",this.maximo);
               break;
               case "Entero": 
                 input.type='number'; 
                 input.setAttribute("min",this.min); 
                 input.setAttribute("max",this.max);
               break;
               case "Decimal": 
                 input.type='number'; 
                 input.setAttribute("min",this.min); 
                 input.setAttribute("max",this.max);
                 input.setAttribute("step","any");
               break;
               case "Fecha": 
                 input.type='date';
                 input.setAttribute("min",this.min_fecha); 
                 input.setAttribute("max",this.max_fecha);
               break;
               case "Imagen": 
                  input.type='text'; 
               break;
               case "Boolean": 
                  input.type='checkbox'; 
               break;
               default: 
                 input.type='text';
                 input.setAttribute("minlength",this.minimo);  
                 input.setAttribute("maxlength",this.maximo);
               break;
             }
    
         }
    }
    /*====================================
    =         Fin  Clase Input           =
    ====================================*/


/*=============================================
 //iCheck for checkbox and radio inputs
=============================================*/

$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass   : 'iradio_minimal-blue'
})