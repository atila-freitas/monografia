@extends('layout.master')

@section('body')

    <div class="wrapper">

        <!-- Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ url('indicaHome') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! '<b>SIQ</b> uece' !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! '<b>SIQ</b> uece' !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Alternar Navegação</span>
                </a>
            </nav>
        </header>

        <!-- Sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('layout.partials.sidebar.menu-item', config('adminlte.menu2'), 'item')
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header no-margin">
                <h1>
                    {{ $pageTitle or "" }}
                    <small>{{ $pageDescription or null }}</small>
                </h1>
                <!-- You can dynamically generate breadcrumbs here -->
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    @if (isset($breadcrumbs))
                        @foreach($breadcrumbs as $key => $value)
                            <li class="@if($loop->last) active @endif">@if ($value != '')<a href="{{ url($value) }}">{{ $key }}</a>@else {{ $key }} @endif</li>
                        @endforeach
                    @endif
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        @include('layout.partials.footer')

    </div>
    <!-- ./wrapper -->

@stop