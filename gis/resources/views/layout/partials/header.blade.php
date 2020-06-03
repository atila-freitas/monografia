<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Alternar Navegação</span>
        </a>
    </nav>
</header>