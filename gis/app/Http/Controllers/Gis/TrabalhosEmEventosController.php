<?php

namespace Gis\Http\Controllers\Gis;

use Illuminate\Http\Request;
use Gis\Http\Controllers\Controller;

class TrabalhosEmEventosController extends Controller
{

    public function index()
    {
        $pageTitle = 'Trabalhos em Eventos';
        $pageDescription = '';
        $breadcrumbs = ['Trabalhos em Eventos' => ''];

        return view('gis.trabalhoseventos.index', compact(['pageTitle', 'pageDescription', 'breadcrumbs']));
    }

}
