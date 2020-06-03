<?php

namespace Gis\Http\Controllers;

use Gis\Models\Lattes;

class HomeController extends Controller
{

    public function index()
    {
        /*
        $result = Instituicao::limit(1)->first();
        dd($result->coordenadas_nome);

            $result = Geocoder::geocode("MA, Brasil")->limit(1)->get()->first();

            if (!$result) dd(null);

            dd($result->getCoordinates());
        */

        $pageTitle = 'Home';

        $jsonurl = "http://localhost:9000/gis/teachersFormationStatistics";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        

        $total = [
            'cadastros' => $jsonresult->professores,
            'doutorados' => $jsonresult->doutorado,
            'posdoutorados' => $jsonresult->posDoutorados
        ]; 

        return view('home', compact(['total', 'pageTitle']));
    }
    public function indica(){
        $page_title = 'Indicadores';
        return view('ind/indicaHome', compact(['page_title']));
    }
}
