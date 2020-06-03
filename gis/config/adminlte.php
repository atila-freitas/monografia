<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'SIQ',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => env('ADMINLTE_LOGO', '<b>SIA</b> uece'),

    'logo_mini' => env('ADMINLTE_LOGO_MINI', '<b>SIA</b>'),

    'footer' => env('ADMINLTE_FOOTER', '<strong>SIA</strong> - Sistema de Indicadores Acadêmicos da UECE'),

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => env('ADMINLTE_SKIN', 'blue'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'fixed',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    'sidebar_user_panel' => true,
    'sidebar_search_form' => true,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'GIS UECE',
        [
            'text'      => 'Titulações',
            'url'       => 'gis/titulacoes',
            'icon'      => 'address-card',
        ],
        [
            'text'      => 'Estatísticas',
            'url'       => 'gis/titulacoes/estatisticas',
            'icon'      => 'pie-chart',
        ],
    ],

    'menu2' => [
        'SIQ UECE',

        [
            'text' => 'Home',
            'url'  => 'ind/',
            'icon' => 'home',
        ],

        [
            'text' => 'Visão Geral',
            'url'  => 'ind/general',
            'icon' => 'check',
        ],
        [
            'text' => 'Centros',
            'url'  => 'ind/centers',
            'icon' => 'building',
        ],[
            'text' => 'Professores',
            'url'  => 'ind/professors',
            'icon' => 'address-card-o',
        ],
        [
            'text' => 'Qualis - Artigos',
            'url'  => 'ind/qualis',
            'icon' => 'trophy',
        ],
        [
            'text' => 'Destaques',
            'url'  => 'ind/destaques',
            'icon' => 'star',
        ],
        [
            'text' => 'Comparar',
            'url'  => 'ind/comparar',
            'icon' => 'search',
        ],
//        [
//            'text'    => 'Multilevel',
//            'icon'    => 'share',
//            'submenu' => [
//                [
//                    'text' => 'Level One',
//                    'url'  => '#',
//                ],
//                [
//                    'text'    => 'Level One',
//                    'url'     => '#',
//                    'submenu' => [
//                        [
//                            'text' => 'Level Two',
//                            'url'  => '#',
//                        ],
//                        [
//                            'text'    => 'Level Two',
//                            'url'     => '#',
//                            'submenu' => [
//                                [
//                                    'text' => 'Level Three',
//                                    'url'  => '#',
//                                ],
//                                [
//                                    'text' => 'Level Three',
//                                    'url'  => '#',
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//                [
//                    'text' => 'Level One',
//                    'url'  => '#',
//                ],
//            ],
//        ],
    ],
];
