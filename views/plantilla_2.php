<?php 
/* session_start();
// Recoger los parametros de la base de datos
$parametros = ControladorParametros::ctrParametros();
$paginas = ControladorParametros::ctrPaginas();
 */

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title> <?php echo "ALEX SOPORTE";//TITULO; ?> </title>
  

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- icono -->
  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

  <!--=====================================
  VÍNCULOS CSS
  ======================================-->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" >

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/d8eaf9e37f.js" crossorigin="anonymous"></script>

   <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Theme style AdmninLTE -->
<link rel="stylesheet" href="vistas/css/plugins/adminlte.min.css">

    <!-- DataTables -->
  <link rel="stylesheet" href="vistas/css/plugins/dataTables.bootstrap4.min.css"> 
  <link rel="stylesheet" href="vistas/css/plugins/responsive.bootstrap.min.css">

  <!-- Bootstrap Color Picker -->
   <link rel="stylesheet" href="vistas/css/plugins/bootstrap-colorpicker.min.css">

  <!-- iCheck -->
    <link rel="stylesheet" href="vistas/css/plugins/iCheck-flat-blue.css">  

    <!-- Pano -->
  <link rel="stylesheet" href="vistas/css/plugins/jquery.pano.css">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="vistas/css/plugins/bootstrap-datepicker.standalone.min.css">

   <!-- fullCalendar -->
  <link rel="stylesheet" href="vistas/css/plugins/fullcalendar.min.css">

  <!-- Morris chart -->
    <link rel="stylesheet" href="vistas/css/plugins/morris.css">

     <!-- GENERAL -->
    <link rel="stylesheet" href="vistas/css/general.css">

<!-- Seccion para plugins adicionales -->

<!-- SELECT2 -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
 -->
  <link rel="stylesheet" href="vistas/css/plugins/select2.min.css">
  <link rel="stylesheet" href="vistas/css/plugins/select2-bootstrap4.min.css">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->

<!-- Alertas Notie -->
  <link rel="stylesheet" href="vistas/css/plugins/notie.min.css"> 
  <!-- Alertas Toast -->
  <link rel="stylesheet" href="vistas/css/plugins/toastr.min.css"> 
  <!--=====================================
  VÍNCULOS JAVASCRIPT
  ======================================-->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> -->


  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  
  <!-- AdminLTE App -->
  <script src="vistas/js/plugins/adminlte.min.js"></script>

  <!-- DataTables 
  https://datatables.net/-->
    <script src="vistas/js/plugins/jquery.dataTables.min.js"></script>
    <script src="vistas/js/plugins/dataTables.bootstrap4.min.js"></script> 
  <script src="vistas/js/plugins/dataTables.responsive.min.js"></script>
    <script src="vistas/js/plugins/responsive.bootstrap.min.js"></script> 
<script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script> 


    <!-- SWEET ALERT 2 -->  
  <!-- https://sweetalert2.github.io/ -->
  <script src="vistas/js/plugins/sweetalert2.all.js"></script>

  <!-- CKEDITOR -->
  <!-- https://ckeditor.com/ckeditor-5/#classic -->
  <script src="vistas/js/plugins/ckeditor.js"></script>

  <!-- bootstrap color picker 
  https://farbelous.github.io/bootstrap-colorpicker/v2/-->
    <script src="vistas/js/plugins/bootstrap-colorpicker.min.js"></script>

    <!-- iCheck -->
  <!-- http://icheck.fronteed.com/ -->
  <script src="vistas/js/plugins/icheck.min.js"></script>

  <!-- Pano -->
  <!-- https://www.jqueryscript.net/other/360-Degree-Panoramic-Image-Viewer-with-jQuery-Pano.html -->
  <script src="vistas/js/plugins/jquery.pano.js"></script>

  <!-- bootstrap datepicker -->
  <!-- https://bootstrap-datepicker.readthedocs.io/en/latest/ -->
  <script src="vistas/js/plugins/bootstrap-datepicker.min.js"></script>

  <!-- fullCalendar -->
  <!-- https://momentjs.com/ -->
  <script src="vistas/js/plugins/moment.js"></script>
  <!-- https://fullcalendar.io/docs/background-events-demo -->  
  <script src="vistas/js/plugins/fullcalendar.min.js"></script>

  <!-- Morris.js charts -->
  <!-- https://morrisjs.github.io/morris.js/ -->
  <script src="vistas/js/plugins/raphael-min.js"></script>
  <script src="vistas/js/plugins/morris.min.js"></script>

<!-- ultimossss -->
<script src="vistas/js/plugins/select2.full.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>  
<!-- Bootstrap 4 -->
<!-- <script src="vistas/js/plugins/bootstrap.bundle.min.js"></script> -->

  <!-- Alertas Notie -->
  <script src="vistas/js/plugins/notie.min.js"></script>

  <!-- Alertas Notify -->
  <script src="vistas/js/plugins/notify.min.js"></script>

  <!-- Alertas Toast -->
  <script src="vistas/js/plugins/toastr.min.js"></script>




</head>



<?php 
if (!ControladorSesion::checkSession()): include "paginas/login.php";
else:
?>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <?php 

    ControladorSesion::validaTiempoSession();

    $GLOBALS['roles'] = ControladorContenedorVista::ctrObtenerRolesGeneralesPerfil($_SESSION["idperfil"]);

    ControladorParametros::render_pagina('header');
    ControladorParametros::render_pagina('menu');

    /*=============================================
    Navagación de páginas
    =============================================*/
    if(isset($_GET["ruta"]))
    {
        if(in_array($_GET["ruta"],$paginas)) : ControladorParametros::render_pagina($_GET["ruta"]);

        else: ControladorParametros::render_pagina('error404'); endif; 

    }
    else{ ControladorParametros::render_pagina('inicio');}


    ControladorParametros::render_pagina('footer');

    ?>
  </div>

<script src="vistas/js/general.js"></script>

<script src="vistas/js/plantilla.js"></script>

<script src="vistas/js/usuarios.js"></script>

<!-- <script src="vistas/js/categorias.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/reportes.js"></script> -->

<script src="vistas/js/modulo.js"></script>
<script src="vistas/js/menu.js"></script>
<script src="vistas/js/perfil.js"></script>
<script src="vistas/js/rol.js"></script>
<script src="vistas/js/usuario.js"></script>
<script src="vistas/js/contenedor.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>

<?php endif ?>
</html>
