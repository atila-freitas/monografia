<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 2'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap -->
    {{ Html::style('bower/bootstrap/dist/css/bootstrap.min.css') }}

    <!-- iCheck -->
    {{ Html::style('bower/iCheck/skins/square/green.css') }}

    <!-- Font Awesome -->
    {{ Html::style('css/font-awesome/css/font-awesome.min.css') }}

    <!-- DataTables -->
    {{ Html::style('https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css') }}

    <!-- Ionicons -->
    {{ Html::style('bower/Ionicons/css/ionicons.min.css') }}

    <!-- jVectorMap -->
    {{ Html::style('css/jvectormap/jquery-jvectormap-2.0.3.css') }}

    <!-- Theme style -->
    {{ Html::style('vendor/adminlte/css/AdminLTE.min.css') }}

    <!-- AdminLTE Skin -->
    {{ Html::style('vendor/adminlte/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css') }}

    <!-- My style -->
    {{ Html::style('css/custom.css') }}

    @yield('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition {{ 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : '') }}">

    @yield('body')

    <!-- jQuery -->
    {{ Html::script('bower/jquery/dist/jquery.min.js') }}

    <!-- Bootstrap -->
    {{ Html::script('bower/bootstrap/dist/js/bootstrap.min.js') }}

    <!-- DataTables -->
    {{ Html::script('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}
    {{ Html::script('https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js') }}

    <!-- SlimScroll -->
    {{ Html::script('bower/jquery-slimscroll/jquery.slimscroll.min.js') }}

    <!-- FastClick -->
    {{ Html::script('bower/fastclick/lib/fastclick.js') }}

    <!-- iCheck -->
    {{ Html::script('bower/iCheck/icheck.min.js') }}

    <!-- Chart.js -->
    {{ Html::script('bower/chart.js/dist/Chart.min.js') }}

    <!-- Chartjs-plugin-datalabels -->
    {{ Html::script('bower/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js') }}

    <!-- Chartjs-plugin-labels -->
    {{ Html::script('bower/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js') }}

    <!-- jQuery Sparklines -->
    {{ Html::script('js/jquery.sparkline/jquery.sparkline.min.js') }}

    <!-- jVectorMap -->
    {{ Html::script('js/jvectormap/jquery-jvectormap-2.0.3.min.js') }}
    {{ Html::script('js/jvectormap/jquery-jvectormap-world-mill-en.js') }}

    <!-- Custom -->
    {{ Html::script('js/custom.js') }}

    <!-- AdminLTE App -->
    {{ Html::script('vendor/adminlte/js/adminlte.min.js') }}

    @yield('js')

</body>
</html>
