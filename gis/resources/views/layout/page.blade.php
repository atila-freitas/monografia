@extends('layout.master')

@section('body')

    <div class="wrapper">

        <!-- Header -->
        @include('layout.partials.header')

        <!-- Sidebar -->
        @include('layout.partials.sidebar')

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