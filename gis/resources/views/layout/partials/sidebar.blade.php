<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            @each('layout.partials.sidebar.menu-item', config('adminlte.menu'), 'item')
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>