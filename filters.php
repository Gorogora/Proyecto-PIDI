<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Starter</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-blue.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" >  
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPAL</li>
        <!-- Optionally, you can add icons to the links -->
        <li><a href="index.php"><i class="fa fa-area-chart"></i> <span>Estadísticas</span></a></li>
        <li class="active"><a href="#"><i class="fa fa-filter"></i> <span>Filtros</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Filtrado de tweets
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
    
    <div id="alert"></div>

		<!-- Filtros -->
		<div class="box box-primary">
			<div class="box-header with-border">
        <h3 class="box-title">Filtros</h3>
      </div>	
      <!-- /.box-header -->
      <form role="form">
			  <div class="box-body">  
          <div class="row">
            <div class="col-md-12">
              <!-- Seleccionar colección sobre la que se quieren aplicar los filtros-->
              <div class="form-group">
                  <label for="selectColeccion" class="col-md-3 control-label">Selecciona una colección</label>
                  <div class="col-md-8">
                    <select class="form-control" id="selectColeccion" name="selectColeccion" onchange="filtrosColeccion($('#selectColeccion').val());return false;"></select>
                  </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <br>

          <div class="row">
            <div class="col-md-6">
              <!-- Filtrado por rango de fechas--> 
              <div class="form-group">       
                <label for="inputDateIni">Fecha inicio:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control" id="inputDateIni" >
                </div>
                <!-- /.input group -->
              </div>
              <!-- ./form-group -->
              <br>

              <!-- Filtrado por idioma -->
              <div class"form-group">          
                  <label for="inputLanguage">Idioma</label>
                  <select class="form-control" id="inputLanguage" name="inputLanguage"></select>                               
              </div>
              <!-- ./form-group -->
              <br>

              <!-- Filtrado por nombre de usuario -->
              <div class="form-group">
                  <label for="inputUserName">Usuario</label>
                  <select class="form-control" id="inputUserName" name="inputUserName"></select>
              </div>
              <!-- ./form-group -->
              <br>

              <!-- Filtrado por palabras en el texto -->
              <div class"form-group">          
                <label for="inputPalabras">Palabras en el texto</label>
                <input type="text" class="form-control" id="inputPalabras" placeholder="Escribe un texto">             
              </div>
              <!-- ./form-group -->

            </div>
            <!-- /.col -->

            <div class="col-md-6">
              <!-- Filtrado por rango de fechas--> 
              <div class="form-group">   
                <label for="inputDateFin">Fecha fin:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control" id="inputDateFin">
                </div>
                <!-- /.input group -->
              </div>
              <!-- ./form-group -->
              <br>

              <!-- Filtrado por localización -->
              <div class"form-group">          
                  <label for="inputPlace">País</label>
                  <select class="form-control" id="inputPlace" name="inputPlace"></select>             
              </div>
              <!-- ./form-group -->
              <br>

              <!-- Filtrado por hashtags -->
              <div class"form-group">          
                  <label for="inputHashtag">Hashtag</label>
                  <select class="form-control" id="inputHashtag" name="inputHashtag"></select>            
              </div>
              <!-- ./form-group -->
              <br>

              <!-- Descartar retweets -->
              <div class"form-group"> 
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="checkboxRetweet" id="optionRetweed">
                    Descartar retweet
                  </label>
                </div>
              </div>
              <!-- /.form-group -->

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-info pull-right" onclick="creaColeccionFiltrada($('#selectColeccion').val());return false;">Filtrar</button>
        </div>
        <!-- /.box-footer -->
      </form>
      <!-- /.form -->
		</div>
    <!-- /.box -->
    
    

    <!--
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-info"></i> Colección creada con éxito</h4>
      La colección tiene x tweets.
    </div>
    -->
    <!--
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-warning"></i> Seleccione al menos 3 filtros</h4>
    </div>
    -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- Funciones -->
<script type="text/javascript" src="js/funciones.js"></script>
<!-- Ajax -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>