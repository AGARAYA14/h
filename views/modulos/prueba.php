
<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar PRUEBAS

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar Pruebas</li>

    </ol>

  </section>

  <section class="content">

    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header" style="background:#3c8dbc; color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Modulo</h4>
          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->

          <div class="modal-body">
            <div class="box-body">

              <div class="form-group row">
                <!-- ENTRADA PARA LA DESCRIPCION -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevoModulo" placeholder="Ingresar Modulo" required>
                  </div>
                </div>
                <!-- ENTRADA PARA EL ORDEN -->
                <div class="col-xs-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                    <input type="number" class="form-control input-lg" name="nuevoOrden" placeholder="Ingresar Orden" required>
                  </div>
                </div>
              </div>


                        <?php

                        		if(!empty($_POST))
                        		{

                        			$errores = array();
                        			$NewModulo=limpiar_cadena($_POST["nuevoModulo"]);
                        			$NewOrden=limpiar_cadena($_POST["nuevoOrden"]);

                        			$bl_modulo = var_valida_texto ($NewModulo);
                        			$bl_orden = var_valida_numero ($NewOrden);

                        			if(!$bl_modulo){
                        				$errores[] = "Por favor verifica el modulo";
                        			}

                        			if(!$bl_orden){
                        				$errores[] = "Por favor verifica el orden no parece un número";
                        			}
                        			//var_dump($bl_modulo);
                        			//var_dump($bl_orden);
                        			echo resultBlock($errores);
                            }
                            ?>
            </div>
          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Modulo</button>
          </div>






        </form>
      </div>
    </div>

  </section>

</div>
